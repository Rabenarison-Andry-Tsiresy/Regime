<?php

namespace App\Models;

use CodeIgniter\Model;

class ProfilSanteModel extends Model
{
    protected $table = 'profil_sante';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = [
        'user_id',
        'taille_cm',
        'poids_kg',
        'objectif_id',
        'imc',
    ];
    protected $useTimestamps = true;

    public function findByUserId(int $userId): ?array
    {
        return $this->where('user_id', $userId)->first();
    }
}
