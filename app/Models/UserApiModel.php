<?php

namespace App\Models;

use CodeIgniter\Model;

class UserApiModel extends Model
{
    protected $table      = 'tbl_user';
    protected $primaryKey = 'id_user';

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id_user', 'image', 'fullname', 'email', 'password', 'firstname', 'lastname', 'school', 'graduate', 'saldo', 'telp', 'province_id', 'regency_id', 'address', 'univ1_id', 'prodi1_id', 'univ2_id', 'prodi2_id', 'is_active', 'created_at', 'updated_at'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
