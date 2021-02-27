<?php

namespace App\Models;

use CodeIgniter\Model;

class UnivModel extends Model
{
    protected $table      = 'tbl_univ';
    protected $primaryKey = 'univ_id';

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    protected $useTimestamps = false;
}
