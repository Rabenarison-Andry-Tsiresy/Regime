<?php

namespace App\Models;

use CodeIgniter\Model;

class PaiementModel extends Model
{
    protected $table = 'paiements';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = [
        'user_id',
        'type',
        'montant',
        'reference',
        'created_at',
    ];
    protected $useTimestamps = false;
}
