<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use \App\Libraries\Uuid;
use App\Models\RegModel;
use App\Models\TryoutModel;
use App\Models\UserApiModel;
use Exception;
use Pusher\Pusher;

class Apitopup extends ResourceController
{
    protected $format       = 'json';
    protected $modelName    = 'App\Models\TopupModel';
    public function __construct()
    {
        // Set your Merchant Server Key
        // \Midtrans\Config::$serverKey = 'SB-Mid-server-J2ndA6XoeLvqC3BmIiWeXSGo';
        \Midtrans\Config::$serverKey = 'Mid-server-iDdAPVX8XtVjS0-z-Sd2y6t2';
        // Uncomment for production environment
        \Midtrans\Config::$isProduction = true;

        // Uncomment to enable sanitization
        // Config::$isSanitized = true;

        // Uncomment to enable idempotency-key, more details: (http://api-docs.midtrans.com/#idempotent-requests)
        // Config::$paymentIdempotencyKey = "Unique-ID";
        $this->TryoutModel = new TryoutModel();
        $this->UserApiModel = new UserApiModel();
        $this->RegencieModel = new RegModel();
    }
    public function index()
    {
        $idUser = $this->request->auth->idUser;
        $data = $this->model->where('user_id', $idUser)->findAll();
        $response = [
            'status' => 200,
            'data' => $data,
        ];
        return $this->respond($response, 200);
    }
    public function show($id = NULL)
    {
        if ($id) {
            $data = $this->model->find($id);
            $response = [
                'status' => 200,
                'data' => $data,
            ];
            return $this->respond($response, 200);
        }
    }
    public function create()
    {
        $idUser = $this->request->auth->idUser;
        $data = $this->request->getJSON();
        if (isset($data->payment)) {
            $dataUser = $this->UserApiModel->find($idUser);
            $dataRegencie = $this->RegencieModel->find($dataUser['regency_id']);
            $Uuid = new Uuid;
            $save = [
                'id_topup' => $Uuid->v4(),
                'user_id' => $idUser,
                'bank_id' => $data->payment,
                'nominal' => $data->price,
                'status' => 1,
            ];
            $transaction_details = array(
                'order_id'    => $save['id_topup'],
                'gross_amount'  => $save['nominal'],
            );
            // Populate customer's billing address
            $billing_address = array(
                'first_name'   => $dataUser['firstname'],
                'lastname'    => $dataUser['lastname'],
                'adress'      => $dataUser['address'],
                'city'         => (isset($dataRegencie['name']) ? $dataRegencie['name'] : ""),
                'postal_code'  => null,
                'phone'        => $dataUser['telp'],
                'country_code' => 'IDN'
            );

            // Populate customer's info
            $customer_details = array(
                'first_name'   => $dataUser['firstname'],
                'last_name'    => $dataUser['lastname'],
                'email'            => $dataUser['email'],
                'phone'        => $dataUser['telp'],
                'billing_address'  => $billing_address,
            );
            switch ($data->payment) {
                case 'alfamart':
                    $save['bank_id'] = 5;
                    // Transaction data to be sent
                    $transaction_data = array(
                        'payment_type' => 'cstore',
                        'transaction_details' => $transaction_details,
                        'customer_details'    => $customer_details,
                        "cstore" => [
                            "store" => "alfamart"
                        ]
                    );
                    break;
                case 'indomaret':
                    $save['bank_id'] = 6;
                    // Transaction data to be sent
                    $transaction_data = array(
                        'payment_type' => 'cstore',
                        'transaction_details' => $transaction_details,
                        'customer_details'    => $customer_details,
                        "cstore" => [
                            "store" => "indomaret"
                        ]
                    );
                    break;
                    // case 'gopay':
                    //     $save['bank_id'] = 8;
                    //     // Transaction data to be sent
                    //     $transaction_data = array(
                    //         'payment_type' => 'gopay',
                    //         'transaction_details' => $transaction_details,
                    //         'customer_details'    => $customer_details,
                    //     );
                    //     break;
                case 'gopay':
                    $save['bank_id'] = 8;
                    // Transaction data to be sent
                    $transaction_data = array(
                        "payment_type" => "gopay",
                        "transaction_details" => [
                            "order_id" => "order03",
                            "gross_amount" => 275000
                        ],
                        "item_details" => [
                            [
                                "id" => "id1",
                                "price" => 275000,
                                "quantity" => 1,
                                "name" => "Bluedio H+ Turbine Headphone with Bluetooth 4.1 -"
                            ]
                        ],
                        "customer_details" => [
                            "first_name" => "Budi",
                            "last_name" => "Utomo",
                            "email" => "budi.utomo@midtrans.com",
                            "phone" => "081223323423"
                        ],
                        "qris" => [
                            "acquirer" => "gopay"
                        ]
                    );
                    break;
                case 'bca':
                    $save['bank_id'] = 1;
                    // Transaction data to be sent
                    $transaction_data = array(
                        'payment_type' => 'bank_transfer',
                        'transaction_details' => $transaction_details,
                        'customer_details'    => $customer_details,
                        "bank_transfer" => [
                            "bank" => "bca"
                        ]
                    );
                    break;
                case 'mandiri':
                    $save['bank_id'] = 2;
                    // Transaction data to be sent
                    $transaction_data = array(
                        'payment_type' => 'echannel',
                        'transaction_details' => $transaction_details,
                        'customer_details'    => $customer_details,
                    );
                case 'bni':
                    $save['bank_id'] = 3;
                    // Transaction data to be sent
                    $transaction_data = array(
                        'payment_type' => 'bank_transfer',
                        'transaction_details' => $transaction_details,
                        'customer_details'    => $customer_details,
                        "bank_transfer" => [
                            "bank" => "bni"
                        ]
                    );
                    break;
                case 'bri':
                    $save['bank_id'] = 4;
                    // Transaction data to be sent
                    $transaction_data = array(
                        'payment_type' => 'bank_transfer',
                        'transaction_details' => $transaction_details,
                        'customer_details'    => $customer_details,
                        "bank_transfer" => [
                            "bank" => "bri"
                        ]
                    );
                    break;
                case 'permata':
                    $save['bank_id'] = 9;
                    // Transaction data to be sent
                    $transaction_data = array(
                        'payment_type' => 'permata',
                        'transaction_details' => $transaction_details,
                        'customer_details'    => $customer_details,
                    );
                    break;
                default:
                    break;
            }
            try {
                $responseCoreAPi =  \Midtrans\CoreApi::charge($transaction_data);
            } catch (Exception $e) {
                echo $e->getMessage();
                die();
            }
            // Success
            if ($responseCoreAPi->transaction_status == 'pending') {
            } else {
                $response = [
                    'status' => 201,
                    'message' => 'Terjadi kesalahan pada data transaksi yang dikirim.',
                ];
                return $this->respond($response, 201);
            }
            $this->model->insert($save);
            $response = [
                'status' => 200,
                'message' => 'Success Top Up',
                'response' => $responseCoreAPi,
                'data' => [
                    'timeExp' => time() + (60 * 60 * 24),
                    'time' => time()
                ]
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
            $pusher->trigger('my-channel', 'confirmfinance', ['message' => 'success']);
        } else {
            $response = [
                'status' => 201,
                'message' => 'Mohon Pilih Bank',
            ];
        }
        return $this->respond($response, 200);
    }
}
