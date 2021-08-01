<?php

namespace App\Models;

use CodeIgniter\Model;

class SoaltModel extends Model
{
    protected $table      = 'tbl_soalt';
    protected $primaryKey = 'id_soalt';

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id_soalt', 'tryout_id', 'kind_tryout', 'no_soal', 'soal', 'image', 'pilihan1', 'pilihan2', 'pilihan3', 'pilihan4', 'pilihan5', "imagepilihan1", "imagepilihan2", "imagepilihan3", "imagepilihan4", "imagepilihan5", 'jawaban', 'pembahasan', 'imagepembahasan', 'bobot', 'created_at', 'updated_at'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
