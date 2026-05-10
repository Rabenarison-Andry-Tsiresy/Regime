<?php

namespace App\Models;

use CodeIgniter\Model;

class ActiviteSportiveModel extends Model
{
    protected $table = 'activites_sportives';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = [
        'nom',
        'description',
        'objectif_id',
        'intensite',
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
