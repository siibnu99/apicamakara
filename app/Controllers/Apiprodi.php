<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use \App\Libraries\Uuid;
use \App\Libraries\Tokenjwt;

class Apiprodi extends ResourceController
{
    protected $format       = 'json';
    protected $modelName    = 'App\Models\ProdiModel';
    public function index()
    {
        $data = $this->model->findAll();
        $response = [
            'status' => 200,
            'data' => $data,
        ];
        return $this->respond($response, 200);
    }
    public function show($id = null)
    {
        if ($id) {
            $data = $this->model->find($id);
        } else {
            $data = $this->model->findAll();
        }
        $response = [
            'status' => 200,
            'data' => $data,
        ];
        return $this->respond($response, 200);
    }
    public function get($id = null)
    {
        if ($id) {
            $data = $this->model->where('univ_id', $id)->find();
        } else {
            $data = $this->model->findAll();
        }
        $response = [
            'status' => 200,
            'data' => $data,
        ];
        return $this->respond($response, 200);
    }
}
