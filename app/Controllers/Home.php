<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        // $data['title'] = "Hello World!";
        // $data['message'] = "HI!";
        return view('test');
    }
}
