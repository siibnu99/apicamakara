<?php

namespace App\Models;

use CodeIgniter\Model;

class UserApiModel extends Model
{
    protected $table      = 'tbl_user';
    protected $primaryKey = 'id_user';

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id_user', 'fullname', 'email', 'password', 'telp', 'is_active', 'created_at', 'updated_at'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
