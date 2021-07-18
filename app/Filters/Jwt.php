<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use App\Libraries\Tokenjwt;

class Jwt implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $tokenjwt = new Tokenjwt;
        $data = $tokenjwt->checkToken($request->getServer('HTTP_AUTHORIZATION'));
        if ($data['status'] == 200) {
            $request->auth = $data['data']->data;
        } else {
            if (!$arguments) {
                echo json_encode($data);
                die();
            }
            $request->jwtErrors = $data;
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}
