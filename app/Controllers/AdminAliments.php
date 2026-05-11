<?php

namespace App\Controllers;

use App\Models\AlimentModel;
use App\Models\ObjectifModel;

class AdminAliments extends BaseController
{
    public function index()
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $aliments = (new AlimentModel())->orderBy('nom')->findAll();
        $objectifMap = [];
        foreach ((new ObjectifModel())->findAll() as $objectif) {
            $objectifMap[$objectif['id']] = $objectif['label'];
        }

        return $this->render('admin/aliments/index', [
            'title' => 'Admin Aliments',
            'aliments' => $aliments,
            'objectifMap' => $objectifMap,
        ]);
    }

    public function create()
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        return $this->render('admin/aliments/create', [
            'title' => 'Ajouter Aliment',
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
            'categorie' => 'permit_empty|max_length[60]',
            'description' => 'permit_empty',
            'recommandation' => 'permit_empty',
            'objectif_id' => 'permit_empty|is_not_unique[objectifs.id]',
            'actif' => 'permit_empty|in_list[0,1]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $objectifId = $this->request->getPost('objectif_id');
        $objectifId = $objectifId !== '' ? (int) $objectifId : null;

        (new AlimentModel())->insert([
            'nom' => trim((string) $this->request->getPost('nom')),
            'categorie' => trim((string) $this->request->getPost('categorie')),
            'description' => trim((string) $this->request->getPost('description')),
            'recommandation' => trim((string) $this->request->getPost('recommandation')),
            'objectif_id' => $objectifId,
            'actif' => (int) ($this->request->getPost('actif') ?? 1),
        ]);

        return redirect()->to('/admin/aliments')->with('success', 'Aliment ajoute.');
    }

    public function edit(int $id)
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $aliment = (new AlimentModel())->find($id);
        if (! $aliment) {
            return redirect()->to('/admin/aliments')->with('error', 'Aliment introuvable.');
        }

        return $this->render('admin/aliments/edit', [
            'title' => 'Modifier Aliment',
            'aliment' => $aliment,
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
            'categorie' => 'permit_empty|max_length[60]',
            'description' => 'permit_empty',
            'recommandation' => 'permit_empty',
            'objectif_id' => 'permit_empty|is_not_unique[objectifs.id]',
            'actif' => 'permit_empty|in_list[0,1]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $objectifId = $this->request->getPost('objectif_id');
        $objectifId = $objectifId !== '' ? (int) $objectifId : null;

        (new AlimentModel())->update($id, [
            'nom' => trim((string) $this->request->getPost('nom')),
            'categorie' => trim((string) $this->request->getPost('categorie')),
            'description' => trim((string) $this->request->getPost('description')),
            'recommandation' => trim((string) $this->request->getPost('recommandation')),
            'objectif_id' => $objectifId,
            'actif' => (int) ($this->request->getPost('actif') ?? 1),
        ]);

        return redirect()->to('/admin/aliments')->with('success', 'Aliment mis a jour.');
    }

    public function delete(int $id)
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        (new AlimentModel())->delete($id);

        return redirect()->to('/admin/aliments')->with('success', 'Aliment supprime.');
    }
}
