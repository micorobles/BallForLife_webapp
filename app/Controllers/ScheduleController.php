<?php

namespace App\Controllers;

use App\Models\User;
use App\Libraries\TokenHelper;

class ScheduleController extends BaseController
{
    public function index()
    {    
        $data['title'] = "Schedule";
        // $data['message'] = "HI!";
        return view('Schedule/schedule', $data);
    }


   
}
