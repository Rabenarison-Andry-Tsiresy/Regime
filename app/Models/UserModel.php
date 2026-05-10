<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'utilisateurs';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = [
        'nom',
        'email',
        'password_hash',
        'age',
        'sexe_id',
        'role',
        'premium',
    ];
    protected $useTimestamps = true;

    protected $validationRules = [
        'nom' => 'required|min_length[2]|max_length[120]',
        'email' => 'required|valid_email|max_length[190]|is_unique[utilisateurs.email,id,{id}]',
        'password_hash' => 'required',
    ];

    public function findByEmail(string $email): ?array
    {
        return $this->where('email', $email)->first();
    }
}
