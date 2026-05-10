<?php

namespace App\Models;

use CodeIgniter\Model;

class HistoriqueRegimeModel extends Model
{
    protected $table = 'historique_regimes';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = [
        'user_id',
        'regime_id',
        'date_debut',
        'date_fin',
        'prix_applique',
        'remise_appliquee',
    ];
    protected $useTimestamps = true;

    public function getActiveByUser(int $userId): ?array
    {
        $today = date('Y-m-d');

        return $this->where('user_id', $userId)
            ->where('date_fin >=', $today)
            ->orderBy('date_debut', 'DESC')
            ->first();
    }
}
