<?php

namespace App\Models;

use CodeIgniter\Model;

class SoalqModel extends Model
{
    protected $table      = 'tbl_soalq';
    protected $primaryKey = 'id_soalq';

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ["id_soalq", "quiz_id", "no_soal", "soal", "image", "pilihan1", "pilihan2", "pilihan3", "pilihan4", "pilihan5", "jawaban", "pembahasan", "created_at", "updated_at"];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
