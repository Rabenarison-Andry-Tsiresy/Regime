<?php

namespace App\Controllers;

use App\Models\ActiviteSportiveModel;
use App\Models\ObjectifModel;
use App\Models\ProfilSanteModel;

class Activites extends BaseController
{
    public function index()
    {
        if ($redirect = $this->requireLogin()) {
            return $redirect;
        }

        $userId = (int) $this->currentUser['id'];
        $profil = (new ProfilSanteModel())->findByUserId($userId);
        $objectifId = $profil['objectif_id'] ?? null;

        $activites = (new ActiviteSportiveModel())->getForObjectif($objectifId ? (int) $objectifId : null);

        $objectifMap = [];
        foreach ((new ObjectifModel())->findAll() as $objectif) {
            $objectifMap[$objectif['id']] = $objectif['label'];
        }

        return $this->render('activites/index', [
            'title' => 'Activites',
            'profil' => $profil,
            'activites' => $activites,
            'objectifMap' => $objectifMap,
        ]);
    }
}
