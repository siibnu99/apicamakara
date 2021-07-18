<?php

namespace App\Models;

use CodeIgniter\Model;
use App\models\TopupModel;
use App\models\TransferModel;
use App\models\MytryoutModel;
use App\models\MyquizModel;

class UserApiModel extends Model
{
    protected $table      = 'tbl_user';
    protected $primaryKey = 'id_user';

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id_user', 'image', 'fullname', 'email', 'password', 'firstname', 'lastname', 'school', 'graduate', 'saldo', 'telp', 'province_id', 'regency_id', 'address', 'univ1_id', 'prodi1_id', 'univ2_id', 'prodi2_id', 'is_active', 'created_at', 'updated_at'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getSaldo($idUser = NULL)
    {
        $data =  $this->find($idUser);
        $TopupModel = new TopupModel();
        $TransferModel = new TransferModel();
        $MytryoutModel = new MytryoutModel();
        $MyquizModel = new MyquizModel();
        $topup = $TopupModel->selectSum('nominal', 'totalNominal')->where(['user_id' => $idUser, 'status' => '2'])->first()['totalNominal'];
        $transferFrom = $TransferModel->selectSum('nominal', 'totalNominal')->where('from_id', $idUser)->first()['totalNominal'];
        $transferTo = $TransferModel->selectSum('nominal', 'totalNominal')->where('to_id', $idUser)->first()['totalNominal'];
        $dataMyTryout = $MytryoutModel->selectSum('tbl_tryout.price', 'totalNominal')->where(['user_id' => $idUser, 'tbl_tryout.payment_method' => '2', 'payment_id' => '2'])->join('tbl_tryout', 'tbl_tryout.id_tryout = tbl_mytryout.tryout_id')->first()['totalNominal'];
        $dataMyTryout3 = $MytryoutModel->selectSum('tbl_mytryout.price', 'totalNominal')->where(['user_id' => $idUser, 'tbl_tryout.payment_method' => '3', 'payment_id' => '3'])->join('tbl_tryout', 'tbl_tryout.id_tryout = tbl_mytryout.tryout_id')->first()['totalNominal'];
        $dataMyquiz = $MyquizModel->selectSum('price', 'totalNominal')->where('user_id', $idUser)->first()['totalNominal'];
        return $topup + $transferTo - $transferFrom - $dataMyTryout - $dataMyTryout3 - $dataMyquiz;
    }
}
