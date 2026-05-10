<?php

namespace App\Controllers;

use App\Models\ParametreModel;
use App\Models\ProfilSanteModel;

class Imc extends BaseController
{
    public function index()
    {
        if ($redirect = $this->requireLogin()) {
            return $redirect;
        }

        $userId = (int) $this->currentUser['id'];
        $profil = (new ProfilSanteModel())->findByUserId($userId);
        if (! $profil) {
            return redirect()->to('/profil')->with('error', 'Profil de sante manquant.');
        }

        $taille = (float) $profil['taille_cm'];
        $poids = (float) $profil['poids_kg'];
        $imc = $taille > 0 ? $poids / pow($taille / 100, 2) : 0.0;

        $paramModel = new ParametreModel();
        $under = (float) $paramModel->getValue('imc_underweight_max', '18.5');
        $normal = (float) $paramModel->getValue('imc_normal_max', '24.9');
        $over = (float) $paramModel->getValue('imc_overweight_max', '29.9');

        $categorie = 'Obesite';
        $recommandation = 'Objectif perte de poids recommande.';

        if ($imc < $under) {
            $categorie = 'Insuffisant';
            $recommandation = 'Objectif prise de poids recommande.';
        } elseif ($imc <= $normal) {
            $categorie = 'Normal';
            $recommandation = 'Objectif maintien recommande.';
        } elseif ($imc <= $over) {
            $categorie = 'Surpoids';
            $recommandation = 'Objectif perte de poids recommande.';
        }

        return $this->render('imc/index', [
            'title' => 'IMC',
            'imc' => round($imc, 2),
            'categorie' => $categorie,
            'recommandation' => $recommandation,
            'profil' => $profil,
        ]);
    }
}
