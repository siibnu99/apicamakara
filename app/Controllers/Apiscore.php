<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use \App\Libraries\Uuid;
use \App\Libraries\Tokenjwt;
use App\Models\UserApiModel;
use App\Models\TryoutModel;
use App\Models\AnswertModel;
use App\Models\SoaltModel;
use App\Models\UnivModel;
use App\Models\ProdiModel;
use CodeIgniter\Database\MySQLi\Result;

class Apiscore extends ResourceController
{
    protected $format       = 'json';
    protected $modelName    = 'App\Models\SoaltModel';
    private $TryoutModel;
    public function __construct()
    {

        $this->UserapiModel = new UserApiModel;
        $this->TryoutModel = new TryoutModel;
        $this->AnswertModel = new AnswertModel;
        $this->SoaltModel = new SoaltModel;
        $this->UnivModel = new UnivModel;
        $this->ProdiModel = new ProdiModel;
    }
    public function index($userId = NULL, $idTryout = NULL)
    {
        helper('menu');
        if ($userId && $idTryout) {
            $tryout = $this->TryoutModel->find($idTryout);
            $mapel = getTypeMapel($tryout['type_tryout']);
            $result = [];
            foreach ($mapel as $item) {
                $dataJawaban = $this->AnswertModel->where(['user_id' => $userId, 'tryout_id' => $idTryout, 'kind_tryout' => $item[1]])->first();
                if ($dataJawaban) {
                    $dataJawaban = explode(',', $dataJawaban['answer']);
                    $nilai = 0;
                    $indexJawaban = 1;
                    foreach ($dataJawaban as $jawabanC) {
                        if ($dataBobot = $this->SoaltModel->where(['tryout_id' => $idTryout, 'kind_tryout' => $item[1], 'no_soal' => $indexJawaban, 'jawaban' => $jawabanC])->first())
                            $nilai += $dataBobot['bobot'];
                        $indexJawaban++;
                    }
                } else {
                    $nilai = 0;
                }
                $result[] = [
                    'nama' => $item[0],
                    'nilai' => $nilai,
                ];
            }
            $response = [
                'status' => 200,
                'data' => $result,
                'id_tryout' => $idTryout,
                'nama_tryout' => $tryout['name']
            ];
        } else {
            $response = [
                'status' => 200,
                'data' => "Data Kosong",
            ];
        }
        return $this->respond($response, 200);
    }
    public function boardTryoutAll($idTryout = NULL)
    {
        helper('menu');
        if ($idTryout) {
            $tryout = $this->TryoutModel->find($idTryout);
            $mapel = getTypeMapel($tryout['type_tryout']);
            $dataUserAnswer = $this->AnswertModel->distinct("user_id")->where(['tryout_id' => $idTryout])->findAll();
            $dataResult = [];
            $arrUser = [];
            foreach ($dataUserAnswer as $UserAnswer) {
                $result = [];
                $totalNilai = 0;
                $sama = false;
                foreach ($arrUser as $arrUsers) {
                    if ($UserAnswer['user_id'] == $arrUsers) {
                        $sama = true;
                    }
                }
                $arrUser[] = $UserAnswer['user_id'];
                if (!$sama) {
                    foreach ($mapel as $item) {
                        $dataJawaban = $this->AnswertModel->where(['user_id' => $UserAnswer['user_id'], 'tryout_id' => $idTryout, 'kind_tryout' => $item[1]])->first();
                        if ($dataJawaban) {
                            $dataJawaban = explode(',', $dataJawaban['answer']);
                            $nilai = 0;
                            $indexJawaban = 1;
                            foreach ($dataJawaban as $jawabanC) {
                                if ($dataBobot = $this->SoaltModel->where(['tryout_id' => $idTryout, 'kind_tryout' => $item[1], 'no_soal' => $indexJawaban, 'jawaban' => $jawabanC])->first())
                                    $nilai += $dataBobot['bobot'];
                                $indexJawaban++;
                            }
                        } else {
                            $nilai = 0;
                        }
                        $totalNilai += $nilai;
                        $result[] = [
                            'nama' => $item[0],
                            'nilai' => $nilai,
                        ];
                    }
                    $dataUser = $this->UserapiModel->find($UserAnswer['user_id']);
                    if ($dataUser['univ1_id']) {
                        $univ = $this->UnivModel->find($dataUser['univ1_id'])['name'];
                        $univid = $this->UnivModel->find($dataUser['univ1_id'])['univ_id'];
                        $prodi = $this->ProdiModel->find($dataUser['prodi1_id'])['name'];
                    } else {
                        $univ = "Tidak Memilih";
                        $prodi = "Tidak Memilih";
                        $univid = 0;
                    }
                    $dataResult[] = [
                        'nama_user' => $dataUser['fullname'],
                        'univ' => $univ,
                        'univ_id' => $univid,
                        'prodi' => $prodi,
                        'score' => $result,
                        'total' => $totalNilai,
                    ];
                }
            }
            if (count($dataResult) > 1) {
                for ($i = 0; $i < count($dataResult) - 1; $i++) {
                    if ($dataResult[$i]['total'] < $dataResult[$i + 1]['total']) {
                        $temp = $dataResult[$i];
                        $dataResult[$i] = $dataResult[$i + 1];
                        $dataResult[$i + 1] = $temp;
                    }
                }
            }
            $response = [
                'status' => 200,
                'data' => $dataResult,
                'id_tryout' => $idTryout,
                'nama_tryout' => $tryout['name'],

            ];
        } else {
            $response = [
                'status' => 200,
                'data' => "Data Kosong",
            ];
        }
        return $this->respond($response, 200);
    }
    public function boardTryoutAllUniv($idUser = NULL, $idTryout = NULL)
    {
        helper('menu');
        if ($idTryout) {
            $tryout = $this->TryoutModel->find($idTryout);
            $mapel = getTypeMapel($tryout['type_tryout']);
            $dataUserActive = $this->UserApiModel->find($idUser);
            $dataUserReg = $this->UserApiModel->where(['regency_id' => $dataUserActive['regency_id'], 'univ1' => $dataUserActive['univ1'], 'prodi1' => $dataUserActive['prodi1']])->findAll();
            $dataUserAnswer = [];
            foreach ($dataUserReg as $userReg) {
                if ($this->AnswertModel->where(['tryout_id' => $idTryout, 'user_id' => $userReg['id_user']])->findAll()) {
                    $dataUserAnswer[] = $this->AnswertModel->where(['tryout_id' => $idTryout, 'user_id' => $userReg['id_user']])->findAll();
                }
            }
            $dataResult = [];
            $arrUser = [];
            foreach ($dataUserAnswer as $UserAnswer) {
                $result = [];
                $totalNilai = 0;
                $sama = false;
                foreach ($arrUser as $arrUsers) {
                    if ($UserAnswer['user_id'] == $arrUsers) {
                        $sama = true;
                    }
                }
                $arrUser[] = $UserAnswer['user_id'];
                if (!$sama) {
                    foreach ($mapel as $item) {
                        $dataJawaban = $this->AnswertModel->where(['user_id' => $UserAnswer['user_id'], 'tryout_id' => $idTryout, 'kind_tryout' => $item[1]])->first();
                        if ($dataJawaban) {
                            $dataJawaban = explode(',', $dataJawaban['answer']);
                            $nilai = 0;
                            $indexJawaban = 1;
                            foreach ($dataJawaban as $jawabanC) {
                                if ($dataBobot = $this->SoaltModel->where(['tryout_id' => $idTryout, 'kind_tryout' => $item[1], 'no_soal' => $indexJawaban, 'jawaban' => $jawabanC])->first())
                                    $nilai += $dataBobot['bobot'];
                                $indexJawaban++;
                            }
                        } else {
                            $nilai = 0;
                        }
                        $totalNilai += $nilai;
                        $result[] = [
                            'nama' => $item[0],
                            'nilai' => $nilai,
                        ];
                    }
                    $dataUser = $this->UserapiModel->find($UserAnswer['user_id']);
                    if ($dataUser['univ1_id']) {
                        $univ = $this->UnivModel->find($dataUser['univ1_id'])['name'];
                        $prodi = $this->ProdiModel->find($dataUser['prodi1_id'])['name'];
                    } else {
                        $univ = "Tidak Memilih";
                        $prodi = "Tidak Memilih";
                    }
                    $dataResult[] = [
                        'iduser' => $dataUser['id_user'],
                        'univ' => $univ,
                        'prodi' => $prodi,
                        'score' => $result,
                        'total' => $totalNilai
                    ];
                }
            }
            if (count($dataResult) > 1) {
                for ($i = 0; $i < count($dataResult) - 1; $i++) {
                    if ($dataResult[$i]['total'] < $dataResult[$i + 1]['total']) {
                        $temp = $dataResult[$i];
                        $dataResult[$i] = $dataResult[$i + 1];
                        $dataResult[$i + 1] = $temp;
                    }
                }
            }
            if (count($dataResult) > 1) {
                for ($i = 0; $i < count($dataResult) - 1; $i++) {
                    if ($dataResult[$i]['total'] < $dataResult[$i + 1]['total']) {
                        $temp = $dataResult[$i];
                        $dataResult[$i] = $dataResult[$i + 1];
                        $dataResult[$i + 1] = $temp;
                    }
                }
            }
            $response = [
                'status' => 200,
                'data' => $dataResult,
                'id_tryout' => $idTryout,
                'nama_tryout' => $tryout['name']
            ];
        } else {
            $response = [
                'status' => 200,
                'data' => "Data Kosong",
            ];
        }
        return $this->respond($response, 200);
    }
}
