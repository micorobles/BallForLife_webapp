<?php

namespace App\Controllers;

use App\Models\User;

class HomepageController extends BaseController
{
    public function index(): string
    {
        helper('breadcrumb');
        $data['title'] = "Homepage";
        // $data['message'] = "HI!";
        return view('Homepage/homepage', $data);
    }

    // public function logout()
    // {
    //     // helper('cookie');
    //     $token = $this->request->getCookie('authToken');
    //     error_log("authToken cookie before deletion: " . $token);
    
    //     if ($token) {
    //         // Attempt to delete the cookie without specifying a domain
    //         delete_cookie('authToken', '', '/', '');
    //         error_log("Attempted to delete authToken cookie");
            
    //         // Check if the cookie has been deleted
    //         $tokenAfterDeletion = $this->request->getCookie('authToken');
    //         error_log("authToken cookie after deletion attempt: " . $tokenAfterDeletion);
    //     } else {
    //         error_log("No authToken found to delete");
    //     }
    
    //     return redirect()->to('/');
    // }
}
