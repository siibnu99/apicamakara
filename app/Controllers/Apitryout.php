<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use \App\Libraries\Uuid;
use \App\Libraries\Tokenjwt;

class Apitryout extends ResourceController
{
    protected $format       = 'json';
    protected $modelName    = 'App\Models\TryoutModel';
    public function index()
    {
        if ($this->request->isAjax()){
            $tokenjwt = new Tokenjwt;
            $data = $this->model->findAll();
            $response = [
                'status' => 200,
                'data' => $data,
            ];
            return $this->respond($response, 200);
        }
        return redirect()->back();
    }
    public function show($id = null)
    {
        if ($this->request->isAjax()){
            
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
        return redirect()->back();
    }
}
