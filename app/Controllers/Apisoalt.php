<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use \App\Libraries\Uuid;
use App\Models\UserApiModel;
use App\Models\TryoutModel;
use App\Models\AnswertModel;
use App\Models\MytryoutModel;
use Exception;

class Apisoalt extends ResourceController
{
    protected $format       = 'json';
    protected $modelName    = 'App\Models\SoaltModel';
    private $TryoutModel;
    public function __construct()
    {

        $this->UserapiModel = new UserApiModel;
        $this->TryoutModel = new TryoutModel;
        $this->AnswertModel = new AnswertModel;
        $this->MytryoutModel = new MytryoutModel;
    }
    public function show($idTryout = NULL, $kindTryout = NULL)
    {
        helper('menu');
        $result = $this->model->where(["tryout_id" => $idTryout, "kind_tryout" => $kindTryout])->orderBy("no_soal")->findAll();
        $temp = [];
        $id = 0;
        foreach ($result as $item) {
            if ($item['image']) {
                $item['image'] = base_url('assets/image/soalquiz') . '/' . $item['image'];
            } else {
                $item['image'] = NULL;
            }
            if ($item['imagepembahasan']) {
                $item['imagepembahasan'] = base_url('assets/image/soalquiz') . '/' . $item['imagepembahasan'];
            } else {
                $item['imagepembahasan'] = NULL;
            }
            $item['namamapel'] = allMapel($kindTryout);
            $temp[$id] = $item;
            $id++;
        }
        $response = [
            'status' => 200,
            'data' => $temp,
        ];
        return $this->respond($response, 200);
    }
    public function create()
    {
        helper('menu');
        $idUser = $this->request->auth->idUser;
        $json = $this->request->getJSON();
        $idTryout = $json->idtryout;
        try {
            $kindTryout = $json->kindtryout;
        } catch (Exception $e) {
            $kindTryout = NULL;
        }
        if ($kindTryout) {
            if (is_array($kindTryout)) {
                $datakindTryout = $kindTryout;
            } else {
                $datakindTryout = [$kindTryout];
            }
            foreach ($datakindTryout as $kindTryout) {
                $result = $this->AnswertModel->where(['user_id' => $idUser, 'tryout_id' => $idTryout, 'kind_tryout' => $kindTryout])->first();
                $tryout = $this->TryoutModel->find($idTryout);
                if (!$tryout) {
                    return;
                }
                if (
                    $result
                ) {
                    try {
                        $answer = $json->answer;
                        if ($json->answer) {
                            $answer = $json->answer;
                        } else {
                            $answer = $result['answer'];
                        }
                        $data = [
                            'id_answer' => $result['id_answer'],
                            'answer' => $answer
                        ];
                        $this->AnswertModel->update($result['id_answer'], $data);
                        if ($answer) {
                            $answer = explode(',', $result['answer']);
                        } else {
                            $answer = array();
                        }
                    } catch (\Throwable $th) {
                        if ($result['answer']) {
                            $answer = explode(',', $result['answer']);
                        } else {
                            $answer = array();
                        }
                    }
                    $kindTryout = 't_' . explode('_', $kindTryout)[1];
                    $timestart = explode(' ', $result['created_at'])[1];
                } else {
                    $Uuid = new Uuid;
                    try {
                        $data = [
                            'id_answer' => $Uuid->v4(),
                            'kind_tryout' => $kindTryout,
                            'user_id' => $idUser,
                            'tryout_id' => $idTryout,
                            'answer' => $json->answer,
                        ];
                        $answer = $json->answer;
                    } catch (\Throwable $th) {
                        $answer = array();
                        $data = array();
                        $data = [
                            'id_answer' => $Uuid->v4(),
                            'kind_tryout' => $kindTryout,
                            'user_id' => $idUser,
                            'tryout_id' => $idTryout,
                        ];
                    }
                    $tryout = $this->TryoutModel->find($idTryout);
                    $this->AnswertModel->insert($data);
                    $result = $this->AnswertModel->find($data['id_answer']);
                    $kindTryout = 't_' . explode('_', $kindTryout)[1];
                    $timestart = explode(' ', $result['created_at'])[1];
                }
                if (count($datakindTryout) == 1) {
                    $response = [
                        'status' => 200,
                        'message' => "Berhasil Submit",
                        'data' => $answer,
                        'time' => $tryout[$kindTryout],
                        'timeserver' => time(),
                        'timestart' => $timestart,
                        'timestartsecond' => strtotime($timestart),
                        'timeend' => date("H:i:s", strtotime($timestart) + ($tryout[$kindTryout] * 60)),
                        'timeendsecond' => strtotime($timestart) + ($tryout[$kindTryout] * 60)

                    ];
                    return $this->respond($response, 200);
                }
            }
            $response = [
                'status' => 200,
                'message' => "Berhasil Submit",
            ];
            return $this->respond($response, 200);
        } else {
            $data = $this->MytryoutModel->where(["user_id" => $idUser, 'tryout_id' => $idTryout])->first();
            if (!$data) {
                return;
            }
            $save = [
                'time_start_answer' => time()
            ];
            $this->MytryoutModel->update($data['id_mytryout'], $save);
            $data = $this->MytryoutModel->where(["user_id" => $idUser, 'tryout_id' => $idTryout])->first();
            $tryout = $this->TryoutModel->find($data['tryout_id']);
            $totalSaint = 0;
            $totalSoshum = 0;
            $dataMapel = mapel(1, $tryout);
            foreach ($dataMapel as $item) {
                $totalSaint +=  $item[2];
            }
            $dataMapel = mapel(2, $tryout);
            foreach ($dataMapel as $item) {
                $totalSoshum += $item[2];
            }
            $totalSaint = $totalSaint + 30;
            $totalSoshum = $totalSoshum + 30;
            if ($tryout['type_tryout'] == 1) {
                $timeend = $totalSaint;
            } else {
                $timeend = $totalSoshum;
            }
            $response = [
                'status' => 200,
                'message' => "Berhasil Submit",
                'data' => NULL,
                'timeserver' => time(),
                'timestartsecond' => $data['time_start_answer'],
                'timeendsecond' => $data['time_start_answer'] + ($timeend * 60)

            ];
            return $this->respond($response, 200);
        }
    }
}
