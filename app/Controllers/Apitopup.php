<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use \App\Libraries\Uuid;
use \App\Libraries\Tokenjwt;

class Apitopup extends ResourceController
{
    protected $format       = 'json';
    protected $modelName    = 'App\Models\TopupModel';

    public function index()
    {
        $tokenjwt = new Tokenjwt;
        $data = $tokenjwt->checkToken($this->request->getServer('HTTP_AUTHORIZATION'));
        if (!$data['status'] == 200) {
            return $this->respond($data, 401);
        }
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
        $tokenjwt = new Tokenjwt;
        $data = $tokenjwt->checkToken($this->request->getServer('HTTP_AUTHORIZATION'));
        if ($data['status'] == 200) {
        } else {
            return $this->respond($data, 401);
        }
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
    public function create()
    {

        $tokenjwt = new Tokenjwt;
        $data = $tokenjwt->checkToken($this->request->getServer('HTTP_AUTHORIZATION'));
        // if ($data['status'] == 200) {
        // } else {
        //     return $this->respond($data, 401);
        // }
        if ($this->request->getVar('bankid') != 0) {
            $Uuid = new Uuid;
            // if ($this->request) {
            //     if ($this->request->getJSON()) {
            $namaFile = $_FILES['image']['name'];
            $ektensiGambar = explode('.', $namaFile);
            $ektensiGambar = strtolower(end($ektensiGambar));
            $namaFile = $Uuid->v4() . '.' . $ektensiGambar;

            $namaSementara = $_FILES['image']['tmp_name'];

            // tentukan lokasi file akan dipindahkan
            $dirUpload = "assets/image/topup/";

            // pindahkan file
            $terupload = move_uploaded_file($namaSementara, $dirUpload . $namaFile);
            $json = $this->request->getJSON();
            $data = [
                'id_topup' => $Uuid->v4(),
                'user_id' => $this->request->getVar('id'),
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
        } else {
            $response = [
                'status' => 201,
                'message' => 'Mohon Pilih Bank',
            ];
        }
        return $this->respond($response, 200);
    }
}
