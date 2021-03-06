<?php

namespace App\Models;

use CodeIgniter\Model;

class TopupModel extends Model
{
    protected $table      = 'tbl_topup';
    protected $primaryKey = 'id_topup';

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['id_topup', 'id_user', 'bank_id', 'nominal', 'image', 'status', 'created_at', 'updated_at'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
