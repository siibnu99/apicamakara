<?php

namespace App\Controllers;

class Tabledata extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'tabledata',
        ];
        return view('tabledata/index', $data);
    }
    public function listdata()
    {
        $request = \Config\Services::request();
        $list_data = $this->serverside_model;
        $where = ['status' => 2];
        $column_order = array(NULL, 'tbl_topup.tryout_id', 'tbl_topup.user_id', 'tbl_topup.created_at', NULL);
        $column_search = array('tbl_topup.tryout_id', 'tbl_topup.user_id', 'tbl_topup.created_at');
        $order = array('tbl_topup.created_at' => 'asc');
        $list = $list_data->get_datatables('tbl_topup', $column_order, $column_search, $order, $where);
        $data = array();
        $no = $request->getPost("start");
        foreach ($list as $lists) {
            $no++;
            $row   = array();
            $row[] = $no;
            $row[] = $this->UserapiModel->find($lists->user_id)['fullname'];
            $row[] = AllPayment($lists->bank_id);
            $row[] = $this->UserapiModel->find($lists->user_id)['email'];
            $row[] = $this->UserModel->find($lists->confirm_by)->email;
            $row[] = $lists->updated_at;
            $row[] = $lists->nominal;
            $data[] = $row;
        }
        $output = array(
            "draw" => $request->getPost("draw"),
            "recordsTotal" => $list_data->count_all('tbl_topup', $where),
            "recordsFiltered" => $list_data->count_filtered('tbl_topup', $column_order, $column_search, $order, $where),
            "data" => $data,
        );
        return json_encode($output);
    }
}
