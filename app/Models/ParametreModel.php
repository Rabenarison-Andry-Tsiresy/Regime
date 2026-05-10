<?php

namespace App\Models;

use CodeIgniter\Model;

class ParametreModel extends Model
{
    protected $table = 'parametres';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['cle', 'valeur'];
    protected $useTimestamps = true;

    public function getValue(string $key, string $default = ''): string
    {
        $row = $this->where('cle', $key)->first();

        return $row ? (string) $row['valeur'] : $default;
    }

    public function setValue(string $key, string $value): bool
    {
        $row = $this->where('cle', $key)->first();
        if ($row) {
            return (bool) $this->update($row['id'], ['valeur' => $value]);
        }

        return (bool) $this->insert(['cle' => $key, 'valeur' => $value]);
    }
}
