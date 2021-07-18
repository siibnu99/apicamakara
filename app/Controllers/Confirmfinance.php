<?php

namespace App\Controllers;

use Pusher\Pusher;

class Confirmfinance extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'confirmfinance',
        ];
        return view('confirmfinance/index', $data);
    }
    public function confirm($id = NULL)
    {
        $result = $this->TopupModel->find($id);
        $data = [
            'status' => 2,
            'confirm_by' => user_id()
        ];
        delete_files('/assets/image/topup/' . $result['image']);
        $this->TopupModel->update($id, $data);
        $options = array(
            'cluster' => 'ap1',
            'useTLS' => true
        );
        $pusher = new Pusher(
            '9572fc108523db38ff8c',
            '00f81ecce367b823260d',
            '1235332',
            $options
        );
        $data['message'] = 'success';
        $pusher->trigger('my-channel', 'saldo', $data);

        return redirect()->to(base_url('admincamakara/confirmfinance'));
    }
    public function notconfirm($id = NULL)
    {
        $result = $this->TopupModel->find($id);
        $data = [
            'status' => 0,
            'confirm_by' => user_id()
        ];
        delete_files('/assets/image/topup/' . $result['image']);
        $this->TopupModel->update($id, $data);
        $options = array(
            'cluster' => 'ap1',
            'useTLS' => true
        );
        $pusher = new Pusher(
            '9572fc108523db38ff8c',
            '00f81ecce367b823260d',
            '1235332',
            $options
        );
        $data['message'] = 'success';
        $pusher->trigger('my-channel', 'saldo', $data);
        return redirect()->to(base_url('admincamakara/confirmfinance'));
    }
    public function listdata()
    {
        $request = \Config\Services::request();
        $list_data = $this->serverside_model;
        $where = ['status' => 1];
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
            $row[] = '<img width="50px" height="50px" src="' . base_url('assets/image/topup/') . '/' . $lists->image . '" alt="">';
            $row[] = $this->UserapiModel->find($lists->user_id)['fullname'];
            $row[] = AllPayment($lists->bank_id);
            $row[] = $lists->nominal;
            $row[] = $lists->created_at;
            $row[] = '<a class="btn btn-danger" href="' . base_url('admincamakara/confirmfinance/notconfirm') . '/' . $lists->id_topup . '">Tidak Diterima</a>
            <a class="btn btn-success" href="' . base_url('admincamakara/confirmfinance/confirm') . '/'  . $lists->id_topup . '">Diterima</a>';
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
