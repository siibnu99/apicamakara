<?php

namespace App\Controllers;

class Documentation extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'documentation'
        ];
        return view('documentation/index', $data);
    }
}
