<?php

namespace App\Controllers;

use App\Models\AbonnementGoldModel;
use App\Models\CodeGoldModel;
use App\Models\PaiementModel;
use App\Models\ParametreModel;
use App\Models\PortefeuilleModel;
use App\Models\UserModel;

class Gold extends BaseController
{
    public function index()
    {
        if ($redirect = $this->requireLogin()) {
            return $redirect;
        }

        $userId = (int) $this->currentUser['id'];
        $paramModel = new ParametreModel();
        $goldPrice = (float) $paramModel->getValue('gold_price', '50');
        $discountPercent = (float) $paramModel->getValue('gold_discount_percent', '15');

        $abonnement = (new AbonnementGoldModel())->getActiveByUser($userId);
        $isGold = (int) ($this->currentUser['premium'] ?? 0) === 1 || $abonnement !== null;

        return $this->render('gold/index', [
            'title' => 'Gold',
            'goldPrice' => $goldPrice,
            'discountPercent' => $discountPercent,
            'abonnement' => $abonnement,
            'isGold' => $isGold,
            'errors' => session()->getFlashdata('errors') ?? [],
        ]);
    }

    public function subscribe()
    {
        if ($redirect = $this->requireLogin()) {
            return $redirect;
        }

        $userId = (int) $this->currentUser['id'];
        $abonnementModel = new AbonnementGoldModel();
        if ((int) ($this->currentUser['premium'] ?? 0) === 1 || $abonnementModel->getActiveByUser($userId)) {
            return redirect()->to('/gold')->with('error', 'Gold deja actif.');
        }

        $paramModel = new ParametreModel();
        $goldPrice = (float) $paramModel->getValue('gold_price', '50');

        $portefeuilleModel = new PortefeuilleModel();
        $portefeuille = $portefeuilleModel->getByUserId($userId);
        if (! $portefeuille) {
            $portefeuilleModel->insert([
                'user_id' => $userId,
                'solde' => 0,
            ]);
            $portefeuille = $portefeuilleModel->getByUserId($userId);
        }

        $solde = (float) ($portefeuille['solde'] ?? 0);
        if ($solde < $goldPrice) {
            return redirect()->to('/portefeuille')->with('error', 'Solde insuffisant pour activer Gold.');
        }

        $debut = new \DateTimeImmutable('today');
        $fin = $debut->modify('+30 days');

        $abonnementModel->insert([
            'user_id' => $userId,
            'date_debut' => $debut->format('Y-m-d'),
            'date_fin' => $fin->format('Y-m-d'),
            'prix' => $goldPrice,
            'actif' => 1,
        ]);

        $portefeuilleModel->updateSolde($userId, $solde - $goldPrice);

        (new UserModel())->update($userId, ['premium' => 1]);
        $user = (new UserModel())->find($userId);
        if ($user) {
            $this->setSessionUser($user);
        }

        (new PaiementModel())->insert([
            'user_id' => $userId,
            'type' => 'gold',
            'montant' => $goldPrice,
            'reference' => 'gold',
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to('/gold')->with('success', 'Gold active.');
    }

    public function redeem()
    {
        if ($redirect = $this->requireLogin()) {
            return $redirect;
        }

        $rules = [
            'code' => 'required|min_length[6]|max_length[50]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $userId = (int) $this->currentUser['id'];
        $abonnementModel = new AbonnementGoldModel();
        if ((int) ($this->currentUser['premium'] ?? 0) === 1 || $abonnementModel->getActiveByUser($userId)) {
            return redirect()->to('/gold')->with('error', 'Gold deja actif.');
        }

        $code = trim((string) $this->request->getPost('code'));
        $codeModel = new CodeGoldModel();
        $codeRow = $codeModel->findValidCode($code);
        if (! $codeRow) {
            return redirect()->back()->withInput()->with('errors', [
                'code' => 'Code Gold invalide ou deja utilise.',
            ]);
        }

        $paramModel = new ParametreModel();
        $goldPrice = (float) $paramModel->getValue('gold_price', '50');

        $abonnementModel->insert([
            'user_id' => $userId,
            'date_debut' => date('Y-m-d'),
            'date_fin' => null,
            'prix' => $goldPrice,
            'actif' => 1,
        ]);

        $codeModel->update($codeRow['id'], [
            'actif' => 0,
            'used_by' => $userId,
            'used_at' => date('Y-m-d H:i:s'),
        ]);

        (new UserModel())->update($userId, ['premium' => 1]);
        $user = (new UserModel())->find($userId);
        if ($user) {
            $this->setSessionUser($user);
        }

        (new PaiementModel())->insert([
            'user_id' => $userId,
            'type' => 'gold',
            'montant' => $goldPrice,
            'reference' => 'gold-code-' . $code,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to('/gold')->with('success', 'Gold active avec code.');
    }
}
