<?php

namespace App\Controllers;

use App\Models\UserApiModel;
use CodeIgniter\RESTful\ResourceController;

class Apiprofile extends ResourceController
{
    protected $format       = 'json';
    protected $modelName    = 'App\Models\UserApiModel';

    public function __construct()
    {
        $this->UserApiModel = new UserApiModel();
    }
    public function index()
    {
        $get = $this->model->find($this->request->auth->idUser);
        if ($get) {
            unset($get['password']);
            $get['saldo'] = $this->UserApiModel->getSaldo($this->request->auth->idUser);
            $code = 200;
            $get['province_id'] = ($get['province_id'] ? $get['province_id'] : 0);
            $get['regency_id'] = ($get['regency_id'] ? $get['regency_id'] : 0);
            $get['univ1_id'] = ($get['univ1_id'] ? $get['univ1_id'] : 0);
            $get['univ2_id'] = ($get['univ2_id'] ? $get['univ2_id'] : 0);
            $get['prodi1_id'] = ($get['prodi1_id'] ? $get['prodi1_id'] : 0);
            $get['prodi2_id'] = ($get['prodi2_id'] ? $get['prodi2_id'] : 0);
            $response = [
                'status' => $code,
                'error' => false,
                'data' => $get,
            ];
        } else {
            $code = 401;
            $msg = ['message' => 'Not Found'];
            $response = [
                'status' => $code,
                'error' => true,
                'data' => $msg,
            ];
        }
        return $this->respond($response, $code);
    }
    public function update($id = NULL)
    {
        $id = $this->request->auth->idUser;
        $json = $this->request->getJSON();
        $post = $this->model->update($id, [
            'firstname'     => $json->firstname,
            'lastname'     => $json->lastname,
            'fullname'     => $json->firstname . ' ' . $json->lastname,
            'telp'   => $json->telp,
            'school'   => $json->school,
            'graduate'   => $json->graduate,
            'province_id'   => $json->province_id,
            'regency_id'   => $json->regency_id,
            'address'   => $json->address,
            'univ1_id'   => $json->univ1_id,
            'univ2_id'   => $json->univ2_id,
            'prodi1_id'   => $json->prodi1_id,
            'prodi2_id'   => $json->prodi2_id,
            'image' => "default.jpg",
        ]);
        $msg = ['message' => 'Update user successfully'];
        $response = [
            'status' => 200,
            'error' => false,
            'data' => $msg,
        ];
        return $this->respond($response, 200);
    }
}
