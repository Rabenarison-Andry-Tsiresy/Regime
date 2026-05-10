<?php

namespace App\Controllers;

use App\Models\AbonnementGoldModel;
use App\Models\HistoriqueRegimeModel;
use App\Models\ObjectifModel;
use App\Models\PaiementModel;
use App\Models\ParametreModel;
use App\Models\PortefeuilleModel;
use App\Models\ProfilSanteModel;
use App\Models\RegimeModel;

class Regimes extends BaseController
{
    public function index()
    {
        if ($redirect = $this->requireLogin()) {
            return $redirect;
        }

        $userId = (int) $this->currentUser['id'];
        $profil = (new ProfilSanteModel())->findByUserId($userId);
        $objectifId = $profil['objectif_id'] ?? null;

        $regimeModel = new RegimeModel();
        $regimes = $regimeModel->getForObjectif($objectifId ? (int) $objectifId : null);

        $suggestion = null;
        if ($regimes) {
            $suggestion = $regimes[0];
            foreach ($regimes as $regime) {
                if ((int) $regime['duree_jours'] < (int) $suggestion['duree_jours']) {
                    $suggestion = $regime;
                }
            }
        }

        $objectifMap = [];
        foreach ((new ObjectifModel())->findAll() as $objectif) {
            $objectifMap[$objectif['id']] = $objectif['label'];
        }

        [$isGold, $discountPercent] = $this->getGoldStatus($userId);
        $activeRegime = (new HistoriqueRegimeModel())->getActiveByUser($userId);
        $activeRegimeDetails = null;
        if ($activeRegime) {
            $activeRegimeDetails = $regimeModel->find((int) $activeRegime['regime_id']);
        }

        return $this->render('regimes/index', [
            'title' => 'Regimes',
            'profil' => $profil,
            'regimes' => $regimes,
            'suggestion' => $suggestion,
            'objectifMap' => $objectifMap,
            'activeRegime' => $activeRegime,
            'activeRegimeDetails' => $activeRegimeDetails,
            'isGold' => $isGold,
            'discountPercent' => $discountPercent,
        ]);
    }

    public function show(int $id)
    {
        if ($redirect = $this->requireLogin()) {
            return $redirect;
        }

        $regime = (new RegimeModel())->find($id);
        if (! $regime) {
            return redirect()->to('/regimes')->with('error', 'Regime introuvable.');
        }

        [$isGold, $discountPercent] = $this->getGoldStatus((int) $this->currentUser['id']);

        return $this->render('regimes/show', [
            'title' => 'Regime',
            'regime' => $regime,
            'isGold' => $isGold,
            'discountPercent' => $discountPercent,
        ]);
    }

    public function apply(int $id)
    {
        if ($redirect = $this->requireLogin()) {
            return $redirect;
        }

        $userId = (int) $this->currentUser['id'];
        $regimeModel = new RegimeModel();
        $regime = $regimeModel->find($id);
        if (! $regime) {
            return redirect()->to('/regimes')->with('error', 'Regime introuvable.');
        }

        $active = (new HistoriqueRegimeModel())->getActiveByUser($userId);
        if ($active) {
            return redirect()->to('/regimes')->with('error', 'Vous avez deja un regime actif.');
        }

        [$isGold, $discountPercent] = $this->getGoldStatus($userId);

        $prix = (float) $regime['prix'];
        $remise = $isGold ? round($prix * ((float) $discountPercent / 100), 2) : 0.0;
        $prixFinal = max(0, $prix - $remise);

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
        if ($solde < $prixFinal) {
            return redirect()->to('/portefeuille')->with('error', 'Solde insuffisant pour acheter ce regime.');
        }

        $debut = new \DateTimeImmutable('today');
        $fin = $debut->modify('+' . (int) $regime['duree_jours'] . ' days');

        (new HistoriqueRegimeModel())->insert([
            'user_id' => $userId,
            'regime_id' => (int) $regime['id'],
            'date_debut' => $debut->format('Y-m-d'),
            'date_fin' => $fin->format('Y-m-d'),
            'prix_applique' => $prixFinal,
            'remise_appliquee' => $remise,
        ]);

        $portefeuilleModel->updateSolde($userId, $solde - $prixFinal);

        (new PaiementModel())->insert([
            'user_id' => $userId,
            'type' => 'regime',
            'montant' => $prixFinal,
            'reference' => 'regime-' . $regime['id'],
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to('/regimes')->with('success', 'Regime active.');
    }

    private function getGoldStatus(int $userId): array
    {
        $param = new ParametreModel();
        $discountPercent = (float) $param->getValue('gold_discount_percent', '15');

        $isGold = (int) ($this->currentUser['premium'] ?? 0) === 1;
        if (! $isGold) {
            $active = (new AbonnementGoldModel())->getActiveByUser($userId);
            $isGold = $active !== null;
        }

        return [$isGold, $discountPercent];
    }
}
