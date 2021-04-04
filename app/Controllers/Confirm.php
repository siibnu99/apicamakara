<?php

namespace App\Controllers;

class Confirm extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'confirm',
            'reports' => $this->MytryoutModel->select('*,tbl_mytryout.image AS imageto')->join('tbl_tryout', 'tbl_tryout.id_tryout = tbl_mytryout.tryout_id')->join('tbl_user', 'tbl_user.id_user = tbl_mytryout.user_id')->where('status', 1)->findAll()
        ];
        return view('confirm/index', $data);
    }
    public function confirm($id = NULL)
    {
        $result = $this->MytryoutModel->find($id);
        $data = [
            'status' => 2
        ];
        delete_files('/assets/image/ruleto/' . $result['image']);
        $this->MytryoutModel->update($id, $data);
        return redirect()->to(base_url('confirm'));
    }
    public function notconfirm($id = NULL)
    {
        $result = $this->MytryoutModel->find($id);
        $data = [
            'status' => 0
        ];
        delete_files('/assets/image/ruleto/' . $result['image']);
        $this->MytryoutModel->update($id, $data);
        return redirect()->to(base_url('confirm'));
    }
}
