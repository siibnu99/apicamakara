<?php

namespace App\Models;

use CodeIgniter\Model;

class TryoutModel extends Model
{
    protected $table      = 'tbl_tryout';
    protected $primaryKey = 'id_tryout';

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id_tryout', 'name', 'descript', 'date_start', 'time_start', 'date_end', 'time_end', 'type_tryout', 'cat_tryout', 'payment_method', 'rule1', 'rule2', 'rule3', 'rule4', 'rule5', 'price', 'q_penalaran', 't_penalaran', 'q_pemahaman', 't_pemahaman', 'q_pengetahuan', 't_pengetahuan', 'q_pengetahuank', 't_pengetahuank', 'q_sejarah', 't_sejarah', 'q_geografi', 't_geografi', 'q_sosiologi', 't_sosiologi', 'q_ekonomi', 't_ekonomi', 'q_kimia', 't_kimia', 'q_fisika', 't_fisika', 'q_biologi', 't_biologi', 'q_matematika', 't_matematika', 'created_by', 'updated_by', 'created_at', 'updated_at', 'image', 'active'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
