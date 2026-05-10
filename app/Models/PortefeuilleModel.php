<?php

namespace App\Models;

use CodeIgniter\Model;

class PortefeuilleModel extends Model
{
    protected $table = 'portefeuilles';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['user_id', 'solde'];
    protected $useTimestamps = true;

    public function getByUserId(int $userId): ?array
    {
        return $this->where('user_id', $userId)->first();
    }

    public function updateSolde(int $userId, float $solde): bool
    {
        return (bool) $this->where('user_id', $userId)
            ->set('solde', $solde)
            ->update();
    }
}
