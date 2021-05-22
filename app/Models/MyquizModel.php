<?php

namespace App\Models;

use CodeIgniter\Model;

class MyquizModel extends Model
{
    protected $table      = 'tbl_myquiz';
    protected $primaryKey = 'id_myquiz';

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id_myquiz', 'user_id', 'quiz_id'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
