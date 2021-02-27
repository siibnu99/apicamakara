<?php

namespace App\Models;

use CodeIgniter\Model;

class ProdiModel extends Model
{
    protected $table      = 'tbl_prodi';
    protected $primaryKey = 'id_jurusan';

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    protected $useTimestamps = false;
}
