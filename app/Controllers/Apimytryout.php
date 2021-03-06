<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use \App\Libraries\Uuid;
use \App\Libraries\Tokenjwt;

class Apimytryout extends ResourceController
{
    protected $format       = 'json';
    protected $modelName    = 'App\Models\MytryoutModel';
    private $limit = 10;

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
    public function index($page = 1)
    {
        if ($this->request) {
            if ($this->request->getJSON()) {
                $json = $this->request->getJSON();
                $tryout = $this->model->where('user_id', $json->id)->findAll($this->limit, $this->getOffset($page));
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
        }
        return redirect()->back();
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
}
