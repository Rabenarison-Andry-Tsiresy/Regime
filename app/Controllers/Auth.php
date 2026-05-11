<?php

namespace App\Controllers;

use App\Models\ObjectifModel;
use App\Models\PortefeuilleModel;
use App\Models\ProfilSanteModel;
use App\Models\SexeModel;
use App\Models\UserModel;

class Auth extends BaseController
{
    public function login()
    {
        if ($this->isLoggedIn()) {
            return redirect()->to('/profil');
        }

        return $this->render('auth/login', [
            'title' => 'Login',
            'errors' => session()->getFlashdata('errors') ?? [],
        ]);
    }

    public function attempt()
    {
        if ($this->isLoggedIn()) {
            return redirect()->to('/profil');
        }

        $rules = [
            'email' => 'required|valid_email',
            'password' => 'required',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $email = trim((string) $this->request->getPost('email'));
        $password = (string) $this->request->getPost('password');

        $userModel = new UserModel();
        $user = $userModel->findByEmail($email);

        if (! $user || ! password_verify($password, $user['password_hash'])) {
            return redirect()->back()->withInput()->with('errors', [
                'login' => 'Identifiants invalides.',
            ]);
        }

        $this->setSessionUser($user);

        return redirect()->to('/profil')->with('success', 'Connexion reussie.');
    }

    public function logout()
    {
        $this->session->remove('user');

        return redirect()->to('/login')->with('success', 'Deconnexion reussie.');
    }

    public function registerStep1()
    {
        if ($this->isLoggedIn()) {
            return redirect()->to('/profil');
        }

        $sexes = (new SexeModel())->orderBy('label')->findAll();

        return $this->render('auth/register_step1', [
            'title' => 'Inscription',
            'sexes' => $sexes,
            'errors' => session()->getFlashdata('errors') ?? [],
        ]);
    }

    public function storeStep1()
    {
        $rules = [
            'nom' => 'required|min_length[2]|max_length[120]',
            'email' => 'required|valid_email',
            'password' => 'required|min_length[6]',
            'sexe_id' => 'required|is_not_unique[sexes.id]',
            'age' => 'permit_empty|is_natural',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $email = trim((string) $this->request->getPost('email'));
        $userModel = new UserModel();
        if ($userModel->findByEmail($email)) {
            return redirect()->back()->withInput()->with('errors', [
                'email' => 'Adresse email deja utilisee.',
            ]);
        }

        $this->session->set('register_step1', [
            'nom' => trim((string) $this->request->getPost('nom')),
            'email' => $email,
            'password' => (string) $this->request->getPost('password'),
            'age' => $this->request->getPost('age') !== '' ? (int) $this->request->getPost('age') : null,
            'sexe_id' => (int) $this->request->getPost('sexe_id'),
        ]);

        return redirect()->to('/register/health');
    }

    public function registerStep2()
    {
        if ($this->isLoggedIn()) {
            return redirect()->to('/profil');
        }

        $step1 = $this->session->get('register_step1');
        if (! $step1) {
            return redirect()->to('/register');
        }

        $objectifs = (new ObjectifModel())->orderBy('label')->findAll();

        return $this->render('auth/register_step2', [
            'title' => 'Sante',
            'objectifs' => $objectifs,
            'errors' => session()->getFlashdata('errors') ?? [],
        ]);
    }

    public function storeStep2()
    {
        $step1 = $this->session->get('register_step1');
        if (! $step1) {
            return redirect()->to('/register');
        }

        $rules = [
            'taille_cm' => 'required|decimal|greater_than[0]',
            'poids_kg' => 'required|decimal|greater_than[0]',
            'objectif_id' => 'required|is_not_unique[objectifs.id]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $taille = (float) $this->request->getPost('taille_cm');
        $poids = (float) $this->request->getPost('poids_kg');
        $objectifId = (int) $this->request->getPost('objectif_id');

        $userModel = new UserModel();
        $userModel->insert([
            'nom' => $step1['nom'],
            'email' => $step1['email'],
            'password_hash' => password_hash($step1['password'], PASSWORD_DEFAULT),
            'age' => $step1['age'],
            'sexe_id' => $step1['sexe_id'],
            'role' => 'user',
            'premium' => 0,
        ]);

        $userId = (int) $userModel->getInsertID();
        $taille_m = ($taille > 0 && $taille < 10) ? $taille : $taille / 100;
        $imc = $taille > 0 ? $poids / pow($taille_m, 2) : null;

        (new ProfilSanteModel())->insert([
            'user_id' => $userId,
            'taille_cm' => $taille,
            'poids_kg' => $poids,
            'objectif_id' => $objectifId,
            'imc' => $imc !== null ? round($imc, 2) : null,
        ]);

        (new PortefeuilleModel())->insert([
            'user_id' => $userId,
            'solde' => 0,
        ]);

        $this->session->remove('register_step1');
        $user = $userModel->find($userId);
        if ($user) {
            $this->setSessionUser($user);
        }

        return redirect()->to('/profil')->with('success', 'Compte cree.');
    }
}
