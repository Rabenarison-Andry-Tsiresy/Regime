<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        if ($this->isLoggedIn()) {
            return redirect()->to('/profil');
        }

        return $this->render('home/index', [
            'title' => 'Regime Alimentaire',
        ]);
    }
}
