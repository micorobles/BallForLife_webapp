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
        $userID = $tokenHelper->decodeToken($cookieToken);

        error_log("IN AUTH FILTER, cookieToken: " . $cookieToken, 0);
        error_log("IN AUTH FILTER, userID: " . $userID, 0);

        if (!$cookieToken) {
            // Set flashdata for showing the message after redirect
            session()->setFlashdata('authMessage', 'You are not logged in. Please log in to continue.');
            return redirect()->to('/');
        }

        // Validate the token
        if (!$tokenHelper->validateToken($cookieToken)) {
            // Set flashdata for showing the message after redirect
            session()->setFlashdata('authMessage', 'Your session has expired. Please log in to continue.');
            return redirect()->to('/');
        }

        if (!$userID) {
            session()->setFlashdata('authMessage', 'Your session has expired. Please log in to continue.');
            return redirect()->to('/');
        }

        if ($userID !== session()->get('ID')) {
            // Set flashdata for showing the message after redirect
            session()->setFlashdata('authMessage', 'User ID mismatch. Please log in again');
            return redirect()->to('/');
        } 

    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Optional: Modify response after controller execution, if needed
    }
}
