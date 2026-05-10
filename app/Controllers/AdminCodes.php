<?php

namespace App\Controllers;

use App\Models\CodeRechargementModel;

class AdminCodes extends BaseController
{
    public function index()
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $codes = (new CodeRechargementModel())
            ->orderBy('id', 'DESC')
            ->findAll(50);

        return $this->render('admin/codes/index', [
            'title' => 'Codes Portefeuille',
            'codes' => $codes,
            'errors' => session()->getFlashdata('errors') ?? [],
        ]);
    }

    public function store()
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $rules = [
            'code' => 'required|min_length[3]|max_length[50]',
            'valeur' => 'required|decimal|greater_than[0]',
            'date_expiration' => 'permit_empty',
            'actif' => 'permit_empty|in_list[0,1]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $dateExpiration = $this->request->getPost('date_expiration');
        $dateExpiration = $dateExpiration !== ''
            ? date('Y-m-d H:i:s', strtotime((string) $dateExpiration))
            : null;

        (new CodeRechargementModel())->insert([
            'code' => trim((string) $this->request->getPost('code')),
            'valeur' => (float) $this->request->getPost('valeur'),
            'date_expiration' => $dateExpiration,
            'actif' => (int) ($this->request->getPost('actif') ?? 1),
        ]);

        return redirect()->to('/admin/codes')->with('success', 'Code ajoute.');
    }

    public function disable(int $id)
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        (new CodeRechargementModel())->update($id, ['actif' => 0]);

        return redirect()->to('/admin/codes')->with('success', 'Code desactive.');
    }

    public function enable(int $id)
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        (new CodeRechargementModel())->update($id, ['actif' => 1]);

        return redirect()->to('/admin/codes')->with('success', 'Code active.');
    }
}
