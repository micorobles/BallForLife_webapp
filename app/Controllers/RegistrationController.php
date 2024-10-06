<?php

namespace App\Controllers;

use App\Models\User;

class RegistrationController extends BaseController
{
    public function index(): string
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
                            ->where('email',$email)
                            ->first();

            if($person) {
                return $this->jsonResponse(false, 'Email is already used');
            }

            // INSERT IF EMAIL IS NOT YET EXISTED
            $registerUser = $users->insert($userData);

            if(!$registerUser) {
                return $this->jsonResponse(false, 'Error registering new user');
            }

            return $this->jsonResponse(true, 'Successfully registered!', $userData);

        } catch (\Exception $e) {
            return $this->jsonResponse(false, 'An error occurred while processing your request from login controller.', ['error' => $e->getMessage()]);
        }
    }
}
