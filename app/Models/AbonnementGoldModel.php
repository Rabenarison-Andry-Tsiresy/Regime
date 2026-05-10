<?php

namespace App\Models;

use CodeIgniter\Model;

class AbonnementGoldModel extends Model
{
    protected $table = 'abonnements_gold';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = [
        'user_id',
        'date_debut',
        'date_fin',
        'prix',
        'actif',
    ];
    protected $useTimestamps = true;

    public function getActiveByUser(int $userId): ?array
    {
        return $this->where('user_id', $userId)
            ->where('actif', 1)
            ->orderBy('date_debut', 'DESC')
            ->first();
    }
}
