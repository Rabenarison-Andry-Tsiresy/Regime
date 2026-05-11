<?php

namespace App\Models;

use CodeIgniter\Model;

class CodeGoldModel extends Model
{
    protected $table = 'codes_gold';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = [
        'code',
        'actif',
        'used_by',
        'used_at',
    ];
    protected $useTimestamps = true;

    public function findValidCode(string $code): ?array
    {
        return $this->where('code', $code)
            ->where('actif', 1)
            ->where('used_by', null)
            ->first();
    }
}
