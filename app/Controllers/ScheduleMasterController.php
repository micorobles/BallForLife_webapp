<?php

namespace App\Controllers;

use App\Models\Schedule;
use App\Models\ScheduleAppointment;
use App\Libraries\TokenHelper;
use DateTime;

class ScheduleMasterController extends BaseController
{
    protected $schedules;
    protected $schedulesAppointment;
    protected $session;

    public function __construct()
    {
        $this->schedules = model(Schedule::class);  // Inject the User model into the controller
        $this->schedulesAppointment = model(ScheduleAppointment::class);
        $this->session = \Config\Services::session();
    }
    public function index()
    {
        $data['title'] = "Schedule Master";
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

    public function getAllSchedule()
    {

        // $schedules = $this->schedules->where('is_deleted', false)->findAll();
        $schedules = $this->schedules
                        ->select('schedules.*, COUNT(`schedules-appointment`.ID) AS appointments')
                        ->join('`schedules-appointment`', 'schedules.ID = `schedules-appointment`.schedID', 'left')
                        ->where('schedules.is_deleted', false)
                        ->groupBy('schedules.ID')
                        ->findAll();

        // $schedules = $this->schedules
        //     ->select('schedules.*, COUNT(schedules-appointment.ID) AS hasAppointment')
        //     ->join('schedules-appointment', 'schedules.ID = schedules-appointment.schedID', 'left')
        //     ->where('schedules.is_deleted', false)
        //     ->groupBy('schedules.ID')
        //     ->findAll();

        // $schedules = $this->schedules
        //     ->select('schedules.*, COUNT(`schedules-appointment`.ID) AS hasAppointment')
        //     ->join('`schedules-appointment`', 'schedules.ID = `schedules-appointment`.schedID AND `schedules-appointment`.is_deleted=false ', 'left')
        //     ->where('schedules.is_deleted', false)
        //     ->groupBy('schedules.ID')
        //     ->findAll();


        if (!$schedules) {
            return $this->jsonResponse(false, 'Error fetching all schedules', '');
        }


        $formattedSchedules = [];

        foreach ($schedules as $schedule) {

            // $hasAppointment = $this->schedulesAppointment->where('is_deleted', false)
            //                                              ->where('schedID', $schedule['ID']);

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
                'appointmentCount' => $schedule['appointments'],
            ];
            error_log('SCHED: ' . $schedule['title']);
            error_log('HAS APPOINTMENT: ' . $schedule['appointments']);
        }
        return $this->jsonResponse(true, 'Fetched all schedules', $formattedSchedules);
    }

    public function getSingleSchedule($scheduleID)
    {

        $scheduleFound = $this->schedules->find($scheduleID);

        if (!$scheduleFound) {
            return $this->jsonResponse(false, 'Error fetching schedule', $scheduleFound);
        }

        return $this->jsonResponse(true, 'Schedule fetched.', $scheduleFound);
    }

    public function editSchedule($scheduleID)
    {

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

    public function deleteSchedule($scheduleID)
    {

        $deleteSchedule = $this->schedules->update($scheduleID, ['is_deleted' => true]);

        if (!$deleteSchedule) {
            return $this->jsonResponse(false, 'Error deleting schedule', $deleteSchedule);
        }

        return $this->jsonResponse(true, 'Schedule deleted!', $deleteSchedule);
    }

    public function getScheduleAppointments($scheduleID)
    {
        // Get parameters from the request
        $draw = intval($this->request->getPost('draw'));
        $start = intval($this->request->getPost('start'));
        $length = intval($this->request->getPost('length'));
        $order = $this->request->getPost('order') ?? []; // Use empty array if not set
        $columns = ['userID', 'fullname', 'position', 'receipt', 'created_at'];

        error_log('ORDER: ' . print_r($order, true));

        $sortColumnIndex = $order[0]['column'] ?? 4; // Default to first column
        $sortDirection = $order[0]['dir'] ?? 'asc';

        // Validate the sort column index
        $sortColumn = $columns[$sortColumnIndex];

        // Initial query to get total count without pagination or filtering
        $builder = $this->schedulesAppointment
            ->select('u.profilePic, u.firstname, u.lastname, u.position, schedules-appointment.ID AS appointmentID, schedules-appointment.receipt, schedules-appointment.status , schedules-appointment.created_at')
            ->join('user AS u', 'schedules-appointment.userID = u.ID', 'inner')
            ->where('schedules-appointment.is_deleted', false)
            ->where('schedules-appointment.schedID', $scheduleID);

        // Total records count (without filtering and pagination)
        $totalCount = $builder->countAllResults(false);

        // Apply search filtering
        $searchValue = $this->request->getPost('search')['value'] ?? '';
        if ($searchValue) {
            $builder->groupStart();
            $builder->orLike('u.firstname', $searchValue)
                ->orLike('u.lastname', $searchValue)
                ->orLike('u.position', $searchValue)
                ->orLike('schedules-appointment.receipt', $searchValue)
                ->orLike('schedules-appointment.created_at', $searchValue);
            $builder->groupEnd();
        }

        // Get the filtered count (without pagination)
        $filteredCount = $builder->countAllResults(false); // This is the count after applying filters, but without limit/offset

        // Apply ordering
        if ($sortColumn === 'fullname') {
            // Order by concatenated firstname and lastname
            $builder->orderBy('u.firstname', $sortDirection)
                ->orderBy('u.lastname', $sortDirection);
        } else {
            // Order by the actual column
            $builder->orderBy($sortColumn, $sortDirection);
        }

        // Apply pagination
        $builder->limit($length, $start);

        // Get the records (appointments)
        $appointments = $builder->get()->getResultArray();

        // Map data
        $data = array_map(function ($appointment, $index) {
            return [
                'id' => $appointment['appointmentID'],
                'fullname' => '<img src="' . base_url($appointment['profilePic']) . '" alt="Profile Picture" class="imgUser me-1" /> 
                            <span class="regular-text"> ' . ucfirst($appointment['firstname']) . ' ' . ucfirst($appointment['lastname']) . '</span>',
                'position' => $appointment['position'],
                'receipt' => $appointment['receipt'],
                'timestamp' => $appointment['created_at'],
                'status' => $appointment['status'],
                'profilePic' => $appointment['profilePic'],
                'count' => $index + 1,
            ];
        }, $appointments, array_keys($appointments));

        // Return JSON response
        return $this->response->setJSON([
            "draw" => $draw,
            "recordsTotal" => $totalCount,  // Total count of all records
            "recordsFiltered" => $filteredCount,  // Filtered count of records (without pagination)
            "data" => $data
        ]);
    }

    public function appointmentApproval($appointmentID, $isAccept)
    {
        // Convert the string to a boolean value
        $isAccept = filter_var($isAccept, FILTER_VALIDATE_BOOLEAN);

        if (!isset($isAccept)) {
            return $this->jsonResponse(false, 'Null request.');
        }

        $appointment['status'] = $isAccept ? 'Joined' : 'Rejected';

        error_log('ISACCEPT: ' . $isAccept);
        error_log('STATUS: ' . $appointment['status']);

        $appointmentAction = $this->schedulesAppointment->update($appointmentID, $appointment);

        if (!$appointmentAction) {
            return $this->jsonResponse(false, 'Error on appointment approval.');
        }

        return $this->jsonResponse(true, 'Player ' . $appointment['status']);
    }

    // public function getScheduleAppointments($scheduleID)
    // {

    //     // Get parameters from the request
    //     $draw = intval($this->request->getPost('draw'));
    //     $start = intval($this->request->getPost('start'));
    //     $length = intval($this->request->getPost('length'));
    //     $order = $this->request->getPost('order') ?? []; // Use empty array if not set
    //     $columns = [ 'userID', 'fullname', 'position', 'receipt', 'created_at'];

    //     error_log('ORDER: ' . print_r($order, true));

    //     $sortColumnIndex = $order[0]['column'] ?? 4; // Default to first column
    //     $sortDirection = $order[0]['dir'] ?? 'asc';

    //     // Validate the sort column index
    //     $sortColumn = $columns[$sortColumnIndex];

    //     $builder = $this->schedulesAppointment
    //                     ->select('u.profilePic, u.firstname, u.lastname, u.position, schedules-appointment.ID AS appointmentID, schedules-appointment.receipt, schedules-appointment.status , schedules-appointment.created_at')
    //                     ->join('user AS u', 'schedules-appointment.userID = u.ID', 'inner')
    //                     ->where('schedules-appointment.is_deleted', false)
    //                     ->where('schedules-appointment.schedID', $scheduleID);


    //     // Total records count (without filtering)
    //     $totalCount = $builder->countAllResults(false);

    //     error_log('SCHEDULE ID: ' . $scheduleID);
    //     error_log('TOTAL COUNT: ' . $totalCount);


    //     // Apply ordering and pagination
    //     if ($sortColumn === 'fullname') {
    //         // Order by concatenated firstname and lastname 
    //         $builder->orderBy('u.firstname', $sortDirection)
    //                 ->orderBy('u.lastname', $sortDirection);
    //     } else {
    //         // Order by the actual column
    //         $builder->orderBy($sortColumn, $sortDirection);
    //     }

    //     // Apply pagination
    //     $builder->limit($length, $start);

    //     $searchValue = $this->request->getPost('search')['value'] ?? '';

    //     // Apply global search if there is a value
    //     if ($searchValue) {
    //         $builder->groupStart();
    //         $builder->orLike('u.firstname', $searchValue)
    //             ->orLike('u.lastname', $searchValue)
    //             ->orLike('u.position', $searchValue)
    //             ->orLike('schedules-appointment.receipt', $searchValue)
    //             ->orLike('schedules-appointment.created_at', $searchValue);
    //         $builder->groupEnd();
    //     }

    //     // Filtered records
    //     // $appointments = $builder->get()->getResultArray();
    //     // $appointments = $builder->findAll($length, $start);
    //     $appointments = $builder->get()->getResultArray();

    //     // error_log('APPOINTMENTS: ' . print_r($appointments, true));

    //     $filteredCount = $builder->resetQuery()->countAllResults(false);

    //     // Map data
    //     $data = array_map(function ($appointment, $index) {
    //         return [
    //             // 'count' => $index + 1,  
    //             'id' => $appointment['appointmentID'],
    //             'fullname' => '<img src="' . base_url($appointment['profilePic']) . '" alt="Profile Picture" class="imgUser me-1" /> 
    //                             <span class="regular-text"> ' .  ucfirst($appointment['firstname']) . ' ' . ucfirst($appointment['lastname']) . '</span>',
    //             'position' => $appointment['position'],
    //             'receipt' => $appointment['receipt'],
    //             'timestamp' => $appointment['created_at'],
    //             'status' => $appointment['status'],
    //             'profilePic' => $appointment['profilePic'],
    //             'count' => $index + 1,
    //         ];
    //     }, $appointments, array_keys($appointments));

    //     // error_log('DATA: ' . print_r($data, true));
    //     // Return JSON response
    //     return $this->response->setJSON([
    //         "draw" => $draw,
    //         "recordsTotal" => $totalCount,
    //         "recordsFiltered" => $filteredCount,
    //         "data" => $data
    //     ]);
    // }

}
