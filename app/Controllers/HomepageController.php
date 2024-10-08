<?php

namespace App\Controllers;

use App\Models\User;

class HomepageController extends BaseController
{
    public function index(): string
    {
        $data['title'] = "Homepage";
        // $data['message'] = "HI!";
        return view('Homepage/homepage', $data);
    }
}
