<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use \App\Libraries\Uuid;
use \App\Libraries\Tokenjwt;

class Apibank extends ResourceController
{
    protected $format       = 'json';
    public function index()
    {
        helper("menu");
        // $tokenjwt = new Tokenjwt;
        // $data = $tokenjwt->checkToken($this->request->getServer('HTTP_AUTHORIZATION'));
        // if ($data['status'] == 200) {
        // } else {
        //     return $this->respond($data, 401);
        // }
        $data = AllPayment();
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
            $data = AllPayment($id);
        } else {
            $data = AllPayment();
        }
        $response = [
            'status' => 200,
            'data' => $data,
        ];
        return $this->respond($response, 200);
    }
}
