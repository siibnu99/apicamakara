<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use \App\Libraries\Uuid;
use \App\Libraries\Tokenjwt;

class Apitopup extends ResourceController
{
    protected $format       = 'json';
    protected $modelName    = 'App\Models\TopupModel';

    public function __construct()
    {
        $tokenjwt = new Tokenjwt;
        $data = $tokenjwt->checkToken($this->request->getServer('HTTP_AUTHORIZATION'));
        if (!$data['status'] == 200) {
            return $this->respond($data, 401);
        }
    }
    public function index()
    {
        if ($this->request) {
            if ($json = $this->request->getJSON()) {
                $data = $this->model->where('user_id', $json->id)->findAll();
                $response = [
                    'status' => 200,
                    'data' => $data,
                ];
                return $this->respond($response, 200);
            }
        }
    }
    public function show($id = NULL)
    {
        if ($this->request) {
            if ($id) {
                if ($json = $this->request->getJSON()) {
                    $data = $this->model->find($id);
                    $response = [
                        'status' => 200,
                        'data' => $data,
                    ];
                    return $this->respond($response, 200);
                }
            }
        }
    }
    public function created()
    {
        $Uuid = new Uuid;
        if ($this->request) {
            if ($this->request->getJSON()) {
                $upload = $this->request->getFile('image');
                if ($upload->getError() == 4) {
                    $nameimage = NULL;
                } else {
                    $nameimage = $upload->getRandomName();
                    $upload->move('assets/img/topup/', $nameimage);
                }
                $json = $this->request->getJSON();
                $data = [
                    'id_topup' => $Uuid->v4(),
                    'user_id' => $json->id,
                    'bank_id' => $json->bankid,
                    'nominal' => $json->nominal,
                    'image' => $nameimage,
                    'status' => 1,
                ];
                $this->model->insert($data);
                $response = [
                    'status' => 200,
                    'message' => 'Success Top Up',
                ];
                return $this->respond($response, 200);
            }
        }
    }
}
