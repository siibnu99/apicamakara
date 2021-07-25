<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use \App\Libraries\Tokenjwt;
use App\Models\TokenModel;
use App\Models\UserApiModel;
use \App\Libraries\Uuid;

class Apiauth extends ResourceController
{
    protected $format       = 'json';
    protected $modelName    = 'App\Models\UserApiModel';
    public function __construct()
    {
        $this->TokenModel = new TokenModel();
        $this->UserApiModel = new UserApiModel();
    }
    public function login()
    {
        $tokenjwt = new Tokenjwt;
        if ($this->request) {
            //get request from Vue Js
            if ($this->request->getJSON()) {
                $json = $this->request->getJSON();
                if ($data = $this->model->where('email', $json->email)->first()) {
                    if (password_verify($json->password, $data['password'])) {
                        $data = [
                            'idUser' => $data['id_user'],
                        ];
                        $token = $tokenjwt->getToken($data);
                        $output = [
                            'status' => 200,
                            'message' => 'Berhasil login',
                            "token" => $token,
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
    public function register()
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
                $this->model->insert([
                    'id_user'     => $Uuid->v4(),
                    'fullname'     => $json->fullname,
                    'email'   => $json->email,
                    'password'   => password_hash($json->password, PASSWORD_DEFAULT),
                    'is_active'   => 1,
                ]);
                $msg = ['message' => 'User berhasil daftar!'];
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
    public function islogin()
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
        $json = $this->request->getJSON();
        $email = $json->email;
        helper('menu');
        $id = $this->model->where('email', $email)->first();
        if ($id) {
            $token = generateRandomString(9);
            $save = [
                'user_id' => $id['id_user'],
                'token_forgot' => $token,
                'exp' => date("Y-m-d H:i:s", time() + (10 * 60))
            ];
            if ($this->TokenModel->find($id['id_user'])) {
                $this->TokenModel->update($id['id_user'], $save);
            } else {
                $this->TokenModel->insert($save);
            }
            $email = \Config\Services::email();
            $email->setTo($id['email']);
            $email->setSubject('Forgot Password');
            $email->setMessage('Forgot Password berhasil dilakukan, Token yang di dapatkan adalah "' . $token . '"');
            $email->send();
            return $this->respond([
                'status' => 200,
                'errors'    => false,
                'message'    => "Token sudah terkirim",
            ], 200);
        } else {
            return $this->respond([
                'status' => 201,
                'errors'    => 'Email tidak ditemukan',
            ], 201);
        }
    }
    public function tokenverif()
    {
        $json = $this->request->getJSON();
        $token = $json->token;
        $email = $json->email;
        $id = $this->model->where('email', $email)->first();
        $token = $this->TokenModel->where('token_forgot', $token)->first($id['id_user']);
        if ($id && $token) {
            if (strtotime($token['exp']) < time()) {
                return $this->respond([
                    'status' => 201,
                    'errors'    => false,
                    'message'    => "Token Expired",
                ], 200);
            } else {
                return $this->respond([
                    'status' => 200,
                    'errors'    => false,
                    'message'    => "Token benar",
                ], 201);
            }
        } else {
            return $this->respond([
                'status' => 201,
                'errors'    => 'Email atau Token tidak ditemukan ',
            ], 201);
        }
    }
    public function setpw()
    {
        $json = $this->request->getJSON();
        $token = $json->token;
        $email = $json->email;
        $id = $this->model->where('email', $email)->first();
        $token = $this->TokenModel->where('token_forgot', $token)->first($id['id_user']);
        if ($id && $token) {
            if (strtotime($token['exp']) < time()) {
                return $this->respond([
                    'status' => 201,
                    'errors'    => true,
                    'message'    => "Token Expired",
                ], 201);
            } else {
                $data = [
                    'password' => password_hash($json->password, PASSWORD_DEFAULT),
                    'id_user' => $id['id_user']
                ];
                $this->model->update($id['id_user'], $data);
                return $this->respond([
                    'status' => 200,
                    'errors'    => false,
                    'message'    => "Berhasil set password",
                ], 201);
            }
        } else {
            return $this->respond([
                'status' => 201,
                'errors'    => 'Email atau Token tidak ditemukan ',
            ], 201);
        }
    }
}
