<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
    public function index()
    {
        $countSoalMonth = 0;
        $countSoalMonth += $this->SoaltModel->like("created_at", date("Y"))->countAllResults();
        $countSoalMonth += $this->SoalqModel->like("created_at", date("Y"))->countAllResults();
        $countSoal = 0;
        $countSoal += $this->SoaltModel->like("created_at", date("Y"))->countAllResults();
        $countSoal += $this->SoalqModel->like("created_at", date("Y"))->countAllResults();
        $countFinance = $this->TopupModel->select("*,tbl_topup.image AS imageTop,tbl_topup.created_at AS createdTop",)->where('status', 1)->join("tbl_user", "tbl_user.id_user = tbl_topup.user_id")->countAllResults();
        $countFinanceConfirm = $this->TopupModel->select("*,tbl_topup.image AS imageTop,tbl_topup.created_at AS createdTop",)->where('status', 2)->join("tbl_user", "tbl_user.id_user = tbl_topup.user_id")->countAllResults();
        $countFinanceMonth = $this->TopupModel->selectSum('nominal', 'totalNominal')->like("created_at", date("Y"))->where('status', 2)->first();
        $countFinanceAll = $this->TopupModel->selectSum('nominal', 'totalNominal')->where('status', 2)->first();
        $dataBulananFinanceCart = '';
        $dataBulananFinanceCart .= '[';
        for ($i = 1; $i <= 12; $i++) {
            $i < 10 ? $date = "0" . $i : $date = $i;
            if ($total = $this->TopupModel->selectSum('nominal', 'totalNominal')->like("created_at", date("Y") . '-' . $date)->where('status', 2)->first()['totalNominal']) {
                $dataBulananFinanceCart .= $total;
            } else {
                $dataBulananFinanceCart .= 0;
            }
            $i == 12 ? '' : $dataBulananFinanceCart .= ',';
        }
        $dataBulananFinanceCart .= '],';
        $dataBulananSoalCart = '';
        $dataBulananSoalCart .= '[';
        for ($i = 1; $i <= 12; $i++) {
            $i < 10 ? $date = "0" . $i : $date = $i;
            $countSoalMonth = 0;
            $countSoalMonth += $this->SoaltModel->like("created_at", date("Y") . '-' . $date)->countAllResults();
            $countSoalMonth += $this->SoalqModel->like("created_at", date("Y") . '-' . $date)->countAllResults();
            $dataBulananSoalCart .= $countSoalMonth;
            $i == 12 ? '' : $dataBulananSoalCart .= ',';
        }
        $dataBulananSoalCart .= '],';
        $data = [
            'title' => 'dashboard',
            'countSoalMonth' => $countSoalMonth,
            'countSoal' => $countSoal,
            'countFinance' => $countFinance,
            'countFinanceMonth' => $countFinanceMonth,
            'countFinanceConfirm' => $countFinanceConfirm,
            'countFinanceAll' => $countFinanceAll,
            'dataBulananFinanceCart' => $dataBulananFinanceCart,
            'dataBulananSoalCart' => $dataBulananSoalCart,
        ];
        return view('dashboard/index', $data);
    }
}
