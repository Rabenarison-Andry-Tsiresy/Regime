<?php

namespace App\Controllers;

use App\Models\UserModel;

class AdminAuth extends BaseController
{
    public function login()
    {
        if ($this->isLoggedIn() && ($this->currentUser['role'] ?? 'user') === 'admin') {
            return redirect()->to('/admin');
        }

        return $this->render('admin/login', [
            'title' => 'Admin Login',
            'errors' => session()->getFlashdata('errors') ?? [],
        ]);
    }

    public function attempt()
    {
        $rules = [
            'email' => 'required|valid_email',
            'password' => 'required',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $email = trim((string) $this->request->getPost('email'));
        $password = (string) $this->request->getPost('password');

        $user = (new UserModel())->findByEmail($email);
        if (! $user || ! password_verify($password, $user['password_hash'])) {
            return redirect()->back()->withInput()->with('errors', [
                'login' => 'Identifiants invalides.',
            ]);
        }

        if (($user['role'] ?? 'user') !== 'admin') {
            return redirect()->back()->withInput()->with('errors', [
                'login' => 'Compte admin requis.',
            ]);
        }

        $this->setSessionUser($user);

        return redirect()->to('/admin')->with('success', 'Connexion admin reussie.');
    }

    public function logout()
    {
        $this->session->remove('user');

        return redirect()->to('/admin/login')->with('success', 'Deconnexion admin reussie.');
    }
}
