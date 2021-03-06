<?php

namespace App\Controllers;

class Confirmfinance extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'confirmfinance'
        ];
        return view('confirmfinance/index', $data);
    }
}
