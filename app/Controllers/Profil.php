<?php

namespace App\Controllers;

use App\Models\ObjectifModel;
use App\Models\ProfilSanteModel;
use App\Models\SexeModel;
use App\Models\UserModel;

class Profil extends BaseController
{
    public function index()
    {
        if ($redirect = $this->requireLogin()) {
            return $redirect;
        }

        $userId = (int) $this->currentUser['id'];
        $userModel = new UserModel();
        $profilModel = new ProfilSanteModel();

        $user = $userModel->find($userId);
        $profil = $profilModel->findByUserId($userId);

        return $this->render('profil/index', [
            'title' => 'Profil',
            'user' => $user,
            'profil' => $profil,
            'sexes' => (new SexeModel())->orderBy('label')->findAll(),
            'objectifs' => (new ObjectifModel())->orderBy('label')->findAll(),
            'errors' => session()->getFlashdata('errors') ?? [],
        ]);
    }

    public function update()
    {
        if ($redirect = $this->requireLogin()) {
            return $redirect;
        }

        $rules = [
            'nom' => 'required|min_length[2]|max_length[120]',
            'age' => 'permit_empty|is_natural',
            'sexe_id' => 'permit_empty|is_not_unique[sexes.id]',
            'taille_cm' => 'required|decimal|greater_than[0]',
            'poids_kg' => 'required|decimal|greater_than[0]',
            'objectif_id' => 'required|is_not_unique[objectifs.id]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $userId = (int) $this->currentUser['id'];
        $nom = trim((string) $this->request->getPost('nom'));
        $age = $this->request->getPost('age') !== '' ? (int) $this->request->getPost('age') : null;
        $sexeId = $this->request->getPost('sexe_id') !== '' ? (int) $this->request->getPost('sexe_id') : null;
        $taille = (float) $this->request->getPost('taille_cm');
        $poids = (float) $this->request->getPost('poids_kg');
        $objectifId = (int) $this->request->getPost('objectif_id');

        $userModel = new UserModel();
        $userModel->update($userId, [
            'nom' => $nom,
            'age' => $age,
            'sexe_id' => $sexeId,
        ]);

        $taille_m = ($taille > 0 && $taille < 10) ? $taille : $taille / 100;
        $imc = $taille > 0 ? $poids / pow($taille_m, 2) : null;
        (new ProfilSanteModel())
            ->where('user_id', $userId)
            ->set([
                'taille_cm' => $taille,
                'poids_kg' => $poids,
                'objectif_id' => $objectifId,
                'imc' => $imc !== null ? round($imc, 2) : null,
            ])
            ->update();

        $user = $userModel->find($userId);
        if ($user) {
            $this->setSessionUser($user);
        }

        return redirect()->to('/profil')->with('success', 'Profil mis a jour.');
    }
}
