<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use \App\Libraries\Uuid;
use \App\Libraries\Tokenjwt;
use \App\Models\MytryoutModel;

class Apitryout extends ResourceController
{
    protected $format       = 'json';
    protected $modelName    = 'App\Models\TryoutModel';
    private $limit = 10;
    public function __construct()
    {
        $this->MytryoutModel = new \App\Models\MytryoutModel;
    }
    public function index($iduser = null)
    {
        if ($this->request) {
            $tryout = $this->model->where('active', 1)->findAll();
            $result = [];
            if ($iduser) {
                foreach ($tryout as $item) {
                    if (!$this->MytryoutModel->where(['user_id' => $iduser, 'tryout_id' => $item['id_tryout']])->first()) {
                        $result[] = $item;
                    }
                }
            } else {
                $result = $tryout;
            }
            $temp = array();
            $id = 0;
            foreach ($result as $item) {
                $temp[] = $item;
                $temp[$id]['image'] = base_url('assets/image/tryout') . '/' . $temp[$id]['image'];
                $id++;
            }
            $data = [
                "tryouts" => $temp,
            ];
            $response = [
                'status' => 200,
                'data' => $data,
            ];
            return $this->respond($response, 200);
        }
        return redirect()->back();
    }
    public function show($id = null)
    {
        if ($this->request) {
            helper('menu');
            if ($id) {
                $data = $this->model->where('active', 1)->find($id);
                $totalSaint = 0;
                $totalSoshum = 0;
                $dataMapel = mapel(1, $data);
                foreach ($dataMapel as $item) {
                    $totalSaint +=  $item[2];
                }
                $dataMapel = mapel(2, $data);
                foreach ($dataMapel as $item) {
                    $totalSoshum += $item[2];
                }
                $data['totalSaint'] = $totalSaint + 30;
                $data['totalSoshum'] = $totalSoshum + 30;
                $mytryout = new MytryoutModel();
                $countPersonBuy = $mytryout->where('tryout_id', $id)->countAllResults();
                $data['personBuy'] = $countPersonBuy;
            } else {
                $data = $this->model->where('active', 1)->findAll();
            }
            $response = [
                'status' => 200,
                'data' => $data,
            ];
            return $this->respond($response, 200);
        }
        return redirect()->back();
    }
}
