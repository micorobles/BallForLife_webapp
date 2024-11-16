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
        error_log("Auth Filter Arguments: " . print_r($arguments, true));
        error_log("Route being accessed: " . current_url());
        // error_log("Auth Filter Arguments: " . print_r($arguments, true));

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

        $decodedToken = $tokenHelper->decodeToken($cookieToken);
        // error_log("Decoded userID: " . $userID);
        // error_log("Session userID: " . session()->get('ID'));

        if (!$decodedToken['id']) {
            // error_log("No userID found, redirecting to login page.");

            session()->setFlashdata('authMessage', 'Your session has expired. Please log in to continue.');
            return redirect()->to('/');
        }

        if ($decodedToken['id'] !== session()->get('ID')) {
            // error_log("UserID mismatch, redirecting to login page.");

            // Set flashdata for showing the message after redirect
            session()->setFlashdata('authMessage', 'User ID mismatch. Please log in again');
            return redirect()->to('/');
        }

        $userRole = $decodedToken['role'] ?? null;
        // error_log("User Role: " . $userRole);
    
        // Check if allowed roles were provided
        if ($arguments) {
            // If roles are passed, check if user's role is allowed
            $allowedRoles = is_array($arguments) ? $arguments : explode(',', $arguments);
    
            // Log the allowed roles to verify
            // error_log("Allowed Roles: " . print_r($allowedRoles, true));
    
            // Check if the user's role is in the allowed roles
            if (!in_array($userRole, $allowedRoles)) {
                error_log("User with role $userRole is not authorized.");
                session()->setFlashdata('authMessage', 'You are not authorized to access this page.');
                return redirect()->to('/unauthorized'); // Redirect to unauthorized page
            }
            session()->set('userRole', $userRole);
        }

        error_log('Auth check passed, continuing with request.');

        return true;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Optional: Modify response after controller execution, if needed
    }
}
