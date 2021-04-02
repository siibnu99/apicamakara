<?php

namespace App\Controllers;

class Tabledata extends BaseController
{
    public function index()
    {
        $topup = $this->TopupModel->select("*,tbl_topup.image AS imageTop,tbl_topup.created_at AS createdTop",)->where('status', 2)->join("tbl_user", "tbl_user.id_user = tbl_topup.user_id")->findAll();
        $data = [
            'title' => 'tabledata',
            'topup' => $topup
        ];
        return view('tabledata/index', $data);
    }
}
