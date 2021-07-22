<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use \App\Libraries\Uuid;
use App\Models\AnswerqModel;
use App\Models\QuizModel;
use App\Models\UserApiModel;
use Pusher\Pusher;

class Apimyquiz extends ResourceController
{
    protected $format       = 'json';
    protected $modelName    = 'App\Models\MyquizModel';
    public function __construct()
    {
        $this->QuizModel = new QuizModel;
        $this->AnswerqModel = new AnswerqModel();
        $this->UserApiModel = new UserApiModel();
        helper('menu');
    }
    public function index()
    {
        $iduser = $this->request->auth->idUser;
        $quiz = $this->model->where('user_id', $iduser)->join('tbl_quiz', 'tbl_quiz.id_quiz = tbl_myquiz.quiz_id')->findAll();
        $result = array();
        $id = 0;
        foreach ($quiz as $item) {
            $result[] = $item;
            $result[$id]['mapel_name'] = allMapel($result[$id]['mapel']);
            $id++;
        }
        $response = [
            'status' => false,
            'data' => $result
        ];
        return $this->respond($response, 200);
    }
    public function show($idQuiz = null)
    {
        $idUser = $this->request->auth->idUser;
        if ($quiz = $this->model->where(['user_id' => $idUser, 'quiz_id' => $idQuiz])->join('tbl_quiz', 'tbl_quiz.id_quiz = tbl_myquiz.quiz_id')->first()) {
            $quiz['class'] = classQuiz($quiz['class']);
            $quiz['amountBuy'] = $this->model->where('quiz_id', $idQuiz)->countAllResults();
            $quiz['mapel'] = allMapel($quiz['mapel']);
            $quiz['image'] = base_url('assets/image/quiz') . '/' . $quiz['image'];
            $response = [
                'status' => 201,
                'message' => 'Quiz  ditemukan!',
                'data' => $quiz
            ];
            return $this->respond($response, 201);
        }
        $response = [
            'status' => 201,
            'message' => 'Quiz tidak ditemukan!',
            'data' => NULL
        ];
        return $this->respond($response, 201);
    }
    public function finish()
    {
        $idUser = $this->request->auth->idUser;
        $json = $this->request->getJSON();
        $idQuiz = $json->idquiz;
        if ($quiz = $this->model->where(['user_id' => $idUser, 'quiz_id' => $idQuiz])->first()) {
            if (!$quiz['finish']) {
                $this->model->update($quiz['id_myquiz'], ['finish' => 1]);
            } else {
                $response = [
                    'status' => 201,
                    'message' => 'Quiz sudah diselesaikan!',
                    'data' => $quiz
                ];
                return $this->respond($response, 201);
            }
            $response = [
                'status' => 200,
                'message' => ' Quiz berhasil diselesaikan!',
                'data' => $quiz
            ];
            return $this->respond($response, 201);
        }
        $response = [
            'status' => 201,
            'message' => 'Quiz tidak ditemukan!',
            'data' => NULL
        ];
        return $this->respond($response, 201);
    }
    public function invoice()
    {
        $idUser = $this->request->auth->idUser;
        $json = $this->request->getJSON();
        $idQuiz = $json->idquiz;
        if ($quiz = $this->model->where(['user_id' => $idUser, 'quiz_id' => $idQuiz])->first()) {
            $json = $this->request->getJSON();
            if ($this->UserApiModel->getSaldo($idUser) >= $json->price) {
                if ($json->price >= 0) {
                    $options = array(
                        'cluster' => 'ap1',
                        'useTLS' => true
                    );
                    $pusher = new Pusher(
                        '9572fc108523db38ff8c',
                        '00f81ecce367b823260d',
                        '1235332',
                        $options
                    );
                    $data['message'] = 'success';
                    $pusher->trigger('my-channel', 'saldo', $data);
                    $this->model->update($quiz['id_myquiz'], ['price' => $json->price]);
                    $response = [
                        'status' => 200,
                        'message' => 'Quiz berhasil dibayar!',
                        'data' => ['price' => $json->price]
                    ];
                    return $this->respond($response, 200);
                }
                $response = [
                    'status' => 201,
                    'message' => 'Inputan salah',
                    'data' => NULL
                ];
                return $this->respond($response, 201);
            }
            $response = [
                'status' => 201,
                'message' => 'Saldo tidak cukup!',
                'data' => NULL
            ];
            return $this->respond($response, 201);
        }
        $response = [
            'status' => 201,
            'message' => 'Quiz tidak ditemukan!',
            'data' => NULL
        ];
        return $this->respond($response, 201);
    }
}
