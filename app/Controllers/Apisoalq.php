<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use \App\Libraries\Uuid;
use \App\Libraries\Tokenjwt;
use App\Models\UserApiModel;
use Myth\Auth\Models\UserModel;
use App\Models\QuizModel;
use App\Models\AnswerqModel;
use App\Models\MyquizModel;
use CodeIgniter\Database\MySQLi\Result;
use Exception;
use Google\Auth\Cache\Item;

class Apisoalq extends ResourceController
{
    protected $format       = 'json';
    protected $modelName    = 'App\Models\SoalqModel';
    private $TryoutModel;
    public function __construct()
    {
        $this->UserApiModel = new UserApiModel;
        $this->UserModel = new UserModel;
        $this->QuizModel = new QuizModel;
        $this->AnswerqModel = new AnswerqModel;
        $this->MyquizModel = new MyquizModel;
    }
    public function index($idQuiz = NULL)
    {
        $tokenjwt = new Tokenjwt;
        $data = $tokenjwt->checkToken($this->request->getServer('HTTP_AUTHORIZATION'));
        if ($data['status'] == 200) {
        } else {
            return $this->respond($data, 401);
        }
        helper('menu');
        $result = $this->model->where(["quiz_id" => $idQuiz])->findAll();
        $temp = [];
        $id = 0;
        foreach ($result as $item) {
            $item['jawaban'] = NULL;
            $item['pembahasan'] = NULL;
            $item['image'] = base_url('assets/image/soalquiz') . '/' . $item['image'];
            $item['imagepembahasan'] = base_url('assets/image/soalquiz') . '/' . $item['imagepembahasan'];
            $temp[$id] = $item;
            $id++;
        }
        $response = [
            'status' => 200,
            'data' => $temp,
        ];
        return $this->respond($response, 200);
    }
    public function created($idUser = NULL, $idQuiz = NULL)
    {
        $tokenjwt = new Tokenjwt;
        $data = $tokenjwt->checkToken($this->request->getServer('HTTP_AUTHORIZATION'));
        if ($data['status'] == 200) {
        } else {
            return $this->respond($data, 401);
        }
        helper('menu');
        $result = $this->AnswerqModel->where(['user_id' => $idUser, 'quiz_id' => $idQuiz])->first();
        $quiz = $this->QuizModel->find($idQuiz);

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
                $this->AnswerqModel->save($data);
            } catch (Exception $th) {
                $answer = NULL;
            }
            $timestart = explode(' ', $result['created_at'])[1];
        } else {
            $Uuid = new Uuid;
            $json = $this->request->getJSON();
            try {
                $data = [
                    'id_answer' => $Uuid->v4(),
                    'user_id' => $idUser,
                    'quiz_id' => $idQuiz,
                    'answer' => $json->answer,
                ];
                $answer = $json->answer;
            } catch (Exception $th) {
                $answer = NULL;
                $data = array();
                $data = [
                    'id_answer' => $Uuid->v4(),
                    'user_id' => $idUser,
                    'quiz_id' => $idQuiz,
                ];
            }
            $this->AnswerqModel->insert($data);
            $result = $this->AnswerqModel->find($data['id_answer']);
            $timestart = explode(' ', $result['created_at'])[1];
        }
        $response = [
            'status' => 200,
            'message' => "Berhasil Submit",
            'data' => $answer,
            'time' => $quiz['t_mapel'],
            'timestart' => $timestart,
            'timestartsecond' => strtotime($timestart),
            'timeend' => date("H:i:s", strtotime($timestart) + ($quiz['t_mapel'] * 60)),
            'timeendsecond' => strtotime($timestart) + ($quiz['t_mapel'] * 60)
        ];
        return $this->respond($response, 200);
    }
    public function score($idUser = NULL, $idQuiz = NULL)
    {
        $tokenjwt = new Tokenjwt;
        $data = $tokenjwt->checkToken($this->request->getServer('HTTP_AUTHORIZATION'));
        if ($data['status'] == 200) {
        } else {
            return $this->respond($data, 401);
        }
        helper('menu');
        $result = $this->AnswerqModel->where(['user_id' => $idUser, 'quiz_id' => $idQuiz])->first();
        $quiz = $this->QuizModel->find($idQuiz);
        $myQuiz = $this->MyquizModel->where(['user_id' => $idUser, 'quiz_id' => $idQuiz])->first();
        if (
            $result
        ) {
            $no = 0;
            $correct = 0;
            $answer = explode(',', $result['answer']);
            foreach ($this->model->where('quiz_id', $idQuiz)->orderBy('no_soal', 'ASC')->findAll() as $item) {
                if ($answer[$no] == $item['jawaban']) {
                    $correct++;
                }
                $no++;
            }
            $percenValue = ($correct / $no) * 100;
            $data[] = [
                'correct' => $correct,
                'amountSoal' => $no,
                'percenValue' => $percenValue,
                'name' => $quiz['name'],
                'nameAdmin' => $this->UserModel->find($quiz['updated_by'])->username,
                'mediaId' => $quiz['media'],
                'media' => mediaQuiz($quiz['media']),
                'link' => $quiz['link'],
                'password' => $quiz['password'],
                'dateMeet' => $quiz['date_start_m'],
                'timeMeet' => $quiz['time_start_m'],
                'onPayment' => ($myQuiz['price'] == NULL ? false : true),
                'idQuiz' => $quiz['id_quiz']
            ];
            $response = [
                'status' => 201,
                'message' => 'Quiz  ditemukan!',
                'data' => $data
            ];
            return $this->respond($response, 201);
        } else {
            $response = [
                'status' => 201,
                'message' => 'Quiz tidak ditemukan!',
                'data' => NULL
            ];
            return $this->respond($response, 201);
        }
    }
}
