<?php

namespace App\Controllers;

use App\Models\Schedule;
use App\Libraries\TokenHelper;
use DateTime;

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
        
        $schedules = $this->schedules->where('is_deleted', false)->findAll();

        if (!$schedules) {
            return $this->jsonResponse(false, 'Error fetching all schedules', '');
        }

        $formattedSchedules = [];

        foreach ($schedules as $schedule) {

            // $isoStartDate = new DateTime($schedule['startDate']->format('Y-m-d\TH:i:s'));
            $startDate = new DateTime($schedule['startDate']);
            $endDate = new DateTime($schedule['endDate']);

            $formattedSchedules[] = [
                'id' => $schedule['ID'],
                'title' => $schedule['title'],
                'start' => $startDate->format('Y-m-d\TH:i:s'),
                'end' => $endDate->format('Y-m-d\TH:i:s'),
                'color' => $schedule['color'],
                'textColor' => $schedule['textColor'],
                'allDay' => false,
                'display' => 'block',
            ];
        }
        
        return $this->jsonResponse(true, 'Fetched all schedules', $formattedSchedules);
    }

    public function getSingleSchedule($scheduleID) {

        $scheduleFound = $this->schedules->find($scheduleID);

        if (!$scheduleFound) {
            return $this->jsonResponse(false, 'Error fetching schedule', $scheduleFound);
        }

        return $this->jsonResponse(true, 'Schedule fetched.', $scheduleFound);
    }

    public function editSchedule($scheduleID) {

        $postData = $this->request->getPost();
        error_log('POST DATA: ' . print_r($postData, true));
        
        $scheduleChanges = [];

        foreach ($postData as $key => $value) {

            if (strpos($key, 'modal-sched') === 0) {
                $scheduleChanges[lcfirst(str_replace('modal-sched', '', $key))] = $value;
            } else {
                $scheduleChanges[$key] = $value;
            }

        }

        if (empty($scheduleChanges)) {
            return $this->jsonResponse(false, 'No schedule provided for update.');
        }
        
        $editSchedule = $this->schedules->update($scheduleID, $scheduleChanges);

        // error_log('SCHED ID: ' . $scheduleID);
        error_log('SCHED CHANGES: ' . print_r($scheduleChanges, true));
        if (!$editSchedule) {
            return $this->jsonResponse(false, 'Error updating schedule', $editSchedule);
        }

        return $this->jsonResponse(true, 'Schedule updated!', $editSchedule);
    }

    public function deleteSchedule($scheduleID) {

        $deleteSchedule = $this->schedules->update($scheduleID, ['is_deleted' => true]);

        if (!$deleteSchedule) {
            return $this->jsonResponse(false, 'Error deleting schedule', $deleteSchedule);
        }

        return $this->jsonResponse(true, 'Schedule deleted!', $deleteSchedule);
    }
   
}
