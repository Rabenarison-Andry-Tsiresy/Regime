<?php

namespace App\Models;

use CodeIgniter\Model;

class SexeModel extends Model
{
    protected $table = 'sexes';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['label'];
    protected $useTimestamps = true;
}
