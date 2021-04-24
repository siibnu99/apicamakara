<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use \App\Libraries\Uuid;
use \App\Libraries\Tokenjwt;
use App\Models\UserApiModel;
use App\Models\TryoutModel;
use App\Models\TransferModel;
use App\Models\TopupModel;
use App\Models\MytryoutModel;
use App\Models\AnswertModel;
use App\Models\SoaltModel;

class Apimytryout extends ResourceController
{
    protected $format       = 'json';
    protected $modelName    = 'App\Models\MytryoutModel';
    private $limit = 10;
    private $UserapiModel;
    private $TryoutModel;
    private $SoaltModel;
    public function _getSaldo($idUser = NULL)
    {
        $TopupModel = new TopupModel();
        $TransferModel = new TransferModel();
        $MytryoutModel = new MytryoutModel();
        $SoaltModel = new SoaltModel();
        $topup = $TopupModel->selectSum('nominal', 'totalNominal')->where(['user_id' => $idUser, 'status' => '2'])->first()['totalNominal'];
        $transferFrom = $TransferModel->selectSum('nominal', 'totalNominal')->where('from_id', $idUser)->first()['totalNominal'];
        $transferTo = $TransferModel->selectSum('nominal', 'totalNominal')->where('to_id', $idUser)->first()['totalNominal'];
        $dataMyTryout = $MytryoutModel->selectSum('tbl_tryout.price', 'totalNominal')->where(['user_id' => $idUser, 'tbl_tryout.payment_method' => '2', 'payment_id' => '2'])->join('tbl_tryout', 'tbl_tryout.id_tryout = tbl_mytryout.tryout_id')->first()['totalNominal'];
        $dataMyTryout3 = $MytryoutModel->selectSum('tbl_mytryout.price', 'totalNominal')->where(['user_id' => $idUser, 'tbl_tryout.payment_method' => '3', 'payment_id' => '3'])->join('tbl_tryout', 'tbl_tryout.id_tryout = tbl_mytryout.tryout_id')->first()['totalNominal'];
        return $topup + $transferTo - $transferFrom - $dataMyTryout - $dataMyTryout3;
    }
    public function __construct()
    {

        $this->UserapiModel = new UserApiModel;
        $this->TryoutModel = new TryoutModel;
        $this->AnswertModel = new AnswertModel;
        $this->SoaltModel = new SoaltModel();
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
    public function index($iduser = null)
    {
        helper('menu');
        $tryout = $this->model->where('user_id', $iduser)->join('tbl_tryout', 'tbl_tryout.id_tryout = tbl_mytryout.tryout_id')->findAll();
        $result = [];
        $i = 0;
        foreach ($tryout as $item) {
            $result[] = $item;
            $allMapel = getTypeMapel($item['type_tryout']);
            $result[$i]['statusAnswert'] = true;
            foreach ($allMapel as $Mapel) {
                if (!$this->AnswertModel->where(['user_id' => $iduser, 'tryout_id' => $item['id_tryout'], 'kind_tryout' => $Mapel[1]])->findAll()) {
                    $result[$i]['statusAnswert'] = false;
                    break;
                }
            }
            $i++;
        }
        $data = [
            "tryouts" => $result,
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
        if ($json != NULL) {
            if ($this->model->where(['user_id' => $json->iduser, 'tryout_id' => $json->idtryout, 'status' => '2'])->first()) {
                $response = [
                    'status' => 201,
                    'message' => 'Tryout Sudah dibeli!',
                ];
                return $this->respond($response, 201);
            }
        } else {
            if ($this->model->where(['user_id' => $this->request->getVar('iduser'), 'tryout_id' => $this->request->getVar('idtryout'), 'status' => '2'])->first()) {
                $response = [
                    'status' => 201,
                    'message' => 'Tryout Sudah dibeli!',
                ];
                return $this->respond($response, 201);
            }
        }
        if ($json != NULL) {
            $dataTryout = $this->TryoutModel->find($json->idtryout);
        } else {
            $dataTryout = $this->TryoutModel->find($this->request->getVar('idtryout'));
        }
        if ($dataTryout['payment_method'] == 1) {
            $nameImageTotal = NULL;
            $i = 2;
            for ($i = 1; $i <= 5; $i++) {
                if ($dataTryout['rule' . $i] != NULL) {
                    $namaFile = $_FILES['image' . $i]['name'];
                    $ektensiGambar = explode('.', $namaFile);
                    $ektensiGambar = strtolower(end($ektensiGambar));
                    $namaFile = $Uuid->v4() . '.' . $ektensiGambar;
                    $namaSementara = $_FILES['image' . $i]['tmp_name'];
                    $nameImageTotal = $nameImageTotal . $namaFile . ',';
                    // tentukan lokasi file akan dipindahkan
                    $dirUpload = "assets/image/ruleto/";
                    move_uploaded_file($namaSementara, $dirUpload . $namaFile);
                }
            }
            $data = [
                'id_mytryout' => $Uuid->v4(),
                'user_id' => $this->request->getVar('iduser'),
                'tryout_id' => $this->request->getVar('idtryout'),
                'payment_id' => 1,
                'image' => $nameImageTotal,
                'status' => 1,
            ];
            $this->model->insert($data);
            $response = [
                'status' => 200,
                'message' => 'Permintaan Sukses',
            ];
            return $this->respond($response, 200);
        } else if ($dataTryout['payment_method'] == 2) {
            if ($this->_getSaldo($json->iduser) >= $dataTryout['price']) {
                $data = [
                    'id_mytryout' => $Uuid->v4(),
                    'user_id' => $json->iduser,
                    'tryout_id' => $json->idtryout,
                    'payment_id' => 2,
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
            if ($json->price >= $dataTryout['price']) {
                if ($this->_getSaldo($json->iduser) >= $json->price) {
                    $data = [
                        'id_mytryout' => $Uuid->v4(),
                        'user_id' => $json->iduser,
                        'tryout_id' => $json->idtryout,
                        'payment_id' => 3,
                        'price' => $json->price,
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
                $response = [
                    'status' => 201,
                    'message' => 'Harga tidak melebihi minimum',
                ];
                return $this->respond($response, 201);
            }
        }
    }
    public function get($idUser = null, $id = null)
    {
        helper('menu');
        $mytryout = new MytryoutModel();
        $result = $mytryout->where(['user_id' => $idUser, 'tryout_id' => $id])->first();
        if ($result) {
            $data = $this->TryoutModel->find($id);
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
            $countPersonBuy = $mytryout->where('tryout_id', $id)->countAllResults();
            $data['personBuy'] = $countPersonBuy;
            $dataDikerjakan = $this->AnswertModel->where(['user_id' => $idUser, 'tryout_id' => $id])->findAll();
            $dataAnswert = [];
            foreach (getTypeMapel($data['type_tryout']) as $mapel) {
                $inData = [$mapel[1], 0];
                foreach ($dataDikerjakan as $answertData) {
                    if ($mapel[1] == $answertData['kind_tryout']) {
                        $inData[1] = 1;
                    }
                }
                $dataAnswert[] = $inData;
            }
            $data['tryoutanswert'] = $dataAnswert;
            $response = [
                'status' => 200,
                'data' => $data,
            ];
            return $this->respond($response, 200);
        } else {
            $response = [
                'status' => 201,
                'message' => "Tidak memiliki Tryout ini"
            ];
            return $this->respond($response, 200);
        }
    }
    public function getAnswert($idUser = null, $id = null, $kindTryout = NULL, $nomerSoalt = NULL)
    {
        helper('menu');
        $mytryout = new MytryoutModel();
        $result = $mytryout->where(['user_id' => $idUser, 'tryout_id' => $id])->first();
        if ($result) {
            if ($this->AnswertModel->where(['user_id' => $idUser, 'tryout_id' => $id, 'kind_tryout' => $kindTryout])->findAll()) {
                $dataAnswertResult = $this->SoaltModel->select('pembahasan,imagepembahasan,jawaban')->where(['tryout_id' => $id, 'kind_tryout' => $kindTryout, 'no_soal' => $nomerSoalt])->first();
                $data = $dataAnswertResult;
            } else {
                $data = "Belum dikerjakan";
            }
            $response = [
                'status' => 200,
                'data' => $data,
            ];
            return $this->respond($response, 200);
        } else {
            $response = [
                'status' => 201,
                'message' => "Tidak memiliki Tryout ini"
            ];
            return $this->respond($response, 200);
        }
    }
}
