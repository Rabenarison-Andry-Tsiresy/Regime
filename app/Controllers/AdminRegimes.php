<?php

namespace App\Controllers;

use App\Models\ObjectifModel;
use App\Models\RegimeModel;

class AdminRegimes extends BaseController
{
    public function index()
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $regimes = (new RegimeModel())->orderBy('nom')->findAll();
        $objectifMap = [];
        foreach ((new ObjectifModel())->findAll() as $objectif) {
            $objectifMap[$objectif['id']] = $objectif['label'];
        }

        return $this->render('admin/regimes/index', [
            'title' => 'Admin Regimes',
            'regimes' => $regimes,
            'objectifMap' => $objectifMap,
        ]);
    }

    public function create()
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        return $this->render('admin/regimes/create', [
            'title' => 'Ajouter Regime',
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
            'duree_jours' => 'required|is_natural_no_zero',
            'prix' => 'required|decimal|greater_than[0]',
            'calories_cible' => 'required|is_natural_no_zero',
            'variation_poids' => 'permit_empty|decimal',
            'pourcentage_viande' => 'required|is_natural|less_than_equal_to[100]',
            'pourcentage_poisson' => 'required|is_natural|less_than_equal_to[100]',
            'pourcentage_volaille' => 'required|is_natural|less_than_equal_to[100]',
            'pourcentage_legumes_verts' => 'required|is_natural|less_than_equal_to[100]',
            'pourcentage_fruits' => 'required|is_natural|less_than_equal_to[100]',
            'pourcentage_feculents' => 'required|is_natural|less_than_equal_to[100]',
            'objectif_id' => 'permit_empty|is_not_unique[objectifs.id]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $compositionTotal = (int) $this->request->getPost('pourcentage_viande')
            + (int) $this->request->getPost('pourcentage_poisson')
            + (int) $this->request->getPost('pourcentage_volaille')
            + (int) $this->request->getPost('pourcentage_legumes_verts')
            + (int) $this->request->getPost('pourcentage_fruits')
            + (int) $this->request->getPost('pourcentage_feculents');
        if ($compositionTotal !== 100) {
            return redirect()->back()->withInput()->with('errors', [
                'composition' => 'La somme des pourcentages doit faire 100%.',
            ]);
        }

        $objectifId = $this->request->getPost('objectif_id');
        $objectifId = $objectifId !== '' ? (int) $objectifId : null;

        (new RegimeModel())->insert([
            'nom' => trim((string) $this->request->getPost('nom')),
            'description' => trim((string) $this->request->getPost('description')),
            'duree_jours' => (int) $this->request->getPost('duree_jours'),
            'prix' => (float) $this->request->getPost('prix'),
            'calories_cible' => (int) $this->request->getPost('calories_cible'),
            'variation_poids' => $this->request->getPost('variation_poids') !== ''
                ? (float) $this->request->getPost('variation_poids')
                : null,
            'pourcentage_viande' => (int) $this->request->getPost('pourcentage_viande'),
            'pourcentage_poisson' => (int) $this->request->getPost('pourcentage_poisson'),
            'pourcentage_volaille' => (int) $this->request->getPost('pourcentage_volaille'),
            'pourcentage_legumes_verts' => (int) $this->request->getPost('pourcentage_legumes_verts'),
            'pourcentage_fruits' => (int) $this->request->getPost('pourcentage_fruits'),
            'pourcentage_feculents' => (int) $this->request->getPost('pourcentage_feculents'),
            'objectif_id' => $objectifId,
        ]);

        return redirect()->to('/admin/regimes')->with('success', 'Regime ajoute.');
    }

    public function edit(int $id)
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $regime = (new RegimeModel())->find($id);
        if (! $regime) {
            return redirect()->to('/admin/regimes')->with('error', 'Regime introuvable.');
        }

        return $this->render('admin/regimes/edit', [
            'title' => 'Modifier Regime',
            'regime' => $regime,
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
            'duree_jours' => 'required|is_natural_no_zero',
            'prix' => 'required|decimal|greater_than[0]',
            'calories_cible' => 'required|is_natural_no_zero',
            'variation_poids' => 'permit_empty|decimal',
            'pourcentage_viande' => 'required|is_natural|less_than_equal_to[100]',
            'pourcentage_poisson' => 'required|is_natural|less_than_equal_to[100]',
            'pourcentage_volaille' => 'required|is_natural|less_than_equal_to[100]',
            'pourcentage_legumes_verts' => 'required|is_natural|less_than_equal_to[100]',
            'pourcentage_fruits' => 'required|is_natural|less_than_equal_to[100]',
            'pourcentage_feculents' => 'required|is_natural|less_than_equal_to[100]',
            'objectif_id' => 'permit_empty|is_not_unique[objectifs.id]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $compositionTotal = (int) $this->request->getPost('pourcentage_viande')
            + (int) $this->request->getPost('pourcentage_poisson')
            + (int) $this->request->getPost('pourcentage_volaille')
            + (int) $this->request->getPost('pourcentage_legumes_verts')
            + (int) $this->request->getPost('pourcentage_fruits')
            + (int) $this->request->getPost('pourcentage_feculents');
        if ($compositionTotal !== 100) {
            return redirect()->back()->withInput()->with('errors', [
                'composition' => 'La somme des pourcentages doit faire 100%.',
            ]);
        }

        $objectifId = $this->request->getPost('objectif_id');
        $objectifId = $objectifId !== '' ? (int) $objectifId : null;

        (new RegimeModel())->update($id, [
            'nom' => trim((string) $this->request->getPost('nom')),
            'description' => trim((string) $this->request->getPost('description')),
            'duree_jours' => (int) $this->request->getPost('duree_jours'),
            'prix' => (float) $this->request->getPost('prix'),
            'calories_cible' => (int) $this->request->getPost('calories_cible'),
            'variation_poids' => $this->request->getPost('variation_poids') !== ''
                ? (float) $this->request->getPost('variation_poids')
                : null,
            'pourcentage_viande' => (int) $this->request->getPost('pourcentage_viande'),
            'pourcentage_poisson' => (int) $this->request->getPost('pourcentage_poisson'),
            'pourcentage_volaille' => (int) $this->request->getPost('pourcentage_volaille'),
            'pourcentage_legumes_verts' => (int) $this->request->getPost('pourcentage_legumes_verts'),
            'pourcentage_fruits' => (int) $this->request->getPost('pourcentage_fruits'),
            'pourcentage_feculents' => (int) $this->request->getPost('pourcentage_feculents'),
            'objectif_id' => $objectifId,
        ]);

        return redirect()->to('/admin/regimes')->with('success', 'Regime mis a jour.');
    }

    public function delete(int $id)
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        (new RegimeModel())->delete($id);

        return redirect()->to('/admin/regimes')->with('success', 'Regime supprime.');
    }
}
