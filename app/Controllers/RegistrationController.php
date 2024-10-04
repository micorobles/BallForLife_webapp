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
        
    }

}
