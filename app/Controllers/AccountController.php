<?php

namespace App\Controllers;

use App\Models\User;
use App\Models\EmailVerifications;
use App\Libraries\TokenHelper;
use Config\Services;
use Google_Client;
use Google_Service_Oauth2;
use CodeIgniter\Controller;

// use CodeIgniter\Files\File;

class AccountController extends BaseController
{

    protected $users;
    protected $emailVerification;
    protected $session;
    protected $tokenHelper;
    protected $fileUploadService;
    protected $emailService;

    public function __construct()
    {
        $this->users = model(User::class);  // Inject the User model into the controller
        $this->emailVerification = model(EmailVerifications::class);  // Inject the User model into the controller
        $this->session = Services::session();
        $this->tokenHelper = new TokenHelper();
        $this->fileUploadService = Services::fileUploadService();
        $this->emailService = Services::EmailService();
    }

    public function index()
    {
        if ($this->isLoggedIn()) {
            return redirect()->to(base_url('dashboard'));
        }

        $data['title'] = "Login";
        // $data['message'] = "HI!";
        return view('Login/login', $data);
    }

    public function getUser($userID)
    {

        $getUser = $this->users->find($userID);

        if (!$getUser) {
            return $this->jsonResponse(false, 'Could not find user');
        }

        return $this->jsonResponse(true, 'User found.', $getUser);
    }
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////// LOGIN FUNCTIONS /////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function login()
    {
        $data['title'] = "Login";
        $data['email'] = $this->request->getPost('email');
        $data['password'] = $this->request->getPost('password');
        // $data['rememberMe'] = $this->request->getPost('rememberMe');

        if (empty($data['email']) && empty($data['password'])) {
            return $this->jsonResponse(false, 'Cannot accept blank input!', $data);
        }

        try {

            $authResult = $this->authenticateUser($data['email'], $data['password']);

            if (!$authResult['success']) {
                return $this->jsonResponse(false, $authResult['message']);
            }

            $person = $authResult['person'];
            $token = $this->generateAuthToken($person['ID'], $person['role']);
            $this->setSessionData($person);

            // $this->emailService->sendEmail('micholrobles27@gmail.com', 
            //                            'Ball For Life Google Sign in.', 
            //                            'Thank you for joining Ball For Life!', 
            //                            'Mico Robles'
            //                         );

            return $this->jsonResponse(true, 'Successfully logged in!',  $token);
        } catch (\Exception $e) {
            // Handle the exception
            return $this->jsonResponse(false, 'An error occurred while processing your request from login controller.', ['error' => $e->getMessage()], '');
        }
    }
    public function google()
    {
        // Get the ID token from the POST request
        $id_token = $this->request->getPost('id_token');

        if (!$id_token) {
            return $this->jsonResponse(false, 'ID token is required', '');
        }

        try {
            // $payload = $client->verifyIdToken($id_token);
            $payload = $this->verifyGoogleToken($id_token);

            if (!$payload) {
                error_log('Invalid ID token: ' . $id_token);
                return $this->jsonResponse(false, 'Invalid ID token', '');
            }

            // Extract user details from the payload
            $googleID = $payload['sub'];
            $userEmail = $payload['email'];
            $firstname = $payload['given_name'] ?? '';
            $lastname = $payload['family_name'] ?? '';
            // $profilePic = $payload['picture'];

            // Prepare user data to insert or update
            $userData = [
                'role' => 'User',
                'email' => $userEmail,
                'profilePic' => 'images/uploads/user.png',
                'coverPhoto' => 'images/uploads/cover-photo.jpg',
                'firstname' => $firstname,
                'lastname' => $lastname,
                'position' => 'Member',
                'status' => 'Pending',
            ];

            $authResult = $this->authenticateUser($userEmail);

            $person = $authResult['success'] ? $authResult['person'] : $this->registerGoogleUser($userData);

            // error_log('Person ID: ' . $person['ID']);
            // error_log('Person ROLE: ' . $person['role']);

            $token = $this->generateAuthToken($person['ID'], $person['role']);

            $this->setSessionData($person);

            return $this->jsonResponse(true, 'Successfully signed in!', $token);
        } catch (\Google_Service_Exception $e) {
            // Log specific Google service error
            error_log('Google service error: ' . $e->getMessage());
            return $this->jsonResponse(false, 'Google service error: ' . $e->getMessage(), '');
        } catch (\Exception $e) {
            // Catch general exceptions and log the error
            error_log('Error verifying Google ID token: ' . $e->getMessage());
            return $this->jsonResponse(false, 'Error verifying token', '');
        }
    }

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////// REGISTER FUNCTIONS ////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function registration(): string
    {
        $data['title'] = "Registration";
        // $data['message'] = "HI!";
        return view('Registration/registration', $data);
    }

    public function sendOTP($email)
    {
        $otp = $this->generateOTP();

        $insertEmailVerification = $this->emailVerification->insert([
            'email' => $email,
            'otp' => $otp
        ]);

        $this->emailService->sendEmail(
            $email,
            'Ball For Life - Email Verification.',
            "Your OTP for registration is: <b>{$otp}</b>. It will expire in 10 minutes.",
            '',
            '',
            '',
            '#',
        );

        return $insertEmailVerification;
    }

    public function verifyOTP()
    {
        $email = $this->request->getPost('modal-email');
        $otp = $this->request->getPost('modal-otp');

        $verifyOTP = $this->emailVerification
            ->where('email', $email)
            ->where('otp', $otp)
            ->where('created_at >', date('Y-m-d H:i:s', strtotime('-10 minutes')))
            ->first();


        if (!$verifyOTP) {
            return $this->jsonResponse(false, 'Invalid or expired OTP.');
        }

        return $this->register();
    }

    public function verifyEmail()
    {

        // Get user input
        $email = $this->request->getPost('email');


        $firstname = ucfirst($this->request->getPost('firstname'));
        $lastname = ucfirst($this->request->getPost('lastname'));
        $contactNum = $this->request->getPost('contactNum');
        $password = $this->request->getPost('password');

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT); // bycrypt by default

        // CHECK FROM DB TO AVOID DUPLICATION OF EMAIL
        $person = $this->users->where('is_deleted', false)
            ->where('email', $email)
            ->first();

        if ($person) {
            return $this->jsonResponse(false, 'Email is already used');
        }

        $sendOTP = $this->sendOTP($email);

        $this->session->set('temp_user', [
            'role' => 'User',
            'profilePic' => 'images/uploads/user.png',
            'coverPhoto' => 'images/uploads/cover-photo.jpg',
            'email' => $email,
            'firstname' => $firstname,
            'lastname' => $lastname,
            'contactNum' => $contactNum,
            'position' => 'Member',
            'password' => $hashedPassword,
            'status' => 'Pending',
        ]);

        if (!$sendOTP) {
            return $this->jsonResponse(false, 'Error sending OTP.');
        }

        return $this->jsonResponse(true, 'OTP sent to your email. Please verify.', $email);
    }
    public function register()
    {

        try {

            $userData = $this->session->get('temp_user');

            // INSERT IF EMAIL IS NOT YET EXISTED
            $registerUser = $this->users->insert($userData);

            if (!$registerUser) {
                return $this->jsonResponse(false, 'Error registering new user');
            }

            $this->emailService->sendEmail(
                $userData['email'],
                'Ball For Life Register.',
                "Thank you for joining Ball For Life! Please wait for the admin's approval before you can view the available games.",
                '',
                $userData['firstname'] . ' ' . $userData['lastname'],
                'Dashboard',
                'dashboard',
            );

            $this->emailService->notifyAdmin(
                'Pending user.',
                $userData['firstname'] . ' ' . $userData['lastname'] . ' has joined Ball For Life! Please accept or delete this user.',
                '',
                'User Master',
                'userMaster',
            );
            // $this->emailService->notifyAdmin();

            return $this->jsonResponse(true, 'Successfully registered! Please sign in your account.', $userData);
        } catch (\Exception $e) {
            return $this->jsonResponse(false, 'An error occurred while processing your request from account controller.', ['error' => $e->getMessage()]);
        }
    }

    private function registerGoogleUser($userData)
    {
        // Generate password if its google sign in
        $defaultPassword = $this->generateRandomPass();
        $defaultPasswordHashed = password_hash($defaultPassword, PASSWORD_DEFAULT);

        $userData['password'] = $defaultPasswordHashed;

        $registerUser = $this->users->insert($userData);

        if (!$registerUser) {
            throw new \Exception('Error registering your account.');
        }

        $this->emailService->sendEmail(
            $userData['email'],
            'Ball For Life Google Sign in.',
            "Thank you for joining Ball For Life! Please wait for the admin's approval before you can view the available games.",
            '<p><i>
                            In case <b>Google Sign-In</b> is unavailable, <b>Ball For Life</b> has provided a default password for your account. 
                            Simply sign in with your email and the provided password. It is recommended to change your password on your profile page after signing in.
                        </i></p>
                        <ul>
                            <li><b>Default password: </b>' . $defaultPassword . ' </li>
                        </ul>',
            $userData['firstname'] . ' ' . $userData['lastname'],
            'Dashboard',
            'dashboard',
        );

        $this->emailService->notifyAdmin(
            'Pending user.',
            $userData['firstname'] . ' ' . $userData['lastname'] . ' has joined Ball For Life! Please accept or delete this user.',
            '',
            'User Master',
            'userMaster',
        );

        // Return the newly created user
        return $this->users->where('is_deleted', false)
            ->where('email', $userData['email'])
            ->first();
    }

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////// PROFILE FUNCTIONS ////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function profile($userId)
    {
        $data['title'] = "Profile";
        return view('Profile/profile', $data);
    }

    public function editProfile()
    {

        try {

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

            // $profileData['skills'] = json_encode($this->request->getPost('skills')); // Convert array to JSON

            // Handle file uploads
            $this->fileUploadService->handleFileUpload($this->request->getFile('pictureFile'), 'profiles', $userID, $profileData, 'profilePic');
            $this->fileUploadService->handleFileUpload($this->request->getFile('coverPhotoFile'), 'cover-photos', $userID, $profileData, 'coverPhoto');

            // Update user profile in the database
            $updateUser = $this->users->update($userID, $profileData);


            if (!$updateUser) {
                return $this->jsonResponse(false, 'Error updating profile!', $profileData);
            }

            // $skills = json_decode($profileData['skills']);

            $this->session->set(array_intersect_key($profileData, array_flip([
                'profilePic',
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
            $this->session->set('skills', json_decode($profileData['skills']));

            // error_log('SESSION DATA: ' . print_r($session->get(), true));

            return $this->jsonResponse(true, 'Profile Updated!', $profileData);
        } catch (\Exception $e) {
            return $this->jsonResponse(false, 'An error occurred while processing your request from account controller.', ['error' => $e->getMessage()]);
        }
    }

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////// COMMON FUNCTIONS ////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    private function verifyGoogleToken($id_token)
    {
        $client = new Google_Client([
            'client_id' => '242089388933-osq14fn5jc01gpu49d13a90546ghs5g7.apps.googleusercontent.com' // Replace with your Google Client ID
        ]);

        return $client->verifyIdToken($id_token);
    }

    private function isLoggedIn()
    {
        // Check if token is exisiting in cookie
        $token = $this->request->getCookie('authToken');

        return !empty($token) && $this->tokenHelper->validateToken($token);
    }
    private function authenticateUser($email, $password = null)
    {
        $person = $this->users->where('is_deleted', false)
            ->where('email', $email)
            ->first();

        if (!$person) {
            return ['success' => false, 'message' => 'No user found.'];
        }

        if ($password && !password_verify($password, $person['password'])) {
            return ['success' => false, 'message' => 'Invalid credentials.'];
        }

        return ['success' => true, 'person' => $person];
    }
    private function setSessionData($user)
    {
        $this->session->set(array_intersect_key($user, array_flip([
            'ID',
            'profilePic',
            'coverPhoto',
            'firstname',
            'lastname',
            'position',
            'contactnum',
            'email',
            'status',
        ])));

        // error_log('SESSIONS: ' . print_r(session()->get(), true));
    }
    private function generateAuthToken($userId, $userRole)
    {
        return $this->tokenHelper->generateToken($userId, $userRole);
    }

    public function unauthorized()
    {
        return view('errors/html/unauthorized');
    }

    private function generateRandomPass($length = 12)
    {
        // Define character pools
        $lowercase = 'abcdefghijklmnopqrstuvwxyz';
        $uppercase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $numbers = '0123456789';
        $specialChars = '!@#$%^&*()-_=+[]{}<>?';

        // Combine all characters
        $allChars = $lowercase . $uppercase . $numbers . $specialChars;

        // Ensure the password contains at least one of each character type
        $password = $lowercase[random_int(0, strlen($lowercase) - 1)] .
            $uppercase[random_int(0, strlen($uppercase) - 1)] .
            $numbers[random_int(0, strlen($numbers) - 1)] .
            $specialChars[random_int(0, strlen($specialChars) - 1)];

        // Fill the remaining length with random characters from the entire pool
        for ($i = strlen($password); $i < $length; $i++) {
            $password .= $allChars[random_int(0, strlen($allChars) - 1)];
        }

        // Shuffle the password to make it random
        return str_shuffle($password);
    }

    private function generateOTP($length = 6)
    {
        return random_int(100000, 999999); // Generates a 6-digit number
    }
}
