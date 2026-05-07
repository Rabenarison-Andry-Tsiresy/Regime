<?php

namespace App\Models;

use CodeIgniter\Model;

class CategorieModel extends Model
{
    protected $table         = 'categories';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $protectFields = true;
    protected $allowedFields = ['nom'];
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function tableIsReady(): bool
    {
        return $this->db->tableExists($this->table);
    }

    public function getNoms(): array
    {
        if (! $this->tableIsReady()) {
            return [];
        }

        $rows = $this->select('nom')->orderBy('nom', 'ASC')->findAll();

        return array_values(array_filter(array_map(static fn ($row) => $row['nom'], $rows)));
    }

    public function existsByNom(string $nom): bool
    {
        if (! $this->tableIsReady()) {
            return false;
        }

        return $this->where('nom', $nom)->countAllResults() > 0;
    }
}
