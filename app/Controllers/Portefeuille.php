<?php

namespace App\Controllers;

use App\Models\CodeRechargementModel;
use App\Models\PaiementModel;
use App\Models\PortefeuilleModel;

class Portefeuille extends BaseController
{
    public function index()
    {
        if ($redirect = $this->requireLogin()) {
            return $redirect;
        }

        $userId = (int) $this->currentUser['id'];
        $portefeuilleModel = new PortefeuilleModel();
        $portefeuille = $portefeuilleModel->getByUserId($userId);
        if (! $portefeuille) {
            $portefeuilleModel->insert([
                'user_id' => $userId,
                'solde' => 0,
            ]);
            $portefeuille = $portefeuilleModel->getByUserId($userId);
        }

        $paiements = (new PaiementModel())
            ->where('user_id', $userId)
            ->orderBy('id', 'DESC')
            ->findAll(15);

        return $this->render('portefeuille/index', [
            'title' => 'Portefeuille',
            'portefeuille' => $portefeuille,
            'paiements' => $paiements,
            'errors' => session()->getFlashdata('errors') ?? [],
        ]);
    }

    public function recharge()
    {
        if ($redirect = $this->requireLogin()) {
            return $redirect;
        }

        $rules = [
            'code' => 'required|min_length[3]|max_length[50]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $code = trim((string) $this->request->getPost('code'));
        $codeModel = new CodeRechargementModel();
        $codeRow = $codeModel->findValidCode($code);
        if (! $codeRow) {
            return redirect()->back()->withInput()->with('errors', [
                'code' => 'Code invalide ou expire.',
            ]);
        }

        $userId = (int) $this->currentUser['id'];
        $portefeuilleModel = new PortefeuilleModel();
        $portefeuille = $portefeuilleModel->getByUserId($userId);
        if (! $portefeuille) {
            $portefeuilleModel->insert([
                'user_id' => $userId,
                'solde' => 0,
            ]);
            $portefeuille = $portefeuilleModel->getByUserId($userId);
        }

        $valeur = (float) $codeRow['valeur'];
        $nouveauSolde = (float) ($portefeuille['solde'] ?? 0) + $valeur;

        $portefeuilleModel->updateSolde($userId, $nouveauSolde);
        $codeModel->update($codeRow['id'], [
            'actif' => 0,
            'used_by' => $userId,
            'used_at' => date('Y-m-d H:i:s'),
        ]);

        (new PaiementModel())->insert([
            'user_id' => $userId,
            'type' => 'recharge',
            'montant' => $valeur,
            'reference' => $code,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to('/portefeuille')->with('success', 'Recharge effectuee.');
    }
}
