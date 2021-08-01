<?php

namespace App\Controllers;

use App\Libraries\Uuid;
use CodeIgniter\RESTful\ResourceController;
use Exception;
use Pusher\Pusher;

class Apitryout extends ResourceController
{
    protected $format       = 'json';
    protected $modelName    = 'App\Models\TryoutModel';
    public function __construct()
    {
        $this->MytryoutModel = new \App\Models\MytryoutModel;
        $this->UserApiModel = new \App\Models\UserApiModel;
    }
    public function index()
    {
        try {
            $iduser = $this->request->auth->idUser;
        } catch (Exception $e) {
            $iduser = NULL;
        }
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
                $countPersonBuy = $this->MytryoutModel->where('tryout_id', $temp[$id]['id_tryout'])->countAllResults();
                $temp[$id]['amountBuy'] = $countPersonBuy;
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
                $countPersonBuy = $this->MytryoutModel->where('tryout_id', $id)->countAllResults();
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
    public function create()
    {
        try {
            $iduser = $this->request->auth->idUser;
        } catch (Exception $e) {
            return $this->respond($this->request->jwtErrors, 401);
        }
        $Uuid = new Uuid;
        $json = $this->request->getJSON();
        if ($json != NULL) {
            $dataTryout = $this->model->find($json->idtryout);
        } else {
            $dataTryout = $this->model->find($this->request->getVar('idtryout'));
        }
        if ($dataTryout['payment_method'] == 2) {
            if ($this->MytryoutModel->where(['user_id' => $iduser, 'tryout_id' => $json->idtryout, 'status' => '2'])->first()) {
                $response = [
                    'status' => 201,
                    'message' => 'Tryout Sudah dibeli!',
                ];
                return $this->respond($response, 201);
            }
        } else {
            if ($this->MytryoutModel->where(['user_id' => $iduser, 'tryout_id' => $this->request->getVar('idtryout'), 'status' => '2'])->first()) {
                $response = [
                    'status' => 201,
                    'message' => 'Tryout Sudah dibeli!',
                ];
                return $this->respond($response, 201);
            }
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
                'user_id' => $iduser,
                'tryout_id' => $this->request->getVar('idtryout'),
                'payment_id' => 1,
                'image' => $nameImageTotal,
                'status' => 1,
            ];
            $this->MytryoutModel->insert($data);
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
            $pusher->trigger('my-channel', 'confirm', $data);
            $response = [
                'status' => 200,
                'message' => 'Permintaan Sukses',
            ];
            return $this->respond($response, 200);
        } else if ($dataTryout['payment_method'] == 2) {
            if ($this->UserApiModel->getSaldo($iduser) >= $dataTryout['price']) {
                $data = [
                    'id_mytryout' => $Uuid->v4(),
                    'user_id' => $iduser,
                    'tryout_id' => $json->idtryout,
                    'payment_id' => 2,
                ];
                $this->MytryoutModel->insert($data);
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
                if ($this->UserApiModel->getSaldo($iduser) >= $json->price) {
                    $data = [
                        'id_mytryout' => $Uuid->v4(),
                        'user_id' => $iduser,
                        'tryout_id' => $json->idtryout,
                        'payment_id' => 3,
                        'price' => $json->price,
                    ];
                    $this->MytryoutModel->insert($data);
                    $response = [
                        'status' => 200,
                        'message' => 'Success Buying',
                    ];
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
}
