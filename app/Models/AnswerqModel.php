<?php

namespace App\Models;

use CodeIgniter\Model;

class AnswerqModel extends Model
{
    protected $table      = 'tbl_answerq';
    protected $primaryKey = 'id_answer';

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ["id_answer", "user_id", "quiz_id", "answer", "created_at", "updated_at"];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
