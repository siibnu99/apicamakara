<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\UserApiModel;
use App\Models\TryoutModel;
use App\Models\MytryoutModel;
use App\Models\AnswertModel;
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
                $totalSaint +=  $item[2];
            }
            $dataMapel = mapel(2, $data);
            foreach ($dataMapel as $item) {
                $totalSoshum += $item[2];
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
}
