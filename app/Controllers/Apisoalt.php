<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use \App\Libraries\Uuid;
use \App\Libraries\Tokenjwt;
use App\Models\UserApiModel;
use App\Models\TryoutModel;
use App\Models\AnswertModel;
use CodeIgniter\Database\MySQLi\Result;

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
    }
    public function show($idTryout = NULL, $kindTryout = NULL)
    {
        helper('menu');
        $result = $this->model->where(["tryout_id" => $idTryout, "kind_tryout" => $kindTryout])->orderBy("no_soal")->findAll();
        $temp = [];
        $id = 0;
        foreach ($result as $item) {
            $item['jawaban'] = NULL;
            $item['pembahasan'] = NULL;
            $item['image'] = base_url('assets/image/soalTryout') . '/' . $item['image'];
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
    public function created()
    {
        $idUser = $this->request->auth->idUser;
        $json = $this->request->getJSON();
        $idTryout = $json->idtryout;
        $kindTryout = $json->kindtryout;
        helper('menu');
        $result = $this->AnswertModel->where(['user_id' => $idUser, 'tryout_id' => $idTryout, 'kind_tryout' => $kindTryout])->first();
        $tryout = $this->TryoutModel->find($idTryout);
        if (
            $result
        ) {
            try {
                $json = $this->request->getJSON();
                $answer = $json->answer;
                $data = [
                    'id_answer' => $result['id_answer'],
                    'answer' => $answer
                ];
                $this->AnswertModel->save($data);
            } catch (\Throwable $th) {
                $answer = NULL;
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
                $data = [];
                $data = [
                    'id_answer' => $Uuid->v4(),
                    'kind_tryout' => $kindTryout,
                    'user_id' => $idUser,
                    'tryout_id' => $idTryout,
                ];
                $answer = NULL;
            }
            $tryout = $this->TryoutModel->find($idTryout);
            $this->AnswertModel->insert($data);
            $result = $this->AnswertModel->find($data['id_answer']);
            $kindTryout = 't_' . explode('_', $kindTryout)[1];
            $timestart = explode(' ', $result['created_at'])[1];
        }
        $response = [
            'status' => 200,
            'message' => "Berhasil Submit",
            'data' => $answer,
            'time' => $tryout[$kindTryout],
            'timestart' => $timestart,
            'timestartsecond' => strtotime($timestart),
            'timeend' => date("H:i:s", strtotime($timestart) + ($tryout[$kindTryout] * 60)),
            'timeendsecond' => strtotime($timestart) + ($tryout[$kindTryout] * 60)

        ];
        return $this->respond($response, 200);
    }
}
