<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class Apiprov extends ResourceController
{
    protected $format       = 'json';
    protected $modelName    = 'App\Models\ProvModel';
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
            $data = $this->model->where('province_id', $id)->first();
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
