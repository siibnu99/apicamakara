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
    public function getScore($data, $prodiId, $direct = false)
    {
        $SoaltModel = new SoaltModel();
        $AnswertModel = new AnswertModel();
        $ProdiModel = new ProdiModel();
        $score = 0;
        if ($direct) {
            foreach (getTypeMapel($prodiId) as $valueMapel) {
                $valueAnswert = $AnswertModel->where(['tryout_id' => $data['tryout_id'], 'user_id' => $data['user_id'], 'kind_tryout' => $valueMapel[2]])->join('tbl_tryout', 'tbl_tryout.id_tryout = tbl_answert.tryout_id')->findAll();
                if (!$valueAnswert) continue;
                if ($valueAnswert['kind_tryout'] == $valueMapel[2]) {
                    $valueAnswert['answer'] = explode(',', $valueAnswert['answer']);
                    $no = 1;
                    foreach ($valueAnswert['answer'] as $valueAnswer) {
                        $dataSoalt = $SoaltModel->where(['tryout_id' => $data['tryout_id'], 'kind_tryout' => $valueAnswert['kind_tryout'], 'no_soal' => $no])->first();
                        if ($dataSoalt['jawaban'] == $valueAnswer) {
                            $score += $dataSoalt['bobot'];
                        }
                        $no++;
                    }
                }
            }
        } else {
            $dataProdi = $ProdiModel->find($prodiId);
            if ($data['type_tryout'] == 3) {
                foreach (getTypeMapel($dataProdi['kelompok_ujian']) as $valueMapel) {
                    $valueAnswert = $AnswertModel->where(['tryout_id' => $data['tryout_id'], 'user_id' => $data['user_id'], 'kind_tryout' => $valueMapel[2]])->join('tbl_tryout', 'tbl_tryout.id_tryout = tbl_answert.tryout_id')->findAll();
                    if (!$valueAnswert) continue;
                    if ($valueAnswert['kind_tryout'] == $valueMapel[2]) {
                        $valueAnswert['answer'] = explode(',', $valueAnswert['answer']);
                        $no = 1;
                        foreach ($valueAnswert['answer'] as $valueAnswer) {
                            $dataSoalt = $SoaltModel->where(['tryout_id' => $data['tryout_id'], 'kind_tryout' => $valueAnswert['kind_tryout'], 'no_soal' => $no])->first();
                            if ($dataSoalt['jawaban'] == $valueAnswer) {
                                $score += $dataSoalt['bobot'];
                            }
                            $no++;
                        }
                    }
                }
            } else {
                $dataAnswert = $AnswertModel->where(['tryout_id' => $data['tryout_id'], 'user_id' => $data['user_id']])->join('tbl_tryout', 'tbl_tryout.id_tryout = tbl_answert.tryout_id')->findAll();
                foreach ($dataAnswert as $valueAnswert) {
                    $valueAnswert['answer'] = explode(',', $valueAnswert['answer']);
                    $no = 1;
                    foreach ($valueAnswert['answer'] as $valueAnswer) {
                        $dataSoalt = $SoaltModel->where(['tryout_id' => $data['tryout_id'], 'kind_tryout' => $valueAnswert['kind_tryout'], 'no_soal' => $no])->first();
                        if ($dataSoalt['jawaban'] == $valueAnswer) {
                            $score += $dataSoalt['bobot'];
                        }
                        $no++;
                    }
                }
            }
        }

        return $score;
    }
    public function getScoreByKind($iduser, $idtryout, $kind)
    {
        $SoaltModel = new SoaltModel();
        $AnswertModel = new AnswertModel();
        $dataAnswert = $AnswertModel->where(['tryout_id' => $idtryout, 'user_id' => $iduser, 'kind_tryout' => $kind])->join('tbl_tryout', 'tbl_tryout.id_tryout = tbl_answert.tryout_id')->first();
        $score = 0;
        if ($dataAnswert) {
            $dataAnswert['answer'] = explode(',', $dataAnswert['answer']);
            $no = 1;
            foreach ($dataAnswert['answer'] as $valueAnswer) {
                $dataSoalt = $SoaltModel->where(['tryout_id' => $idtryout, 'kind_tryout' => $dataAnswert['kind_tryout'], 'no_soal' => $no])->first();
                if ($dataSoalt['jawaban'] == $valueAnswer) {
                    $score += $dataSoalt['bobot'];
                }
                $no++;
            }
        }
        return $score;
    }
}
