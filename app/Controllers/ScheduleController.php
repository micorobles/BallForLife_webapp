<?php

namespace App\Controllers;

use App\Models\Schedule;
use App\Libraries\TokenHelper;
use DateTime;

class ScheduleController extends BaseController
{
    protected $schedules;
    protected $session;
    public function __construct()
    {
        $this->schedules = model(Schedule::class);  // Inject the User model into the controller
        $this->session = \Config\Services::session();
    }
    public function index()
    {    
        $data['title'] = "Game Schedules";
        // $data['message'] = "HI!";
        return view('Schedule/schedules', $data);
    }
}