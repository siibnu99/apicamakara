<?php

namespace App\Controllers;

class Confirm extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'confirm',
            'reports' => $this->MytryoutModel->select()->join('tbl_tryout', 'tbl_tryout.id_tryout = tbl_mytryout.tryout_id')->join('tbl_user', 'tbl_user.id_user = tbl_mytryout.user_id')->findAll()
        ];
        return view('confirm/index', $data);
    }
}
