<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use \App\Libraries\Uuid;
use \App\Libraries\Tokenjwt;
use App\Models\QuizModel;
use App\Models\TransferModel;
use App\Models\TopupModel;
use App\Models\MytryoutModel;
use App\Models\SoaltModel;
use App\Models\MyquizModel;

class Apimyquiz extends ResourceController
{
    protected $format       = 'json';
    protected $modelName    = 'App\Models\MyquizModel';
    private $limit = 10;
    public function _getSaldo($idUser = NULL)
    {
        $TopupModel = new TopupModel();
        $TransferModel = new TransferModel();
        $MytryoutModel = new MytryoutModel();
        $SoaltModel = new SoaltModel();
        $MyquizModel = new MyquizModel();
        $topup = $TopupModel->selectSum('nominal', 'totalNominal')->where(['user_id' => $idUser, 'status' => '2'])->first()['totalNominal'];
        $transferFrom = $TransferModel->selectSum('nominal', 'totalNominal')->where('from_id', $idUser)->first()['totalNominal'];
        $transferTo = $TransferModel->selectSum('nominal', 'totalNominal')->where('to_id', $idUser)->first()['totalNominal'];
        $dataMyTryout = $MytryoutModel->selectSum('tbl_tryout.price', 'totalNominal')->where(['user_id' => $idUser, 'tbl_tryout.payment_method' => '2', 'payment_id' => '2'])->join('tbl_tryout', 'tbl_tryout.id_tryout = tbl_mytryout.tryout_id')->first()['totalNominal'];
        $dataMyTryout3 = $MytryoutModel->selectSum('tbl_mytryout.price', 'totalNominal')->where(['user_id' => $idUser, 'tbl_tryout.payment_method' => '3', 'payment_id' => '3'])->join('tbl_tryout', 'tbl_tryout.id_tryout = tbl_mytryout.tryout_id')->first()['totalNominal'];
        $dataMyquiz = $MyquizModel->selectSum('price', 'totalNominal')->where('user_id', $idUser)->first()['totalNominal'];
        return $topup + $transferTo - $transferFrom - $dataMyTryout - $dataMyTryout3 - $dataMyquiz;
    }
    public function __construct()
    {
        $this->QuizModel = new QuizModel;
        helper('menu');
    }
    private function getOffset($page)
    {
        $offset = ($page - 1) * $this->limit;
        return $offset;
    }
    private function getPageCount($countData)
    {
        $pageCount = ceil($countData / $this->limit);
        return $pageCount;
    }
    public function index($iduser = null)
    {
        $tokenjwt = new Tokenjwt;
        $data = $tokenjwt->checkToken($this->request->getServer('HTTP_AUTHORIZATION'));
        if ($data['status'] == 200) {
        } else {
            return $this->respond($data, 401);
        }
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
    public function create()
    {
        $tokenjwt = new Tokenjwt;
        $data = $tokenjwt->checkToken($this->request->getServer('HTTP_AUTHORIZATION'));
        if ($data['status'] == 200) {
        } else {
            return $this->respond($data, 401);
        }
        $Uuid = new Uuid;
        $json = $this->request->getJSON();
        $dQuiz = $this->QuizModel->find($json->idquiz);
        if ($json != NULL) {
            if ($this->model->where('quiz_id', $json->idquiz)->countAllResults() >= $dQuiz['kuota']) {
                $response = [
                    'status' => 201,
                    'message' => 'Kuota Quiz Sudah penuh!',
                ];
                return $this->respond($response, 201);
            }
            if ($this->model->where(['user_id' => $json->iduser, 'quiz_id' => $json->idquiz])->first()) {
                $response = [
                    'status' => 200,
                    'message' => 'Quiz Sudah dibeli!',
                ];
                return $this->respond($response, 200);
            }
            $data = [
                'id_myquiz' => $Uuid->v4(),
                'quiz_id' => $json->idquiz,
                'user_id' => $json->iduser
            ];
            $this->model->insert($data);
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
    public function get($idUser = null, $idQuiz = null)
    {
        $tokenjwt = new Tokenjwt;
        $data = $tokenjwt->checkToken($this->request->getServer('HTTP_AUTHORIZATION'));
        if ($data['status'] == 200) {
        } else {
            return $this->respond($data, 401);
        }
        if ($quiz = $this->model->where(['user_id' => $idUser, 'quiz_id' => $idQuiz])->join('tbl_quiz', 'tbl_quiz.id_quiz = tbl_myquiz.quiz_id')->first()) {
            $quiz['mapel_name'] = allMapel($quiz['mapel']);
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
    public function finish($idUser = null, $idQuiz = null)
    {
        $tokenjwt = new Tokenjwt;
        $data = $tokenjwt->checkToken($this->request->getServer('HTTP_AUTHORIZATION'));
        if ($data['status'] == 200) {
        } else {
            return $this->respond($data, 401);
        }
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
    public function invoice($idUser = null, $idQuiz = null)
    {
        $tokenjwt = new Tokenjwt;
        $data = $tokenjwt->checkToken($this->request->getServer('HTTP_AUTHORIZATION'));
        if ($data['status'] == 200) {
        } else {
            return $this->respond($data, 401);
        }
        if ($quiz = $this->model->where(['user_id' => $idUser, 'quiz_id' => $idQuiz])->first()) {
            $json = $this->request->getJSON();
            if ($this->_getSaldo($idUser) >= $json->price) {
                if ($json->price >= 0) {
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
