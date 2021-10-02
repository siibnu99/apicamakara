<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\UserApiModel;
use App\Models\TryoutModel;
use App\Models\MytryoutModel;
use App\Models\AnswertModel;
use App\Models\ProdiModel;
use App\Models\SoaltModel;

class Apimytryout extends ResourceController
{
    protected $format       = 'json';
    protected $modelName    = 'App\Models\MytryoutModel';
    public function __construct()
    {

        $this->UserApiModel = new UserApiModel;
        $this->TryoutModel = new TryoutModel;
        $this->AnswertModel = new AnswertModel;
        $this->SoaltModel = new SoaltModel();
        $this->MytryoutModel = new MytryoutModel();
        $this->ProdiModel = new ProdiModel();
        helper('menu');
    }
    public function index()
    {
        $iduser = $this->request->auth->idUser;
        helper('menu');
        $tryout = $this->model->where('user_id', $iduser)->join('tbl_tryout', 'tbl_tryout.id_tryout = tbl_mytryout.tryout_id')->findAll();
        $result = [];
        $i = 0;
        foreach ($tryout as $item) {
            $result[] = $item;
            $allMapel = getTypeMapel($item['type_tryout']);
            $result[$i]['statusAnswert'] = true;
            foreach ($allMapel as $Mapel) {
                if (!$this->AnswertModel->where(['user_id' => $iduser, 'tryout_id' => $item['id_tryout'], 'kind_tryout' => $Mapel[1]])->findAll()) {
                    $result[$i]['statusAnswert'] = false;
                    break;
                }
            }
            $i++;
        }
        $data = [
            "tryouts" => $result,
        ];
        $response = [
            'status' => 200,
            'data' => $data,
        ];
        return $this->respond($response, 200);
    }
    public function show($id = null)
    {
        $idUser = $this->request->auth->idUser;
        helper('menu');
        $mytryout = new MytryoutModel();
        $result = $mytryout->where(['user_id' => $idUser, 'tryout_id' => $id])->first();
        if ($result) {
            $data = $this->TryoutModel->find($id);
            if (!$result['time_start_answer']) {
                $mytryout->update($result['id_mytryout'], ['time_start_answer' => time()]);
                $data['time_start_answer'] = (int) time();
            } else {
                $data['time_start_answer'] = (int) $result['time_start_answer'];
            }
            $totalSaint = 0;
            $totalSoshum = 0;
            $dataMapel = mapel(1, $data);
            foreach ($dataMapel as $item) {
                $totalSaint +=  (int)$item[2];
            }
            $dataMapel = mapel(2, $data);
            foreach ($dataMapel as $item) {
                $totalSoshum += (int)$item[2];
            }
            $data['totalSaint'] = $totalSaint + 30;
            $data['totalSoshum'] = $totalSoshum + 30;
            $countPersonBuy = $mytryout->where('tryout_id', $id)->countAllResults();
            $data['personBuy'] = $countPersonBuy;
            $dataAnswert = [];
            foreach (getTypeMapel($data['type_tryout']) as $mapel) {
                $inData = [$mapel[1], 0];
                if ($this->AnswertModel->where(['user_id' => $idUser, 'tryout_id' => $id, 'kind_tryout' => $mapel[1]])->findAll()) {
                    $inData[1] = 1;
                }
                $dataAnswert[] = $inData;
            }
            $data['tryoutanswert'] = $dataAnswert;
            $response = [
                'status' => 200,
                'data' => $data,
            ];
            return $this->respond($response, 200);
        } else {
            $response = [
                'status' => 201,
                'message' => "Tidak memiliki Tryout ini"
            ];
            return $this->respond($response, 200);
        }
    }
    public function finish()
    {
        $idUser = $this->request->auth->idUser;
        $json = $this->request->getJSON();
        helper('menu');
        $mytryout = new MytryoutModel();
        $result = $mytryout->where(['user_id' => $idUser, 'tryout_id' => $json->idtryout])->first();
        if ($result) {
            $mytryout->update($result['id_mytryout'], ['finish' => 1]);
            $response = [
                'status' => 200,
                'message' => "Selesai Mengerjakan!",
            ];
            return $this->respond($response, 200);
        } else {
            $response = [
                'status' => 201,
                'message' => "Tidak memiliki Tryout ini"
            ];
            return $this->respond($response, 200);
        }
    }
    public function finishEachKind()
    {
        $idUser = $this->request->auth->idUser;
        $json = $this->request->getJSON();
        helper('menu');
        $result = $this->AnswertModel->where(['user_id' => $idUser, 'tryout_id' => $json->idtryout, 'kind_tryout' => $json->kindtryout])->first();
        if ($result) {
            $this->AnswertModel->update($result['id_answer'], ['finish' => 1]);
            $response = [
                'status' => 200,
                'message' => "Selesai Mengerjakan!",
            ];
            return $this->respond($response, 200);
        } else {
            $response = [
                'status' => 201,
                'message' => "Belum meyimpan jawaban"
            ];
            return $this->respond($response, 200);
        }
    }
    public function getAnswert()
    {
        $idUser = $this->request->auth->idUser;
        $json = $this->request->getJSON();
        $kindTryout = $json->kindtryout;
        $id = $json->idtryout;
        helper('menu');
        $mytryout = new MytryoutModel();
        $result = $mytryout->where(['user_id' => $idUser, 'tryout_id' => $id])->first();
        if ($result) {
            if ($this->AnswertModel->where(['user_id' => $idUser, 'tryout_id' => $id, 'kind_tryout' => $kindTryout])->findAll()) {
                $dataAnswertResult = $this->SoaltModel->select('pembahasan,imagepembahasan,jawaban')->where(['tryout_id' => $id, 'kind_tryout' => $kindTryout])->orderBy("no_soal", "ASC")->findAll();
                $data = $dataAnswertResult;
            } else {
                $data = "Belum dikerjakan";
            }
            $response = [
                'status' => 200,
                'data' => $data,
            ];
            return $this->respond($response, 200);
        } else {
            $response = [
                'status' => 201,
                'message' => "Tidak memiliki Tryout ini"
            ];
            return $this->respond($response, 200);
        }
    }
    public function setcollage()
    {
        $idUser = $this->request->auth->idUser;
        $data = $this->request->getJSON();
        helper('menu');
        $mytryout = new MytryoutModel();
        $result = $mytryout->where(['user_id' => $idUser, 'tryout_id' => $data->idtryout])->first();
        if ($result) {
            $save = [
                'univ1' => $data->univ1,
                'prodi1' => $data->prodi1,
                'univ2' => $data->univ2,
                'prodi2' => $data->prodi2,
            ];
            $mytryout->update($result['id_mytryout'], $save);
            $response = [
                'status' => 200,
                'message' => "Berhasil menyimpan Univ dan prodi",
            ];
            return $this->respond($response, 200);
        } else {
            $response = [
                'status' => 201,
                'message' => "gagal menyimpan Univ dan prodii"
            ];
            return $this->respond($response, 200);
        }
    }
    public function sortScore($a, $b)
    {
        if ($a['score'] == $b['score']) return 0;
        return ($a['score'] > $b['score']) ? -1 : 1;
    }
    public function leaderboard()
    {
        $idUser = $this->request->auth->idUser;
        $data = $this->request->getJSON();
        $dataTryout = $this->TryoutModel->find($data->idtryout);
        if ($dataTryout) {
            $dataUser = $this->UserApiModel->find($idUser);
            $dataMytryout = $this->MytryoutModel->where(['user_id' => $idUser, 'tryout_id' => $data->idtryout])->join('tbl_tryout', 'tbl_tryout.id_tryout = tbl_mytryout.tryout_id')->first();
            for ($i = 1; $i <= 2; $i++) {
                $dataNational[$i] = $this->MytryoutModel->join('tbl_user', 'tbl_user.id_user = tbl_mytryout.user_id')->join('tbl_tryout', 'tbl_tryout.id_tryout = tbl_mytryout.tryout_id')->where(['finish' => 1, 'prodi' . $i => $dataMytryout['prodi' . $i]])->findAll();
                foreach ($dataNational[$i] as &$_dataNational) {
                    $_dataNational['score'] = $this->TryoutModel->getScore($_dataNational, $dataMytryout['prodi' . $i]);
                }
                usort($dataNational[$i], array($this, "sortScore"));
                foreach ($dataNational[$i] as $key => $val) {
                    if ($val['id_user'] == $idUser) {
                        $noNational[$i] = $key + 1;
                    }
                }
                $dataProvince[$i] = $this->MytryoutModel->join('tbl_user', 'tbl_user.id_user = tbl_mytryout.user_id')->join('tbl_tryout', 'tbl_tryout.id_tryout = tbl_mytryout.tryout_id')->where(['finish' => 1, 'prodi' . $i => $dataMytryout['prodi' . $i], 'province_id' => $dataUser['province_id']])->findAll();
                foreach ($dataProvince[$i] as &$_dataProvince) {
                    $_dataProvince['score'] = $this->TryoutModel->getScore($_dataProvince, $dataMytryout['prodi' . $i]);
                }
                usort($dataProvince[$i], array($this, "sortScore"));
                foreach ($dataProvince[$i] as $key => $val) {
                    if ($val['id_user'] == $idUser) {
                        $noProvince[$i] = $key + 1;
                    }
                }

                $dataRegency[$i] = $this->MytryoutModel->join('tbl_user', 'tbl_user.id_user = tbl_mytryout.user_id')->join('tbl_tryout', 'tbl_tryout.id_tryout = tbl_mytryout.tryout_id')->where(['finish' => 1, 'prodi' . $i => $dataMytryout['prodi' . $i], 'regency_id' => $dataUser['regency_id']])->findAll();
                foreach ($dataRegency[$i] as &$_dataRegency) {
                    $_dataRegency['score'] = $this->TryoutModel->getScore($_dataRegency, $dataMytryout['prodi' . $i]);
                }
                usort($dataRegency[$i], array($this, "sortScore"));
                foreach ($dataRegency[$i] as $key => $val) {
                    if ($val['id_user'] == $idUser) {
                        $noRegency[$i] = $key + 1;
                    }
                }
            }
            foreach (allMapel() as $valueAllMapel) {
                $scoreAllMapel[$valueAllMapel[1]] = $this->TryoutModel->getScoreByKind($idUser, $data->idtryout, $valueAllMapel[1]);
            }
            $dataAllTryout =  $this->MytryoutModel->join('tbl_user', 'tbl_user.id_user = tbl_mytryout.user_id')->join('tbl_tryout', 'tbl_tryout.id_tryout = tbl_mytryout.tryout_id')->where(['finish' => 1])->findAll();
            foreach ($dataAllTryout as $_keyDataAllTryout => &$_dataAllTryout) {
                if ($dataTryout['type_tryout'] == 3) {
                    $totalSaint[$_keyDataAllTryout] = [
                        'userid' => $_dataAllTryout['id_user'],
                        'fullname' => $_dataAllTryout['fullname'],
                        'school' => $_dataAllTryout['school'],
                        'score' => $this->TryoutModel->getScore($_dataAllTryout, 1, 'true')
                    ];
                    $totalSoshum[$_keyDataAllTryout] = [
                        'userid' => $_dataAllTryout['id_user'],
                        'fullname' => $_dataAllTryout['fullname'],
                        'school' => $_dataAllTryout['school'],
                        'score' => $this->TryoutModel->getScore($_dataAllTryout, 2, 'true')
                    ];
                    $prodi1 = $this->ProdiModel->find($_dataAllTryout['prodi1']);
                    if ($prodi1['kelompok_ujian'] == 1) {
                        $totalSaint[$_keyDataAllTryout]['univ'] = $_dataAllTryout['univ1'];
                        $totalSaint[$_keyDataAllTryout]['prodi'] = $_dataAllTryout['prodi1'];
                        $totalSoshum[$_keyDataAllTryout]['univ'] = $_dataAllTryout['univ2'];
                        $totalSoshum[$_keyDataAllTryout]['prodi'] = $_dataAllTryout['prodi2'];
                    } else {
                        $totalSoshum[$_keyDataAllTryout]['univ'] = $_dataAllTryout['univ1'];
                        $totalSoshum[$_keyDataAllTryout]['prodi'] = $_dataAllTryout['prodi1'];
                        $totalSaint[$_keyDataAllTryout]['univ'] = $_dataAllTryout['univ2'];
                        $totalSaint[$_keyDataAllTryout]['prodi'] = $_dataAllTryout['prodi2'];
                    }
                } else {
                    $dataProdi1 = $this->ProdiModel->find($_dataAllTryout['prodi1']);
                    $dataProdi2 = $this->ProdiModel->find($_dataAllTryout['prodi2']);
                    if (!$dataProdi1 || !$dataProdi2) {
                        continue;
                    }
                    if ($dataProdi1['kelompok_ujian'] == $dataProdi2['kelompok_ujian']) {
                        if ($dataProdi1['kelompok_ujian'] == 1) {
                            $totalSaint[$_keyDataAllTryout] = [
                                'userid' => $_dataAllTryout['id_user'],
                                'fullname' => $_dataAllTryout['fullname'],
                                'school' => $_dataAllTryout['school'],
                                'univ1' => $_dataAllTryout['univ1'],
                                'univ2' => $_dataAllTryout['univ2'],
                                'prodi1' => $_dataAllTryout['prodi1'],
                                'prodi2' => $_dataAllTryout['prodi2'],
                                'score' => $this->TryoutModel->getScore($_dataAllTryout, $dataProdi1['kelompok_ujian'], 'true')
                            ];
                        } else {
                            $totalSoshum[$_keyDataAllTryout] = [
                                'userid' => $_dataAllTryout['id_user'],
                                'fullname' => $_dataAllTryout['fullname'],
                                'school' => $_dataAllTryout['school'],
                                'univ1' => $_dataAllTryout['univ1'],
                                'univ2' => $_dataAllTryout['univ2'],
                                'prodi1' => $_dataAllTryout['prodi1'],
                                'prodi2' => $_dataAllTryout['prodi2'],
                                'score' => $this->TryoutModel->getScore($_dataAllTryout, $dataProdi1['kelompok_ujian'], 'true')
                            ];
                        }
                    } else {
                        if ($dataProdi1['kelompok_ujian'] == 1) {
                            $totalSaint[$_keyDataAllTryout] = [
                                'userid' => $_dataAllTryout['id_user'],
                                'fullname' => $_dataAllTryout['fullname'],
                                'school' => $_dataAllTryout['school'],
                                'univ1' => $_dataAllTryout['univ1'],
                                'univ2' => $_dataAllTryout['univ2'],
                                'prodi1' => $_dataAllTryout['prodi1'],
                                'prodi2' => $_dataAllTryout['prodi2'],
                                'score' => $this->TryoutModel->getScore($_dataAllTryout, $dataProdi1['kelompok_ujian'], 'true')
                            ];
                        } else {
                            $totalSoshum[$_keyDataAllTryout] = [
                                'userid' => $_dataAllTryout['id_user'],
                                'fullname' => $_dataAllTryout['fullname'],
                                'school' => $_dataAllTryout['school'],
                                'univ1' => $_dataAllTryout['univ1'],
                                'univ2' => $_dataAllTryout['univ2'],
                                'prodi1' => $_dataAllTryout['prodi1'],
                                'prodi2' => $_dataAllTryout['prodi2'],
                                'score' => $this->TryoutModel->getScore($_dataAllTryout, $dataProdi1['kelompok_ujian'], 'true')
                            ];
                        }
                        if ($dataProdi2['kelompok_ujian'] == 1) {
                            $totalSaint[$_keyDataAllTryout] = [
                                'userid' => $_dataAllTryout['id_user'],
                                'fullname' => $_dataAllTryout['fullname'],
                                'school' => $_dataAllTryout['school'],
                                'univ1' => $_dataAllTryout['univ1'],
                                'univ2' => $_dataAllTryout['univ2'],
                                'prodi1' => $_dataAllTryout['prodi1'],
                                'prodi2' => $_dataAllTryout['prodi2'],
                                'score' => $this->TryoutModel->getScore($_dataAllTryout, $dataProdi2['kelompok_ujian'], 'true')
                            ];
                        } else {
                            $totalSoshum[$_keyDataAllTryout] = [
                                'userid' => $_dataAllTryout['id_user'],
                                'fullname' => $_dataAllTryout['fullname'],
                                'school' => $_dataAllTryout['school'],
                                'univ1' => $_dataAllTryout['univ1'],
                                'univ2' => $_dataAllTryout['univ2'],
                                'prodi1' => $_dataAllTryout['prodi1'],
                                'prodi2' => $_dataAllTryout['prodi2'],
                                'score' => $this->TryoutModel->getScore($_dataAllTryout, $dataProdi2['kelompok_ujian'], 'true')
                            ];
                        }
                    }
                }
            }
            usort($totalSaint, array($this, "sortScore"));
            usort($totalSoshum, array($this, "sortScore"));
            $result = [
                'idUser' => $idUser,
                'time' => time(),
                'leaderboard1' => [
                    'typeTryout' => $dataTryout['type_tryout'],
                    'univ1' => $dataMytryout['univ1'],
                    'univ2' => $dataMytryout['univ2'],
                    'prodi1' => $dataMytryout['prodi1'],
                    'prodi2' => $dataMytryout['prodi2'],
                    'nasional1' => $noNational[1],
                    'totalnasional1' => count($dataNational[1]),
                    'nasional2' => $noNational[2],
                    'totalnasional2' => count($dataNational[2]),
                    'provinsi1' => $noProvince[1],
                    'totalprovinsi1' => count($dataProvince[1]),
                    'provinsi2' => $noProvince[2],
                    'totalprovinsi2' => count($dataProvince[2]),
                    'kota1' => $noRegency[1],
                    'totalkota1' => count($dataRegency[1]),
                    'kota2' => $noRegency[2],
                    'totalkota2' => count($dataRegency[2]),
                ],
                'leaderboard2' => $scoreAllMapel,
                'leaderboard3' => [
                    'SOSHUM' => ($totalSoshum ? $totalSoshum : 0),
                    'SAINTEK' => ($totalSaint ? $totalSaint : 0)
                ],
            ];
            $response = [
                'status' => 200,
                'message' => "Data Leaderboard",
                'data' => $result
            ];
            return $this->respond($response, 200);
        } else {
            $response = [
                'status' => 201,
                'message' => "Tryout tidak ditemukan"
            ];
            return $this->respond($response, 200);
        }
    }
}
