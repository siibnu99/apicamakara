<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use \App\Libraries\Uuid;
use \App\Libraries\Tokenjwt;
use App\Models\UserApiModel;
use App\Models\TryoutModel;

class Apimytryout extends ResourceController
{
    protected $format       = 'json';
    protected $modelName    = 'App\Models\MytryoutModel';
    private $limit = 10;
    private $UserapiModel;
    private $TryoutModel;
    public function __construct()
    {

        $this->UserapiModel = new UserApiModel;
        $this->TryoutModel = new TryoutModel;
    }
    private function getOffset($page)
    {
        $offset = ($page - 1) * $this->limit;
        return $offset;
    }
    private function getPageCount($countData)
    {
        $pageCount = ceil($countData / $this->limit);
        return $pageCount;
    }
    public function index($page = 1, $iduser = null)
    {

        $tryout = $this->model->where('user_id', $iduser)->join('tbl_tryout', 'tbl_tryout.id_tryout = tbl_mytryout.tryout_id')->findAll($this->limit, $this->getOffset($page));
        $countData = $this->model->countAll();
        $page = (int) $page;
        $pageCount = $this->getPageCount($countData);
        $data = [
            "page" => $page,
            "perpage" => $this->limit,
            "pageCount" => $pageCount,
            "count" => $countData,
            "tryouts" => $tryout,
        ];
        $response = [
            'status' => 200,
            'data' => $data,
        ];
        return $this->respond($response, 200);
    }
    public function check()
    {
        if ($this->request) {
            if ($json = $this->request->getJSON()) {
                $result = $this->model->where(['user_id' => $json->iduser, 'tryout_id' => $json->idtryout])->first();
                if ($result) {
                    $response = [
                        'status' => true,
                    ];
                    return $this->respond($response, 200);
                } else {
                    $response = [
                        'status' => false,
                    ];
                    return $this->respond($response, 200);
                }
            }
        }
        return redirect()->back();
    }
    public function create()
    {
        $Uuid = new Uuid;
        $json = $this->request->getJSON();
        if ($this->request) {
            if ($this->request->getJSON()) {
                if ($this->model->where(['user_id' => $json->iduser, 'tryout_id' => $json->idtryout])) {
                    $response = [
                        'status' => 201,
                        'message' => 'Tryout Sudah dibeli!',
                    ];
                    return $this->respond($response, 201);
                } else {


                    $dataFrom = $this->UserapiModel->find($json->iduser);
                    $dataTryout = $this->TryoutModel->find($json->idtryout);
                    if ($dataTryout['payment_method'] == 1) {
                    } else if ($dataTryout['payment_method'] == 2) {

                        if ($dataFrom['saldo'] >= $dataTryout['price']) {
                            $data = [
                                'id_mytryout' => $Uuid->v4(),
                                'user_id' => $json->iduser,
                                'tryout_id' => $json->idtryout,
                            ];
                            $this->model->insert($data);
                            $response = [
                                'status' => 200,
                                'message' => 'Success Buying',
                            ];
                            return $this->respond($response, 200);
                        }
                        $response = [
                            'status' => 201,
                            'message' => 'Saldo tidak cukup',
                        ];
                        return $this->respond($response, 201);
                    } else {
                    }
                }
            }
        }
    }
}
