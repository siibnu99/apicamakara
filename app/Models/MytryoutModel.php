<?php

namespace App\Models;

use CodeIgniter\Model;

class MytryoutModel extends Model
{
    protected $table      = 'tbl_mytryout';
    protected $primaryKey = 'id_mytryout';

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id_mytryout', 'user_id', 'tryout_id', 'created_at', 'updated_at'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}