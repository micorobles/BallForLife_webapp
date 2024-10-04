<?php

namespace App\Controllers;

use App\Models\User;

class LoginController extends BaseController
{
    public function index(): string
    {
        $data['title'] = "Login";
        // $data['message'] = "HI!";
        return view('Login/login', $data);
    }

    public function login()
    {
        $users = new User();
        $data['title'] = "Login";
        $data['email'] = $this->request->getPost('email');
        $data['password'] = $this->request->getPost('password');
        $data['rememberMe'] = $this->request->getPost('rememberMe');

        if (empty($data['email']) && empty($data['password'])) {
            return $this->jsonResponse(false, 'Cannot accept blank input!', $data);
        }

        try {

            // SELECT FROM DB
            $person = $users->where('is_deleted', false)
                            ->where('email', $data['email'])
                            ->where('password', $data['password'])
                            ->first();
    
            if (!$person) {
                return $this->jsonResponse(false, 'Email or password mismatch');
            }
    
            return $this->jsonResponse(true, 'Successfully logged in!', $person);

        } catch (\Exception $e) {
            // Handle the exception
            return $this->jsonResponse(false, 'An error occurred while processing your request from login controller.', ['error' => $e->getMessage()]);
        }
    }

    
}
