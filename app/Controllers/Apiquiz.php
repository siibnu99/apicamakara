<?php

namespace App\Controllers;

use App\Libraries\Uuid;
use CodeIgniter\RESTful\ResourceController;
use App\Models\MyquizModel;
use Exception;

class Apiquiz extends ResourceController
{
    protected $format       = 'json';
    protected $modelName    = 'App\Models\QuizModel';
    public function __construct()
    {
        $this->MyquizModel = new MyquizModel();
    }
    public function index()
    {
        try {
            $iduser = $this->request->auth->idUser;
        } catch (Exception $e) {
            $iduser = NULL;
        }
        helper('menu');
        $data = $this->model->where('active', 1)->findAll();
        $temp = array();
        $result = array();
        $id = 0;
        $MyquizModel = new MyquizModel();
        if ($iduser) {
            foreach ($data as $item) {
                if (!$MyquizModel->where(['user_id' => $iduser, 'quiz_id' => $item['id_quiz']])->first()) {
                    $result[] = $item;
                }
            }
        } else {
            $result = $data;
        }
        foreach ($result as $item) {
            if (strtotime($item['date_end'] . ' ' . $item['time_end']) > time()) {
                $temp[] = $item;
                $temp[$id]['class'] = classQuiz($temp[$id]['class']);
                $temp[$id]['mapel'] = allMapel($temp[$id]['mapel']);
                $temp[$id]['image'] = base_url('assets/image/quiz') . '/' . $temp[$id]['image'];
                $id++;
            }
        }
        $response = [
            'status' => 200,
            'data' => $temp,
        ];
        return $this->respond($response, 200);
    }
    public function show($id = null)
    {
        $myquiz = new MyquizModel();
        helper('menu');
        if ($id) {
            $data = $this->model->find($id);
        } else {
            $data = $this->model->findAll();
        }
        $data['class'] = classQuiz($data['class']);
        $data['amountBuy'] = $myquiz->where('quiz_id', $id)->countAllResults();
        $data['mapel'] = allMapel($data['mapel']);
        $data['image'] = base_url('assets/image/quiz') . '/' . $data['image'];
        $response = [
            'status' => 200,
            'data' => $data,
        ];
        return $this->respond($response, 200);
    }
    public function create()
    {
        try {
            $iduser = $this->request->auth->idUser;
        } catch (Exception $e) {
            return $this->respond($this->request->jwtErrors, 401);
        }
        $Uuid = new Uuid;
        $json = $this->request->getJSON();
        $dQuiz = $this->model->find($json->idquiz);
        if ($json != NULL) {
            if ($this->MyquizModel->where('quiz_id', $json->idquiz)->countAllResults() >= $dQuiz['kuota']) {
                $response = [
                    'status' => 201,
                    'message' => 'Kuota Quiz Sudah penuh!',
                ];
                return $this->respond($response, 201);
            }
            if ($this->MyquizModel->where(['user_id' => $iduser, 'quiz_id' => $json->idquiz])->first()) {
                $response = [
                    'status' => 200,
                    'message' => 'Quiz Sudah dibeli!',
                ];
                return $this->respond($response, 200);
            }
            $data = [
                'id_myquiz' => $Uuid->v4(),
                'quiz_id' => $json->idquiz,
                'user_id' => $iduser
            ];
            $this->MyquizModel->insert($data);
            $response = [
                'status' => 200,
                'message' => 'Quiz Berhasil dibeli!',
            ];
            return $this->respond($response, 200);
        }
        $response = [
            'status' => false,
        ];
        return $this->respond($response, 201);
    }
}
