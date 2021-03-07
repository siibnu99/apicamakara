<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use \App\Libraries\Uuid;
use \App\Libraries\Tokenjwt;
use \App\Models\UserApiModel;

class Apitransfer extends ResourceController
{
    protected $format       = 'json';
    protected $modelName    = 'App\Models\TransferModel';
    private $UserapiModel;
    public function __construct()
    {

        $this->UserapiModel = new UserApiModel;
    }
    public function index()
    {
        if ($this->request) {
            if ($json = $this->request->getJSON()) {
                $data = $this->model->where('from_id', $json->id)->findAll();
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
                $json = $this->request->getJSON();
                $dataFrom = $this->UserapiModel->find($json->fromid);
                $dataTo = $this->UserapiModel->where('telp', $json->telp)->first();
                if ($dataFrom['saldo'] >= $json->nominal) {
                    $data = [
                        'id_transfer' => $Uuid->v4(),
                        'from_id' => $json->fromid,
                        'to_id' => $dataTo['id_user'],
                        'nominal' => $json->nominal,
                    ];
                    $this->model->insert($data);
                    $response = [
                        'status' => 200,
                        'message' => 'Success Transfer',
                    ];
                    return $this->respond($response, 200);
                }
                $response = [
                    'status' => 201,
                    'message' => 'Saldo tidak cukup',
                ];
                return $this->respond($response, 201);
            }
        }
    }
    public function getByTelp($telp = null)
    {
        $tokenjwt = new Tokenjwt;
        $data = $tokenjwt->checkToken($this->request->getServer('HTTP_AUTHORIZATION'));
        if ($data['status'] == 200) {
        } else {
            return $this->respond($data, 401);
        }
        if ($telp) {
            $data = $this->UserapiModel->where('telp', $telp)->first();
            $response = [
                'status' => 200,
                'data' => $data,
            ];
            return $this->respond($response, 200);
        }
    }
}
