<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use \App\Libraries\Uuid;
use \App\Libraries\Tokenjwt;
use Pusher\Pusher;

class Apitopup extends ResourceController
{
    protected $format       = 'json';
    protected $modelName    = 'App\Models\TopupModel';

    public function index()
    {
        $idUser = $this->request->auth->idUser;
        $data = $this->model->where('user_id', $idUser)->findAll();
        $response = [
            'status' => 200,
            'data' => $data,
        ];
        return $this->respond($response, 200);
    }
    public function show($id = NULL)
    {
        if ($id) {
            $data = $this->model->find($id);
            $response = [
                'status' => 200,
                'data' => $data,
            ];
            return $this->respond($response, 200);
        }
    }
    public function create()
    {
        $idUser = $this->request->auth->idUser;
        if ($this->request->getVar('bankid') != 0) {
            $Uuid = new Uuid;
            $namaFile = $_FILES['image']['name'];
            $ektensiGambar = explode('.', $namaFile);
            $ektensiGambar = strtolower(end($ektensiGambar));
            $namaFile = $Uuid->v4() . '.' . $ektensiGambar;
            $namaSementara = $_FILES['image']['tmp_name'];
            $dirUpload = "assets/image/topup/";
            move_uploaded_file($namaSementara, $dirUpload . $namaFile);
            $data = [
                'id_topup' => $Uuid->v4(),
                'user_id' => $idUser,
                'bank_id' => $this->request->getVar('bankid'),
                'nominal' => $this->request->getVar('nominal'),
                'image' => $namaFile,
                'status' => 1,
            ];
            $this->model->insert($data);
            $response = [
                'status' => 200,
                'message' => 'Success Top Up',
            ];
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
            $pusher->trigger('my-channel', 'confirmfinance', $data);
        } else {
            $response = [
                'status' => 201,
                'message' => 'Mohon Pilih Bank',
            ];
        }
        return $this->respond($response, 200);
    }
}
