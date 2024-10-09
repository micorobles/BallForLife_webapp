<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\Config\Services;
use App\Libraries\TokenHelper;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        helper('cookie');
        $tokenHelper = new TokenHelper();

        error_log('AuthFilter before method called.');

        // Bypass OPTIONS preflight requests
        if ($request->getMethod() === 'options') {
            return;
        }

        // $authorizationHeader = $request->header('Authorization');
        $cookieToken = get_cookie('authToken');

        error_log("IN AUTH FILTER, cookieToken: " . $cookieToken, 0);

        if (!$cookieToken) {
            // return Services::response()->setJSON(['success' => false, 'message' => 'Token is missing']);

            // Set flashdata for showing the message after redirect
            session()->setFlashdata('authMessage', 'You are not logged in. Please log in to continue.');
            return redirect()->to('/');
        }

        // $token = str_replace('Bearer ', '', $authorizationHeader->getValue());

        // Validate the token
        if (!$tokenHelper->validateToken($cookieToken)) {
            // return Services::response()->setJSON(['success' => false, 'message' => 'Invalid or expired token']);

            // Set flashdata for showing the message after redirect
            session()->setFlashdata('authMessage', 'Your session has expired. Please log in to continue.');
            return redirect()->to('/');
        }

        // return Services::response()->setJSON(['success' => true, 'message' => 'Token valid.']);
        // Optionally, you can decode the token to retrieve the user ID
        // $payload = $tokenHelper->decodeToken($token);
        // $request->user = $payload['user_id']; // Attach user_id to the request
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Optional: Modify response after controller execution, if needed
    }
}
