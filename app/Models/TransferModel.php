<?php

namespace App\Models;

use CodeIgniter\Model;

class TransferModel extends Model
{
    protected $table      = 'tbl_transfer';
    protected $primaryKey = 'id_transfer';

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['id_transfer', 'from_id', 'to_id', 'nominal', 'created_at', 'updated_at'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
