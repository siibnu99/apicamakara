<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\MyquizModel;

class Apiquiz extends ResourceController
{
    protected $format       = 'json';
    protected $modelName    = 'App\Models\QuizModel';
    public function index($iduser = null)
    {
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
            $temp[] = $item;
            $temp[$id]['class'] = classQuiz($temp[$id]['class']);
            $temp[$id]['mapel'] = allMapel($temp[$id]['mapel']);
            $temp[$id]['image'] = base_url('assets/image/quiz') . '/' . $temp[$id]['image'];
            $id++;
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
}
