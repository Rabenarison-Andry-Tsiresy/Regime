<?php

namespace App\Models;

use CodeIgniter\Model;

class RegimeModel extends Model
{
    protected $table = 'regimes';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = [
        'nom',
        'description',
        'duree_jours',
        'prix',
        'calories_cible',
        'variation_poids',
        'pourcentage_viande',
        'pourcentage_poisson',
        'pourcentage_volaille',
        'pourcentage_legumes_verts',
        'pourcentage_fruits',
        'pourcentage_feculents',
        'objectif_id',
    ];
    protected $useTimestamps = true;

    public function getForObjectif(?int $objectifId): array
    {
        if (! $objectifId) {
            return $this->orderBy('nom')->findAll();
        }

        return $this->where('objectif_id', $objectifId)->orderBy('nom')->findAll();
    }
}
