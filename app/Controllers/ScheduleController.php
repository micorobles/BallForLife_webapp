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
        return view('Schedules/schedules', $data);
    }

    public function getAllScheduleToUsers() 
    {
        $getAllSchedules = $this->schedules->where('is_deleted', false)->findAll();

        if (!$getAllSchedules) {
            return $this->jsonResponse(false, 'Error fetching schedules to users.');
        }

        return $this->jsonResponse(true, 'Schedules for users fetched.', $getAllSchedules);
    }
}