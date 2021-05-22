<?php

namespace App\Controllers;

class Confirm extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'confirm',
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
    public function listdata()
    {
        $request = \Config\Services::request();
        $list_data = $this->serverside_model;
        $where = ['status' => 1];
        $column_order = array(NULL, 'tbl_mytryout.tryout_id', 'tbl_mytryout.user_id', 'tbl_mytryout.created_at', NULL);
        $column_search = array('tbl_mytryout.tryout_id', 'tbl_mytryout.user_id', 'tbl_mytryout.created_at');
        $order = array('tbl_mytryout.created_at' => 'asc');
        $list = $list_data->get_datatables('tbl_mytryout', $column_order, $column_search, $order, $where);
        $data = array();
        $no = $request->getPost("start");
        foreach ($list as $lists) {
            $no++;
            $row   = array();
            $row[] = $no;
            $row[] = $this->TryoutModel->find($lists->tryout_id)['name'];
            $row[] = $this->UserapiModel->find($lists->user_id)['fullname'];
            $images =  explode(',', $lists->image);
            $dataImage = '';
            foreach ($images as $image) :
                if ($image) :
                    $dataImage .= '<a href="' . base_url('assets/image/ruleto') . '/' . $image . '" target="_blank" class="badge badge-primary">Lihat Detail</a>
                                        <br>';
                endif;
            endforeach;
            $row[] = $dataImage;
            $row[] = $lists->created_at;
            $row[] = '<a class="btn btn-danger" href="' . base_url('confirm/notconfirm') . '/' . $lists->id_mytryout . '">Tidak Diterima</a>
            <a class="btn btn-success" href="' . base_url('confirm/confirm') . '/'  . $lists->id_mytryout . '">Diterima</a>';
            $data[] = $row;
        }
        $output = array(
            "draw" => $request->getPost("draw"),
            "recordsTotal" => $list_data->count_all('tbl_mytryout', $where),
            "recordsFiltered" => $list_data->count_filtered('tbl_mytryout', $column_order, $column_search, $order, $where),
            "data" => $data,
        );
        return json_encode($output);
    }
}
