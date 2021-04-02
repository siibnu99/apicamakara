<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
    public function index()
    {
        $countSoalMonth = 0;
        $countSoalMonth += $this->SoaltModel->like("created_at", date("Y-m-d"))->countAllResults();
        $countSoalMonth += $this->SoalqModel->like("created_at", date("Y-m-d"))->countAllResults();
        $countSoal = 0;
        $countSoal += $this->SoaltModel->like("created_at", date("Y"))->countAllResults();
        $countSoal += $this->SoalqModel->like("created_at", date("Y"))->countAllResults();
        $countFinance = $this->TopupModel->select("*,tbl_topup.image AS imageTop,tbl_topup.created_at AS createdTop",)->where('status', 1)->join("tbl_user", "tbl_user.id_user = tbl_topup.user_id")->countAllResults();
        $countFinanceConfirm = $this->TopupModel->select("*,tbl_topup.image AS imageTop,tbl_topup.created_at AS createdTop",)->where('status', 2)->join("tbl_user", "tbl_user.id_user = tbl_topup.user_id")->countAllResults();
        $countFinanceMonth = $this->TopupModel->selectSum('nominal', 'totalNominal')->like("created_at", date("Y"))->where('status', 2)->first();
        $countFinanceAll = $this->TopupModel->selectSum('nominal', 'totalNominal')->where('status', 2)->first();
        $data = [
            'title' => 'dashboard',
            'countSoalMonth' => $countSoalMonth,
            'countSoal' => $countSoal,
            'countFinance' => $countFinance,
            'countFinanceMonth' => $countFinanceMonth,
            'countFinanceConfirm' => $countFinanceConfirm,
            'countFinanceAll' => $countFinanceAll,
        ];
        return view('dashboard/index', $data);
    }
}
