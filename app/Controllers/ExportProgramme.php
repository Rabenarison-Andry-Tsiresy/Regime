<?php

namespace App\Controllers;

use App\Models\ActiviteSportiveModel;
use App\Models\HistoriqueRegimeModel;
use App\Models\ObjectifModel;
use App\Models\ProfilSanteModel;
use App\Models\RegimeModel;
use App\Models\UserModel;

class ExportProgramme extends BaseController
{
    public function index()
    {
        if ($redirect = $this->requireLogin()) {
            return $redirect;
        }

        $userId = (int) $this->currentUser['id'];
        $user = (new UserModel())->find($userId);
        $profil = (new ProfilSanteModel())->findByUserId($userId);
        $objectif = null;
        if ($profil && $profil['objectif_id']) {
            $objectif = (new ObjectifModel())->find((int) $profil['objectif_id']);
        }

        $active = (new HistoriqueRegimeModel())->getActiveByUser($userId);
        $regime = null;
        if ($active) {
            $regime = (new RegimeModel())->find((int) $active['regime_id']);
        }

        $activites = [];
        if ($profil) {
            $objectifId = $profil['objectif_id'] ?? null;
            $activites = (new ActiviteSportiveModel())->getForObjectif($objectifId ? (int) $objectifId : null);
        }

        return $this->render('export/index', [
            'title' => 'Export',
            'user' => $user,
            'profil' => $profil,
            'objectif' => $objectif,
            'activeRegime' => $active,
            'regime' => $regime,
            'activites' => $activites,
        ]);
    }
}
