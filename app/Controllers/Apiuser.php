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
                            "email" => $data['email'],
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
        if (!$this->validate([
            'fullname' => [
                'label'  => 'Nama Lengkap',
                'rules'  => 'required|min_length[4]',
                'errors' => [
                    'min_length' => '{field} kurang dari 4!',
                    'required' => '{field} Harus di isi!',
                ]
            ],
            'email' => [
                'label'  => 'Email',
                'rules'  => 'required|valid_email|is_unique[tbl_user.email]',
                'errors' => [
                    'valid_email' => '{field} tidak valid',
                    'required' => '{field} Harus di isi!',
                    'is_unique' => '{field} sudah terdaftar',
                ]
            ],
            'password' => [
                'label'  => 'Kata Sandi',
                'rules'  => 'required|min_length[8]',
                'errors' => [
                    'min_length' => '{field} minimal 8',
                    'required' => '{field} Harus di isi',
                ]
            ],
            'telp' => [
                'label'  => 'Nomor Telepon',
                'rules'  => 'required|min_length[8]',
                'errors' => [
                    'min_length' => '{field} minimal 8',
                    'required' => '{field} Harus di isi',
                ]
            ]

        ])) return $this->respond([
            'statusCode' => 201,
            'errors'    => $this->validator->getErrors(),
        ], 201);
        $post = $this->model->insert([
            'id_user'     => $Uuid->v4(),
            'fullname'     => $this->request->getVar('fullname'),
            'email'   => $this->request->getVar('email'),
            'password'   => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
            'telp'   => $this->request->getVar('telp'),
            'is_active'   => 1,
        ]);

        $msg = ['message' => 'Created user successfully'];
        $response = [
            'status' => 200,
            'error' => false,
            'data' => $msg,
        ];
        return $this->respond($response, 200);
    }
    public function edit($id = null)
    {
        $tokenjwt = new Tokenjwt;
        $data = $tokenjwt->checkToken($this->request->getServer('HTTP_AUTHORIZATION'));
        if (!$this->validate([
            'firstname' => [
                'label'  => 'Nama depan',
                'rules'  => 'required',
                'errors' => [
                    'required' => '{field} Harus di isi!',
                ]
            ],
            'lastname' => [
                'label'  => 'Nama belakang',
                'rules'  => 'required',
                'errors' => [
                    'required' => '{field} Harus di isi!',
                ]
            ],
            'school' => [
                'label'  => 'Sekolah',
                'rules'  => 'required',
                'errors' => [
                    'required' => '{field} Harus di isi!',
                ]
            ],
            'graduate' => [
                'label'  => 'Tahun lulus',
                'rules'  => 'required',
                'errors' => [
                    'required' => '{field} Harus di isi!',
                ]
            ],
            'graduate' => [
                'label'  => 'Tahun lulus',
                'rules'  => 'required',
                'errors' => [
                    'required' => '{field} Harus di isi!',
                ]
            ],
            'province_id' => [
                'label'  => 'Provinsi',
                'rules'  => 'required',
                'errors' => [
                    'required' => '{field} Harus di isi!',
                ]
            ],
            'regency_id' => [
                'label'  => 'Kota/Kabupaten',
                'rules'  => 'required',
                'errors' => [
                    'required' => '{field} Harus di isi!',
                ]
            ],
            'address' => [
                'label'  => 'Alamat',
                'rules'  => 'required',
                'errors' => [
                    'required' => '{field} Harus di isi!',
                ]
            ],
            'univ1_id' => [
                'label'  => 'Universitas pertama',
                'rules'  => 'required',
                'errors' => [
                    'required' => '{field} Harus di isi!',
                ]
            ],
            'univ2_id' => [
                'label'  => 'Universitas kedua',
                'rules'  => 'required',
                'errors' => [
                    'required' => '{field} Harus di isi!',
                ]
            ],
            'prodi1_id' => [
                'label'  => 'Prodi pertama',
                'rules'  => 'required',
                'errors' => [
                    'required' => '{field} Harus di isi!',
                ]
            ],
            'prodi2_id' => [
                'label'  => 'Prodi kedua',
                'rules'  => 'required',
                'errors' => [
                    'required' => '{field} Harus di isi!',
                ]
            ],
            'image_profile' => [
                'label'  => 'Image profile',
                'rules'  => 'max_size[image_profile,2048]|mime_in[image_profile,image/png,image/jpg]',
                'errors' => [
                    'max_size' => '{field} tidak boleh lebih dari 2 MB',
                    'mime_in' => '{field} tidak diperkenankan upload selain png dan jpg',
                ]
            ],

        ])) return $this->respond([
            'statusCode' => 201,
            'errors'    => $this->validator->getErrors(),
        ], 201);
        $data = $this->model->find($id);
        $upload = $this->request->getFile('userimage');
        if ($upload->getError() == 4) {
            $nameimage = $data['image'];
        } else {
            if ($data['image'] != 'defaut.svg') {
                unlink('assets/img/user/' . $data['image']);
            }
            $nameimage = $upload->getRandomName();
            $upload->move('assets/img/user/', $nameimage);
        }
        $post = $this->model->update([
            'firstname'     => $this->request->getVar('firstname'),
            'lastname'     => $this->request->getVar('lastname'),
            'fullname'     => $this->request->getVar('firstname') . ' ' . $this->request->getVar('lastname'),
            'school'   => $this->request->getVar('school'),
            'graduate'   => $this->request->getVar('graduate'),
            'province_id'   => $this->request->getVar('province_id'),
            'regency_id'   => $this->request->getVar('regency_id'),
            'address'   => $this->request->getVar('address'),
            'univ1_id'   => $this->request->getVar('univ1_id'),
            'univ2_id'   => $this->request->getVar('univ2_id'),
            'prodi1_id'   => $this->request->getVar('prodi1_id'),
            'prodi2_id'   => $this->request->getVar('prodi2_id'),
            'image_profile'   => $$nameimage,
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
