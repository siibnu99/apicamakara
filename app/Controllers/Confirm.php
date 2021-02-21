<?php

namespace App\Controllers;

class Confirm extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'confirm'
        ];
        return view('confirm/index', $data);
    }
}
