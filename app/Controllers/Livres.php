<?php

namespace App\Controllers;

use App\Models\CategorieModel;
use App\Models\EmpruntModel;
use App\Models\LivreModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Livres extends BaseController
{
    public function index()
    {
        $model = new LivreModel();
        $categorieModel = new CategorieModel();

        $keyword = trim((string) $this->request->getGet('q'));
        $categorie = trim((string) $this->request->getGet('categorie'));

        if ($keyword !== '' || $categorie !== '') {
            $livres = $model->search($keyword, $categorie)->get()->getResultArray();
            $pager = null;
        } else {
            $livres = $model->getPaginatedLivres(10);
            $pager = $model->pager;
        }

        $categories = $this->loadCategories($categorieModel, $model);

        return $this->render('livres/index', [
            'title'      => 'Catalogue de la bibliotheque',
            'livres'     => $livres,
            'pager'      => $pager,
            'keyword'    => $keyword,
            'categorie'  => $categorie,
            'categories' => $categories,
        ]);
    }

    public function show(int $id)
    {
        $livreModel = new LivreModel();
        $empruntModel = new EmpruntModel();

        $livre = $livreModel->find($id);
        if (! $livre) {
            throw PageNotFoundException::forPageNotFound('Livre introuvable');
        }

        $dernierEmprunt = $empruntModel->getDernierEmpruntByLivre($id);

        return $this->render('livres/show', [
            'title'          => 'Fiche livre',
            'livre'          => $livre,
            'dernierEmprunt' => $dernierEmprunt,
        ]);
    }

    public function create()
    {
        $livreModel = new LivreModel();
        $categorieModel = new CategorieModel();

        return $this->render('livres/create', [
            'title'      => 'Ajouter un livre',
            'categories' => $this->loadCategories($categorieModel, $livreModel),
            'errors'     => session()->getFlashdata('errors') ?? [],
        ]);
    }

    public function store()
    {
        $model = new LivreModel();
        $categorieModel = new CategorieModel();

        $annee = (int) $this->request->getPost('annee_publication');
        if (! $model->isPublicationYearValid($annee)) {
            return redirect()->back()->withInput()->with('errors', [
                'annee_publication' => 'L\'annee de publication ne peut pas etre dans le futur.',
            ]);
        }

        $categorie = trim((string) $this->request->getPost('categorie'));
        if ($categorieModel->tableIsReady() && ! $categorieModel->existsByNom($categorie)) {
            return redirect()->back()->withInput()->with('errors', [
                'categorie' => 'La categorie selectionnee est invalide.',
            ]);
        }

        $data = [
            'titre'             => trim((string) $this->request->getPost('titre')),
            'auteur'            => trim((string) $this->request->getPost('auteur')),
            'isbn'              => trim((string) $this->request->getPost('isbn')),
            'annee_publication' => $annee,
            'categorie'         => $categorie,
            'resume'            => trim((string) $this->request->getPost('resume')),
            'statut'            => 'disponible',
        ];

        $couverture = $this->request->getFile('couverture');
        if ($couverture && $couverture->isValid() && ! $couverture->hasMoved()) {
            $rules = [
                'couverture' => [
                    'label' => 'Couverture',
                    'rules' => 'is_image[couverture]|mime_in[couverture,image/jpg,image/jpeg,image/png,image/webp]|max_size[couverture,2048]',
                ],
            ];

            if (! $this->validateData([], $rules)) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }

            $filename = $couverture->getRandomName();
            $couverture->move(FCPATH . 'uploads', $filename);
            $data['couverture'] = $filename;
        }

        if (! $model->insert($data)) {
            return redirect()->back()->withInput()->with('errors', $model->errors());
        }

        return redirect()->to('/')->with('success', 'Livre ajoute avec succes.');
    }

    public function delete(int $id)
    {
        $model = new LivreModel();
        $livre = $model->find($id);

        if (! $livre) {
            return redirect()->to('/')->with('error', 'Livre introuvable.');
        }

        $model->delete($id);

        return redirect()->to('/')->with('success', 'Livre supprime avec succes.');
    }

    private function loadCategories(CategorieModel $categorieModel, LivreModel $livreModel): array
    {
        $categories = $categorieModel->getNoms();
        if ($categories === []) {
            return $livreModel->getCategories();
        }

        return $categories;
    }
}
