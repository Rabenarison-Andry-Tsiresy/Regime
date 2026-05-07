<?php

namespace App\Models;

use CodeIgniter\Model;

class LivreModel extends Model
{
    protected $table            = 'livres';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'titre',
        'auteur',
        'isbn',
        'annee_publication',
        'categorie',
        'resume',
        'couverture',
        'statut',
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules = [
        'titre'             => 'required|min_length[3]',
        'auteur'            => 'required',
        'isbn'              => 'required|is_unique[livres.isbn]',
        'annee_publication' => 'required|integer',
        'categorie'         => 'required',
    ];

    protected $validationMessages = [
        'titre' => [
            'required'   => 'Le titre est obligatoire.',
            'min_length' => 'Le titre doit contenir au moins 3 caracteres.',
        ],
        'auteur' => [
            'required' => 'L\'auteur est obligatoire.',
        ],
        'isbn' => [
            'required'  => 'L\'ISBN est obligatoire.',
            'is_unique' => 'Cet ISBN existe deja dans la base de donnees.',
        ],
        'annee_publication' => [
            'required' => 'L\'annee de publication est obligatoire.',
            'integer'  => 'L\'annee de publication doit etre un nombre entier.',
        ],
        'categorie' => [
            'required' => 'La categorie est obligatoire.',
        ],
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    public function isPublicationYearValid(int $year): bool
    {
        return $year <= (int) date('Y');
    }

    public function search(?string $keyword = null, ?string $categorie = null)
    {
        $builder = $this->builder();

        if (! empty($keyword)) {
            $builder->like('titre', $keyword);
        }

        if (! empty($categorie)) {
            $builder->where('categorie', $categorie);
        }

        return $builder->orderBy('created_at', 'DESC');
    }

    public function getPaginatedLivres(int $perPage = 10): array
    {
        return $this->orderBy('created_at', 'DESC')->paginate($perPage);
    }

    public function getCategories(): array
    {
        $rows = $this->select('categorie')->distinct()->orderBy('categorie', 'ASC')->findAll();

        return array_values(array_filter(array_map(static fn ($row) => $row['categorie'], $rows)));
    }
}
