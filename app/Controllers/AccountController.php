<?php

namespace App\Controllers;

use App\Models\User;
use App\Libraries\TokenHelper;

class AccountController extends BaseController
{

    public function index()
    {
        if ($this->isLoggedIn()) {
            return redirect()->to('homepage');
        }

        $data['title'] = "Login";
        // $data['message'] = "HI!";
        return view('Login/login', $data);
    }

    private function isLoggedIn()
    {
        // Check if token is exisiting in cookie
        $token = $this->request->getCookie('authToken');

        $tokenHelper = new TokenHelper();

        return !empty($token) && $tokenHelper->validateToken($token);
    }

    public function login()
    {
        $session = \Config\Services::session();
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
                // ->where('password', $hashedPassword)
                ->first();

            // If no user found or the password doesn't match
            if (!$person) {
                return $this->jsonResponse(false, 'No user found.');
            }
            if (!password_verify($data['password'], $person['password'])) {
                return $this->jsonResponse(false, 'Invalid credentials.');
            }

            error_log('Person data: ' . print_r($person, true));

            // User authenticated, generate token
            $tokenHelper = new TokenHelper();
            $token = $tokenHelper->generateToken($person['ID']); // Pass user ID to generate token

            error_log('Password and person authenticated successfully. token: ' . $token . ', ID: ' . $person['ID']);

            $session->set([
                'firstname' => $person['firstname'],
                'lastname' => $person['lastname'],
                'email' => $person['email'],
            ]);

            // return $this->jsonResponse(true, 'Successfully logged in!', $person);
            return $this->response
                ->setHeader('Authorization', 'Bearer ' . $token)
                ->setJSON([
                    'success' => true,
                    'message' => 'Successfully logged in!',
                    'data' => $person,
                    'token' => $token
                ]);
        } catch (\Exception $e) {
            // Handle the exception
            return $this->jsonResponse(false, 'An error occurred while processing your request from login controller.', ['error' => $e->getMessage()], '');
        }
    }

    public function registration(): string
    {
        $data['title'] = "Registration";
        // $data['message'] = "HI!";
        return view('Registration/registration', $data);
    }

    public function register()
    {
        // Get user input
        $email = $this->request->getPost('email');
        $firstname = $this->request->getPost('firstname');
        $lastname = $this->request->getPost('lastname');
        $contactNum = $this->request->getPost('contactNum');
        $password = $this->request->getPost('password');

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT); // bycrypt by default

        // Save to db

        try {

            $users = new User();

            $userData = [
                'email' => $email,
                'firstname' => $firstname,
                'lastname' => $lastname,
                'contactNum' => $contactNum,
                'password' => $hashedPassword,
            ];

            // CHECK FROM DB TO AVOID DUPLICATION OF EMAIL
            $person = $users->where('is_deleted', false)
                ->where('email', $email)
                ->first();

            if ($person) {
                return $this->jsonResponse(false, 'Email is already used');
            }

            // INSERT IF EMAIL IS NOT YET EXISTED
            $registerUser = $users->insert($userData);

            if (!$registerUser) {
                return $this->jsonResponse(false, 'Error registering new user');
            }

            return $this->jsonResponse(true, 'Successfully registered!', $userData);
        } catch (\Exception $e) {
            return $this->jsonResponse(false, 'An error occurred while processing your request from login controller.', ['error' => $e->getMessage()]);
        }
    }
}
