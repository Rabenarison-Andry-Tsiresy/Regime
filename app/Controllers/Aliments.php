<?php

namespace App\Controllers;

use App\Models\AlimentModel;
use App\Models\ObjectifModel;
use App\Models\ProfilSanteModel;

class Aliments extends BaseController
{
    public function index()
    {
        if ($redirect = $this->requireLogin()) {
            return $redirect;
        }

        $userId = (int) $this->currentUser['id'];
        $profil = (new ProfilSanteModel())->findByUserId($userId);
        $objectifId = $profil['objectif_id'] ?? null;

        $aliments = (new AlimentModel())->getForObjectif($objectifId ? (int) $objectifId : null);

        $objectifMap = [];
        foreach ((new ObjectifModel())->findAll() as $objectif) {
            $objectifMap[$objectif['id']] = $objectif['label'];
        }

        return $this->render('aliments/index', [
            'title' => 'Aliments',
            'profil' => $profil,
            'aliments' => $aliments,
            'objectifMap' => $objectifMap,
        ]);
    }
}
