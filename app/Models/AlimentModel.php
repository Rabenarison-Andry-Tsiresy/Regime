<?php

namespace App\Models;

use CodeIgniter\Model;

class AlimentModel extends Model
{
    protected $table = 'aliments';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = [
        'nom',
        'categorie',
        'description',
        'recommandation',
        'objectif_id',
        'actif',
    ];
    protected $useTimestamps = true;

    public function getForObjectif(?int $objectifId): array
    {
        $builder = $this->where('actif', 1);

        if (! $objectifId) {
            return $builder->orderBy('nom')->findAll();
        }

        return $builder->where('objectif_id', $objectifId)->orderBy('nom')->findAll();
    }
}
