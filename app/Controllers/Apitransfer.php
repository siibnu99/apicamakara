<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use \App\Libraries\Uuid;
use \App\Libraries\Tokenjwt;
use \App\Models\UserApiModel;
use Pusher\Pusher;

class Apitransfer extends ResourceController
{
    protected $format       = 'json';
    protected $modelName    = 'App\Models\TransferModel';

    public function __construct()
    {
        $this->UserApiModel = new UserApiModel;
    }
    public function index()
    {
        $iduser = $this->request->auth->idUser;
        if ($this->request) {
            $data = $this->model->where('from_id', $iduser)->findAll();
            $response = [
                'status' => 200,
                'data' => $data,
            ];
            return $this->respond($response, 200);
        }
    }
    public function show($id = NULL)
    {
        if ($id) {
            $data = $this->model->find($id);
            $get['fullname'] = $data['fullname'];

            $response = [
                'status' => 200,
                'data' => $get,
            ];
            return $this->respond($response, 200);
        }
    }
    public function create()
    {
        $iduser = $this->request->auth->idUser;
        $Uuid = new Uuid;
        if ($this->request) {
            if ($this->request->getJSON()) {
                $json = $this->request->getJSON();
                $dataTo = $this->UserApiModel->where('telp', $json->telp)->first();
                if ((int)$json->nominal > 0) {
                    if ($this->UserApiModel->getSaldo($dataTo['id_user']) >= $json->nominal) {
                        $data = [
                            'id_transfer' => $Uuid->v4(),
                            'from_id' => $iduser,
                            'to_id' => $dataTo['id_user'],
                            'nominal' => $json->nominal,
                        ];
                        $this->model->insert($data);
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
                $response = [
                    'status' => 201,
                    'message' => 'Minus',
                ];
                return $this->respond($response, 201);
            }
        }
    }
    public function getByTelp($telp = null)
    {
        if ($telp) {
            $data = $this->UserApiModel->select('id_user,fullname,telp')->where('telp', $telp)->first();
            $response = [
                'status' => 200,
                'data' => $data,
            ];
            return $this->respond($response, 200);
        }
    }
}
