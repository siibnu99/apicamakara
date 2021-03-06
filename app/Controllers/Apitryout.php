<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use \App\Libraries\Uuid;
use \App\Libraries\Tokenjwt;

class Apitryout extends ResourceController
{
    protected $format       = 'json';
    protected $modelName    = 'App\Models\TryoutModel';
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
            $tryout = $this->model->findAll($this->limit, $this->getOffset($page));
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
        return redirect()->back();
    }
    public function show($id = null)
    {
        if ($this->request) {
            helper('menu');
            if ($id) {
                $data = $this->model->find($id);
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
            } else {
                $data = $this->model->findAll();
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
