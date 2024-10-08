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
        $tokenHelper = new TokenHelper();

        error_log('AuthFilter before method called.');
        // error_log(print_r($request, true));

        // Bypass OPTIONS preflight requests
        if ($request->getMethod() === 'options') {
            return;
        }

        $authorizationHeader = $request->header('Authorization');

        error_log("IN AUTH FILTER, AuthorizationHeader: " . $authorizationHeader, 0);

        if (!$authorizationHeader) {
            return Services::response()->setJSON(['success' => false, 'message' => 'Token is missing']);
        }

        $token = str_replace('Bearer ', '', $authorizationHeader->getValue());

        // error_log('Token in AUTH FILTER: ', $token, 0);

        // Validate the token
        if (!$tokenHelper->validateToken($token)) {
            return Services::response()->setJSON(['success' => false, 'message' => 'Invalid or expired token']);
        }


        return Services::response()->setJSON(['success' => true, 'message' => 'Token valid.']);
        // Optionally, you can decode the token to retrieve the user ID
        // $payload = $tokenHelper->decodeToken($token);
        // $request->user = $payload['user_id']; // Attach user_id to the request
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Optional: Modify response after controller execution, if needed
    }
}
