<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use \App\Libraries\Uuid;
use \App\Libraries\Tokenjwt;
use \App\Models\TopupModel;
use \App\Models\UserApiModel;
use \App\Models\TransferModel;
use Google\Auth\Cache\Item;

class Apiriwayat extends ResourceController
{
    protected $format       = 'json';
    public function index($id = NULL)
    {
        helper("menu");
        $topup = new TopupModel();
        $transfer = new TransferModel();
        $user = new UserApiModel();
        $resultTopup = $topup->select('tbl_topup.* , tbl_user.fullname')->where('user_id', $id)->join('tbl_user', 'tbl_user.id_user = tbl_topup.user_id')->findAll();
        $resultTransferFrom = $transfer->where('from_id', $id)->findAll();
        $resultTransferTo = $transfer->where('to_id', $id)->findAll();
        $resultTransferFromR = [];
        $resultTransferToR = [];
        $resultTopupR = [];
        if ($resultTopup != NULL) {
            $i = 0;
            foreach ($resultTopup as $item) {
                $resultTopupR[] = $item;
                $resultTopupR[$i]['bank'] = AllPayment($item['bank_id']);
                $i++;
            }
        }
        if ($resultTransferFrom != NULL) {
            $i = 0;
            foreach ($resultTransferFrom as $item) {
                $resultTransferFromR[] = $item;
                $resultTransferFromR[$i]['from'] = $user->find($item['from_id'])['fullname'];
                $resultTransferFromR[$i]['to'] = $user->find($item['to_id'])['fullname'];
                $i++;
            }
        }
        if ($resultTransferTo != NULL) {
            $i = 0;
            foreach ($resultTransferTo as $item) {
                $resultTransferToR[] = $item;
                $resultTransferToR[$i]['from'] = $user->find($item['from_id'])['fullname'];
                $resultTransferToR[$i]['to'] = $user->find($item['to_id'])['fullname'];
            }
            $i++;
        }
        $response = [
            'topup' => $resultTopupR,
            'pengirim' => $resultTransferFromR,
            'penerima' => $resultTransferToR,
        ];
        return $this->respond($response, 200);
    }
}
