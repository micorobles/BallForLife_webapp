<?php

namespace App\Controllers;

use App\Models\User;

class UserMasterController extends BaseController
{
    public function index(): string
    {
        helper('breadcrumb');
        $data['title'] = "User Master";
        // $data['message'] = "HI!";
        return view('Masters/usersMaster', $data);
    }

}
