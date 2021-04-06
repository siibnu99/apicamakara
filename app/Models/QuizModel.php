<?php

namespace App\Models;

use CodeIgniter\Model;

class QuizModel extends Model
{
    protected $table      = 'tbl_quiz';
    protected $primaryKey = 'id_quiz';

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ["id_quiz", "name", "descript", "image", "date_start", "time_start", "date_end", "time_end", "class", "mapel", "t_mapel", "q_mapel", "kuota", "media", "link", "password", "date_start_m", "time_start_m", "updated_by", "created_by", "update_at", "created_at"];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
