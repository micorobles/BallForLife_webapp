<?php

namespace App\Controllers;

use App\Models\Schedule;
use App\Libraries\TokenHelper;

class ScheduleMasterController extends BaseController
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
        $data['title'] = "Schedule";
        // $data['message'] = "HI!";
        return view('Masters/scheduleMaster', $data);
    }

    public function createSchedule() 
    {
        $postData = $this->request->getPost(); // Get all POST data
        $schedule = [];

        foreach ($postData as $key => $value) {

            if (strpos($key, 'modal-sched') === 0) {
                $schedule[lcfirst(str_replace('modal-sched', '', $key))] = $value;
            }
        }

        $createSchedule = $this->schedules->insert($schedule);

        if (!$createSchedule) {
            return $this->jsonResponse(false, 'Error creating schedule.', $schedule);
        }
    
        return $this->jsonResponse(true, 'Schedule created!', $schedule);
    }

    public function getAllSchedule() {
        $schedules = $this->schedules->findAll();

        if (!$schedules) {
            return $this->jsonResponse(false, 'Error fetching all schedules', '');
        }

        $formattedSchedules = [];
        foreach ($schedules as $schedule) {
            $formattedSchedules[] = [
                'title' => $schedule['title'],
                'start' => $schedule['startDate'],
                'end' => $schedule['endDate'],
                'description' => $schedule['description'] ?? '',
            ];
        }
        
        return $this->jsonResponse(true, 'Fetched all schedules', $formattedSchedules);
    }
   
}
