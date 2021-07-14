<?php

namespace App\Controllers;

use App\Models\ProdiModel;

use Pusher\Pusher;

class Test extends BaseController
{
    public function index()
    {
        d(FCPATH);
        return view('test/index');
    }
    public function test()
    {
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

        $data['message'] = 'hello world';
        $pusher->trigger('my-channel', 'my-event', $data);
    }
}
