<?php

namespace App\Controllers;

class Login extends BaseController
{
    public function index(): string
    {
        $data['title'] = "Login";
        // $data['message'] = "HI!";
        return view('Login/login', $data);
    }
}
