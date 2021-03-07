<?php

namespace App\Controllers;

class Tabledata extends BaseController
{
	public function index()
	{
        $data = [
            'title' => 'tabledata',
            'Tryout' => $this->TryoutModel->findALL(),
        ];
		return view('tabledata/index',$data);
	}
}
