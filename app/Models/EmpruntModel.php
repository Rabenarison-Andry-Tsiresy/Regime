<?php

namespace App\Models;

use CodeIgniter\Model;

class EmpruntModel extends Model
{
    protected $table            = 'emprunts';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $protectFields    = true;
    protected $allowedFields    = ['livre_id', 'emprunteur', 'date_emprunt', 'date_retour'];
    protected $useTimestamps    = true;
    protected $dateFormat       = 'datetime';
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';

    public function getDernierEmpruntByLivre(int $livreId): ?array
    {
        return $this->where('livre_id', $livreId)
            ->orderBy('date_emprunt', 'DESC')
            ->orderBy('id', 'DESC')
            ->first();
    }

    public function getEmpruntActifByLivre(int $livreId): ?array
    {
        return $this->where('livre_id', $livreId)
            ->where('date_retour', null)
            ->orderBy('date_emprunt', 'DESC')
            ->orderBy('id', 'DESC')
            ->first();
    }
}
