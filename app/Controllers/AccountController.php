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

    public function getUser() {
        $users = new User();
        $userID = session()->get('ID');

        $getUser = $users->find($userID);

        if(!$getUser) {
            return $this->jsonResponse(false, 'Could not find user');
        }

        return $this->jsonResponse(true, 'User found.', $getUser);

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

            // $session->set([
            //     'profilePic' => $person['profilePic'],
            //     'firstname' => $person['firstname'],
            //     'lastname' => $person['lastname'],
            //     'email' => $person['email'],
            // ]);

            $session->set(array_intersect_key($person, array_flip([
                'ID',
                'profilePic',
                'firstname',
                'lastname',
                'position',
                'contactnum',
                'position',
                'heightFeet',
                'heightInch',
                'weight',
                // 'skills',
                'email',
                'status'
            ])));

            // error_log('Session: ', print_r($session));

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
                'profilePic' => '/images/profiles/user.png',
                'email' => $email,
                'firstname' => $firstname,
                'lastname' => $lastname,
                'contactNum' => $contactNum,
                'position' => 'Member',
                'password' => $hashedPassword,
                'status' => 'active',
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
            return $this->jsonResponse(false, 'An error occurred while processing your request from account controller.', ['error' => $e->getMessage()]);
        }
    }

    public function profile()
    {
        $data['title'] = "Profile";
        return view('Profile/profile', $data);
    }

    public function editProfile()
    {

        $session = \Config\Services::session();

        try {

            $users = new User();
            $userID = session()->get('ID');

            // Get user input
            $profileData  = [
                'firstname' => $this->request->getPost('firstname'),
                'lastname' => $this->request->getPost('lastname'),
                'contactNum' => $this->request->getPost('phone'),
                // 'phone' => $this->request->getPost('phone'),
                'position' => $this->request->getPost('position'),
                'heightFeet' => $this->request->getPost('heightFeet'),
                'heightInch' => $this->request->getPost('heightInches'),
                'weight' => $this->request->getPost('weight'),
                'skills' => json_encode($this->request->getPost('skills')), // Convert array to JSON
            ];

            // Update user profile in the database
            $updateUser = $users->update($userID, $profileData);


            if (!$updateUser) {
                return $this->jsonResponse(false, 'Error updating profile!', $profileData);
            }

            // $skills = json_decode($profileData['skills']);

            $session->set(array_intersect_key($profileData, array_flip([
                'firstname',
                'lastname',
                'position',
                'contactNum',
                'position',
                'heightFeet',
                'heightInch',
                'weight',
            ])));

            // Set skills separately
            $session->set('skills', json_decode($profileData['skills']));

            error_log('SESSION DATA: ' . print_r($session->get(), true));

            return $this->jsonResponse(true, 'Profile Updated!', $profileData);
        } catch (\Exception $e) {
            return $this->jsonResponse(false, 'An error occurred while processing your request from account controller.', ['error' => $e->getMessage()]);
        }
    }
}
