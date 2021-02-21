<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use \App\Libraries\Uuid;
use \App\Libraries\Tokenjwt;

class Apiprofile extends ResourceController
{
    protected $format       = 'json';
    protected $modelName    = 'App\Models\UserApiModel';

    public function __construct()
    {
        $tokenjwt = new Tokenjwt;
        $data = $tokenjwt->checkToken($this->request->getServer('HTTP_AUTHORIZATION'));
        if (!$data['status'] == 200) {
            return $this->respond($data, 401);
        }
    }
}
