<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use \App\Libraries\Uuid;
use \App\Libraries\Tokenjwt;

class Apiuniv extends ResourceController
{
    protected $format       = 'json';
    protected $modelName    = 'App\Models\UnivModel';
    public function index()
    {
        // $tokenjwt = new Tokenjwt;
        // $data = $tokenjwt->checkToken($this->request->getServer('HTTP_AUTHORIZATION'));
        // if ($data['status'] == 200) {
        // } else {
        //     return $this->respond($data, 401);
        // }
        $data = $this->model->findAll();
        $response = [
            'status' => 200,
            'data' => $data,
        ];
        return $this->respond($response, 200);
    }
    public function show($id = null)
    {
        // $tokenjwt = new Tokenjwt;
        // $data = $tokenjwt->checkToken($this->request->getServer('HTTP_AUTHORIZATION'));
        // if ($data['status'] == 200) {
        // } else {
        //     return $this->respond($data, 401);
        // }
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
}
