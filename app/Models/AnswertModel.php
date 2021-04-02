<?php

namespace App\Models;

use CodeIgniter\Model;

class AnswertModel extends Model
{
    protected $table      = 'tbl_answert';
    protected $primaryKey = 'id_answer';

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ["id_answer", "user_id", "tryout_id", "kind_tryout", "answer", "created_at", "updated_at"];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
