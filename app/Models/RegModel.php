<?php

namespace App\Models;

use CodeIgniter\Model;

class RegModel extends Model
{
    protected $table      = 'regencies';
    protected $primaryKey = 'id';

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    protected $useTimestamps = false;
}
