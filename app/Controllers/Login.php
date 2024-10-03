<?php

namespace App\Controllers;

use function PHPUnit\Framework\isNull;

class Login extends BaseController
{
    public function index(): string
    {
        $data['title'] = "Login";
        // $data['message'] = "HI!";
        return view('Login/login', $data);
    }

    public function login()
    {
        $data['title'] = "Login";
        $data['username'] = $this->request->getPost('username');
        $data['password'] = $this->request->getPost('password');

        if (!empty($data['username']) && !empty($data['password'])) {
            return $this->jsonResponse(true, 'Success!', $data,
            );
        }
        // return view('test', $data);
    }
}
