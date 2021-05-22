<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use \App\Libraries\Uuid;

class Apimyquiz extends ResourceController
{
    protected $format       = 'json';
    protected $modelName    = 'App\Models\MyquizModel';
    private $limit = 10;

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
        $response = [
            'status' => false,
        ];
        return $this->respond($response, 200);
    }
    public function check()
    {
        $response = [
            'status' => false,
        ];
        return $this->respond($response, 200);
    }
    public function create()
    {
        $Uuid = new Uuid;
        $json = $this->request->getJSON();
        if ($json != NULL) {
            if ($this->model->where(['user_id' => $json->iduser, 'quiz_id' => $json->idquiz])->first()) {
                $response = [
                    'status' => 201,
                    'message' => 'Quiz Sudah dibeli!',
                ];
                return $this->respond($response, 201);
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
            return $this->respond($response, 201);
        }
        $response = [
            'status' => false,
        ];
        return $this->respond($response, 200);
    }
}
