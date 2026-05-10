<?php

namespace App\Controllers;

use App\Models\ActiviteSportiveModel;
use App\Models\PaiementModel;
use App\Models\RegimeModel;
use App\Models\UserModel;

class AdminDashboard extends BaseController
{
    public function index()
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $userCount = (new UserModel())->where('role', 'user')->countAllResults();
        $adminCount = (new UserModel())->where('role', 'admin')->countAllResults();
        $regimeCount = (new RegimeModel())->countAllResults();
        $activiteCount = (new ActiviteSportiveModel())->countAllResults();
        $paiementCount = (new PaiementModel())->countAllResults();

        return $this->render('admin/dashboard', [
            'title' => 'Dashboard Admin',
            'userCount' => $userCount,
            'adminCount' => $adminCount,
            'regimeCount' => $regimeCount,
            'activiteCount' => $activiteCount,
            'paiementCount' => $paiementCount,
        ]);
    }
}
