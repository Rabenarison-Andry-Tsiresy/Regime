<?php

namespace App\Models;

use CodeIgniter\Model;

class CodeRechargementModel extends Model
{
    protected $table = 'codes_rechargement';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = [
        'code',
        'valeur',
        'date_expiration',
        'actif',
        'used_by',
        'used_at',
    ];
    protected $useTimestamps = true;

    public function findValidCode(string $code): ?array
    {
        $now = date('Y-m-d H:i:s');

        return $this->where('code', $code)
            ->where('actif', 1)
            ->groupStart()
                ->where('date_expiration', null)
                ->orWhere('date_expiration >=', $now)
            ->groupEnd()
            ->first();
    }
}
