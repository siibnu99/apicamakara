<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use \App\Libraries\Uuid;
use \App\Libraries\Tokenjwt;
use \App\Models\UserApiModel;
use App\Models\TopupModel;
use App\Models\TransferModel;
use App\Models\MytryoutModel;
use App\Models\SoaltModel;
use App\Models\MyquizModel;

class Apitransfer extends ResourceController
{
    protected $format       = 'json';
    protected $modelName    = 'App\Models\TransferModel';
    private $UserapiModel;
    public function _getSaldo($idUser = NULL)
    {
        $TopupModel = new TopupModel();
        $TransferModel = new TransferModel();
        $MytryoutModel = new MytryoutModel();
        $SoaltModel = new SoaltModel();
        $MyquizModel = new MyquizModel();
        $topup = $TopupModel->selectSum('nominal', 'totalNominal')->where(['user_id' => $idUser, 'status' => '2'])->first()['totalNominal'];
        $transferFrom = $TransferModel->selectSum('nominal', 'totalNominal')->where('from_id', $idUser)->first()['totalNominal'];
        $transferTo = $TransferModel->selectSum('nominal', 'totalNominal')->where('to_id', $idUser)->first()['totalNominal'];
        $dataMyTryout = $MytryoutModel->selectSum('tbl_tryout.price', 'totalNominal')->where(['user_id' => $idUser, 'tbl_tryout.payment_method' => '2', 'payment_id' => '2'])->join('tbl_tryout', 'tbl_tryout.id_tryout = tbl_mytryout.tryout_id')->first()['totalNominal'];
        $dataMyTryout3 = $MytryoutModel->selectSum('tbl_mytryout.price', 'totalNominal')->where(['user_id' => $idUser, 'tbl_tryout.payment_method' => '3', 'payment_id' => '3'])->join('tbl_tryout', 'tbl_tryout.id_tryout = tbl_mytryout.tryout_id')->first()['totalNominal'];
        $dataMyquiz = $MyquizModel->selectSum('price', 'totalNominal')->where('user_id', $idUser)->first()['totalNominal'];
        return $topup + $transferTo - $transferFrom - $dataMyTryout - $dataMyTryout3 - $dataMyquiz;
    }
    public function __construct()
    {

        $this->UserapiModel = new UserApiModel;
    }
    public function index()
    {
        $tokenjwt = new Tokenjwt;
        $data = $tokenjwt->checkToken($this->request->getServer('HTTP_AUTHORIZATION'));
        if ($data['status'] == 200) {
        } else {
            return $this->respond($data, 401);
        }
        $tokenjwt = new Tokenjwt;
        $data = $tokenjwt->checkToken($this->request->getServer('HTTP_AUTHORIZATION'));
        if ($data['status'] == 200) {
        } else {
            return $this->respond($data, 401);
        }
        if ($this->request) {
            if ($json = $this->request->getJSON()) {
                $data = $this->model->where('from_id', $json->id)->findAll();
                $response = [
                    'status' => 200,
                    'data' => $data,
                ];
                return $this->respond($response, 200);
            }
        }
    }
    public function show($id = NULL)
    {
        $tokenjwt = new Tokenjwt;
        $data = $tokenjwt->checkToken($this->request->getServer('HTTP_AUTHORIZATION'));
        if ($data['status'] == 200) {
        } else {
            return $this->respond($data, 401);
        }
        $tokenjwt = new Tokenjwt;
        $data = $tokenjwt->checkToken($this->request->getServer('HTTP_AUTHORIZATION'));
        if ($data['status'] == 200) {
        } else {
            return $this->respond($data, 401);
        }
        if ($this->request) {
            if ($id) {
                if ($json = $this->request->getJSON()) {
                    $data = $this->model->find($id);
                    $get['fullname'] = $data['fullname'];

                    $response = [
                        'status' => 200,
                        'data' => $get,
                    ];
                    return $this->respond($response, 200);
                }
            }
        }
    }
    public function create()
    {
        $tokenjwt = new Tokenjwt;
        $data = $tokenjwt->checkToken($this->request->getServer('HTTP_AUTHORIZATION'));
        if ($data['status'] == 200) {
        } else {
            return $this->respond($data, 401);
        }
        $Uuid = new Uuid;
        $tokenjwt = new Tokenjwt;
        // $data = $tokenjwt->checkToken($this->request->getServer('HTTP_AUTHORIZATION'));
        // if ($data['status'] == 200) {
        // } else {
        //     return $this->respond($data, 401);
        // }
        if ($this->request) {
            if ($this->request->getJSON()) {
                $json = $this->request->getJSON();
                $dataFrom = $this->UserapiModel->find($json->fromid);
                $dataTo = $this->UserapiModel->where('telp', $json->telp)->first();
                if ((int)$json->nominal > 0) {

                    if ($this->_getSaldo >= $json->nominal) {
                        $data = [
                            'id_transfer' => $Uuid->v4(),
                            'from_id' => $json->fromid,
                            'to_id' => $dataTo['id_user'],
                            'nominal' => $json->nominal,
                        ];
                        $this->model->insert($data);
                        $response = [
                            'status' => 200,
                            'message' => 'Success Transfer',
                        ];
                        return $this->respond($response, 200);
                    }
                    $response = [
                        'status' => 201,
                        'message' => 'Saldo tidak cukup',
                    ];
                    return $this->respond($response, 201);
                }
                $response = [
                    'status' => 201,
                    'message' => 'Minus',
                ];
                return $this->respond($response, 201);
            }
        }
    }
    public function getByTelp($telp = null)
    {
        $tokenjwt = new Tokenjwt;
        $data = $tokenjwt->checkToken($this->request->getServer('HTTP_AUTHORIZATION'));
        if ($data['status'] == 200) {
        } else {
            return $this->respond($data, 401);
        }
        if ($telp) {
            $data = $this->UserapiModel->select('id_user,fullname,telp')->where('telp', $telp)->first();
            $response = [
                'status' => 200,
                'data' => $data,
            ];
            return $this->respond($response, 200);
        }
    }
}
