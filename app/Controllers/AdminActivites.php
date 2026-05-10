<?php

namespace App\Controllers;

use App\Models\ActiviteSportiveModel;
use App\Models\ObjectifModel;

class AdminActivites extends BaseController
{
    public function index()
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $activites = (new ActiviteSportiveModel())->orderBy('nom')->findAll();
        $objectifMap = [];
        foreach ((new ObjectifModel())->findAll() as $objectif) {
            $objectifMap[$objectif['id']] = $objectif['label'];
        }

        return $this->render('admin/activites/index', [
            'title' => 'Admin Activites',
            'activites' => $activites,
            'objectifMap' => $objectifMap,
        ]);
    }

    public function create()
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        return $this->render('admin/activites/create', [
            'title' => 'Ajouter Activite',
            'objectifs' => (new ObjectifModel())->orderBy('label')->findAll(),
            'errors' => session()->getFlashdata('errors') ?? [],
        ]);
    }

    public function store()
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $rules = [
            'nom' => 'required|min_length[2]|max_length[120]',
            'description' => 'permit_empty',
            'intensite' => 'permit_empty|max_length[20]',
            'objectif_id' => 'permit_empty|is_not_unique[objectifs.id]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $objectifId = $this->request->getPost('objectif_id');
        $objectifId = $objectifId !== '' ? (int) $objectifId : null;

        (new ActiviteSportiveModel())->insert([
            'nom' => trim((string) $this->request->getPost('nom')),
            'description' => trim((string) $this->request->getPost('description')),
            'intensite' => trim((string) $this->request->getPost('intensite')),
            'objectif_id' => $objectifId,
        ]);

        return redirect()->to('/admin/activites')->with('success', 'Activite ajoutee.');
    }

    public function edit(int $id)
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $activite = (new ActiviteSportiveModel())->find($id);
        if (! $activite) {
            return redirect()->to('/admin/activites')->with('error', 'Activite introuvable.');
        }

        return $this->render('admin/activites/edit', [
            'title' => 'Modifier Activite',
            'activite' => $activite,
            'objectifs' => (new ObjectifModel())->orderBy('label')->findAll(),
            'errors' => session()->getFlashdata('errors') ?? [],
        ]);
    }

    public function update(int $id)
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $rules = [
            'nom' => 'required|min_length[2]|max_length[120]',
            'description' => 'permit_empty',
            'intensite' => 'permit_empty|max_length[20]',
            'objectif_id' => 'permit_empty|is_not_unique[objectifs.id]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $objectifId = $this->request->getPost('objectif_id');
        $objectifId = $objectifId !== '' ? (int) $objectifId : null;

        (new ActiviteSportiveModel())->update($id, [
            'nom' => trim((string) $this->request->getPost('nom')),
            'description' => trim((string) $this->request->getPost('description')),
            'intensite' => trim((string) $this->request->getPost('intensite')),
            'objectif_id' => $objectifId,
        ]);

        return redirect()->to('/admin/activites')->with('success', 'Activite mise a jour.');
    }

    public function delete(int $id)
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        (new ActiviteSportiveModel())->delete($id);

        return redirect()->to('/admin/activites')->with('success', 'Activite supprimee.');
    }
}
