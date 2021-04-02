<?php

namespace App\Controllers;

class Confirmfinance extends BaseController
{
    public function index()
    {
        $topup = $this->TopupModel->select("*,tbl_topup.image AS imageTop,tbl_topup.created_at AS createdTop",)->where('status', 1)->join("tbl_user", "tbl_user.id_user = tbl_topup.user_id")->findAll();
        $data = [
            'title' => 'confirmfinance',
            'topup' => $topup
        ];
        return view('confirmfinance/index', $data);
    }
    public function confirm($id = NULL)
    {
        $result = $this->TopupModel->find($id);
        $data = [
            'status' => 2
        ];
        delete_files('/assets/image/topup/' . $result['image']);
        $this->TopupModel->update($id, $data);
        return redirect()->to(base_url('confirmfinance'));
    }
    public function notconfirm($id = NULL)
    {
        $result = $this->TopupModel->find($id);
        $data = [
            'status' => 0
        ];
        delete_files('/assets/image/topup/' . $result['image']);
        $this->TopupModel->update($id, $data);
        return redirect()->to(base_url('confirmfinance'));
    }
}
