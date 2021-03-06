<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use \App\Libraries\Uuid;
use \App\Libraries\Tokenjwt;

class Apiuser extends ResourceController
{
    protected $format       = 'json';
    protected $modelName    = 'App\Models\UserApiModel';
    public function index()
    {
        $tokenjwt = new Tokenjwt;
        if ($this->request) {
            //get request from Vue Js
            if ($this->request->getJSON()) {
                $json = $this->request->getJSON();
                if ($data = $this->model->where('email', $json->email)->first()) {
                    if (password_verify($json->password, $data['password'])) {
                        $data = [
                            "id" => $data['id_user'],
                            "firstname" => $data['fullname'],
                            "email" => $data['email']
                        ];
                        $token = $tokenjwt->getToken($data);
                        $output = [
                            'status' => 200,
                            'message' => 'Berhasil login',
                            "token" => $token,
                            "data" => $data,
                        ];
                        return $this->respond($output, 200);
                    } else {
                        $msg = 'Username atau Password salah';
                    }
                } else {
                    $msg = 'Username atau Password tidak benar';
                }
                if ($msg != null) return $this->respond([
                    'statusCode' => 200,
                    'errors'    => $msg,
                ], 201);
            } else {
                return  "404 Not found";
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
        $get = $this->model->find($id);
        if ($get) {
            $code = 200;
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
    public function create()
    {
        $Uuid = new Uuid;
        if ($this->request) {
            if ($this->request->getJSON()) {
                $json = $this->request->getJSON();
                if ($this->model->where('email', $json->email)->first()) {
                    $response = [
                        'status' => 201,
                        'error' => false,
                        'data' => 'Email sudah terdaftar',
                    ];
                    return $this->respond($response, 201);
                }
                $dataR = $this->model->insert([
                    'id_user'     => $Uuid->v4(),
                    'fullname'     => $json->fullname,
                    'email'   => $json->email,
                    'password'   => password_hash($json->password, PASSWORD_DEFAULT),
                    'telp'   => $json->telp,
                    'is_active'   => 1,
                ]);
                if ($dataR) {
                    $msg = ['message' => 'Created user successfully'];
                    $response = [
                        'status' => 200,
                        'error' => false,
                        'data' => $msg,
                    ];
                    return $this->respond($response, 200);
                }
                $response = [
                    'status' => 404,
                ];
                return $this->respond($response, 201);
            }
            $response = [
                'status' => 404,
            ];
            return $this->respond($response, 201);
        }
        $response = [
            'status' => 404,
        ];
        return $this->respond($response, 201);
    }
    public function update($id = null)
    {
        $tokenjwt = new Tokenjwt;
        $data = $tokenjwt->checkToken($this->request->getServer('HTTP_AUTHORIZATION'));
        if ($data['status'] == 200) {
        } else {
            return $this->respond($data, 401);
        }
        $data = $this->model->find($id);
        $upload = $this->request->getFile('image');
        if ($upload->getError() == 4) {
            $nameimage = $data['image'];
        } else {
            if ($data['image'] != 'defaut.jpg') {
                unlink('assets/img/user/' . $data['image']);
            }
            $nameimage = $upload->getRandomName();
            $upload->move('assets/img/user/', $nameimage);
        }
        $json = $this->request->getJSON();
        $post = $this->model->update($id, [
            'firstname'     => $json->firstname,
            'lastname'     => $json->lastname,
            'fullname'     => $json->firstname . ' ' . $json->lastname,
            'school'   => $json->school,
            'graduate'   => $json->graduate,
            'province_id'   => $json->province_id,
            'regency_id'   => $json->regency_id,
            'address'   => $json->address,
            'univ1_id'   => $json->univ1_id,
            'univ2_id'   => $json->univ2_id,
            'prodi1_id'   => $json->prodi1_id,
            'prodi2_id'   => $json->prodi2_id,
        ]);
        $msg = ['message' => 'Update user successfully'];
        $response = [
            'status' => 200,
            'error' => false,
            'data' => $msg,
        ];
        return $this->respond($response, 200);
    }
    public function isLogin()
    {
        $tokenjwt = new Tokenjwt;
        $data = $tokenjwt->checkToken($this->request->getServer('HTTP_AUTHORIZATION'));
        if ($data['status'] == 200) {
            return $this->respond($data, 200);
        } else {
            return $this->respond($data, 401);
        }
    }
    public function forgot()
    {
        $password = uniqid('pass');
        $id = $this->model->where('email', $this->request->getVar('email'))->first();
        if ($id) {
            $data = [
                'password' => password_hash($password, PASSWORD_DEFAULT)
            ];
            $this->model->update($id, $data);
            $email = \Config\Services::email();
            $email->setTo($this->request->getVar('email'));
            $email->setSubject('Forgot Password');
            $email->setMessage('Reset password berhasil dilakukan, password baru adalah ' . $password . ' silahkan login menggunakan password tersebut.');
            $email->send();
            return $this->respond([
                'statusCode' => 200,
                'errors'    => false,
                'message'    => "Reset password berhasil dilakukan",
            ], 201);
        } else {
            return $this->respond([
                'statusCode' => 201,
                'errors'    => 'Email tidak diteumakan',
            ], 201);
        }
    }
}
