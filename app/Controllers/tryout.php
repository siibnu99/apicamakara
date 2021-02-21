<?php

namespace App\Controllers;

class Tryout extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'tryout'
        ];
        return view('tryout/index', $data);
    }
    public function create()
    {
        $data = [
            'title' => 'tryout',
            'validation' => \Config\Services::validation(),
        ];
        return view('tryout/create', $data);
    }
    public function attemptCreate()
    {
        if (!$this->validate([
            'name' => [
                'label'  => 'Nama Lengkap',
                'rules'  => 'required|min_length[4]',
                'errors' => [
                    'min_length' => '{field} kurang dari 4!',
                    'required' => '{field} Harus di isi!',
                ]
            ],
            'descipt' => [
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
        die;
    }
}
