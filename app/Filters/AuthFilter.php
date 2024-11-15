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

        $cookieToken = get_cookie('authToken');

        error_log("IN AUTH FILTER, cookieToken: " . $cookieToken, 0);

        if (!$cookieToken) {
            // error_log("No authToken in cookie, redirecting to login page.");

            // Set flashdata for showing the message after redirect
            session()->setFlashdata('authMessage', 'You are not logged in. Please log in to continue.');
            return redirect()->to('/');
        }

        // Validate the token
        if (!$tokenHelper->validateToken($cookieToken)) {
            // error_log("Invalid token, redirecting to login page.");

            // Set flashdata for showing the message after redirect
            session()->setFlashdata('authMessage', 'Your session has expired. Please log in to continue.');
            return redirect()->to('/');
        }

        $userID = $tokenHelper->decodeToken($cookieToken);
        // error_log("Decoded userID: " . $userID);
        // error_log("Session userID: " . session()->get('ID'));

        if (!$userID) {
            // error_log("No userID found, redirecting to login page.");

            session()->setFlashdata('authMessage', 'Your session has expired. Please log in to continue.');
            return redirect()->to('/');
        }

        if ($userID !== session()->get('ID')) {
            // error_log("UserID mismatch, redirecting to login page.");

            // Set flashdata for showing the message after redirect
            session()->setFlashdata('authMessage', 'User ID mismatch. Please log in again');
            return redirect()->to('/');
        }
        error_log('Auth check passed, continuing with request.');
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Optional: Modify response after controller execution, if needed
    }
}
