<?php

namespace App\Models;

use CodeIgniter\Model;

class ProvModel extends Model
{
    protected $table      = 'provinces';
    protected $primaryKey = 'id';

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id', 'name'];

    protected $useTimestamps = false;
}
