<?php

namespace App\Controllers;

use App\Models\Schedule;
use App\Models\ScheduleAppointment;
use Config\Services;
use App\Libraries\TokenHelper;
use DateTime;

class ScheduleController extends BaseController
{
    protected $schedules;
    protected $schedulesAppointment;
    protected $session;
    protected $fileUploadService;
    public function __construct()
    {
        $this->schedules = model(Schedule::class); 
        $this->schedulesAppointment = model(ScheduleAppointment::class); 
        $this->session = Services::session();
        $this->fileUploadService = Services::fileUploadService();
    }
    public function index()
    {    
        $data['title'] = "Game Schedules";
        // $data['message'] = "HI!";
        return view('Schedules/schedules', $data);
    }

    public function getAllScheduleToUsers() 
    {
        // $getAllSchedules = $this->schedules->where('is_deleted', false)->findAll();
        $getAllSchedules = $this->schedules
                                ->select('schedules.*, sa.ID as bookingID, sa.schedID, sa.userID as userID, sa.status as bookingStatus, sa.receipt as bookingReceipt')
                                ->join('schedules-appointment sa', 'schedules.ID = sa.schedID AND sa.userID = ' . $this->session->get('ID') . ' ', 'left')
                                // ->where('sa.is_deleted', false)
                                ->where('schedules.is_deleted', false)
                                ->findAll();

        if (!$getAllSchedules) {
            return $this->jsonResponse(false, 'Error fetching schedules to users.');
        }

        return $this->jsonResponse(true, 'Schedules for users fetched.', $getAllSchedules);
    }

    public function bookSchedule()
    {
        $schedID = $this->request->getPost('booking-schedID');
        $userID = $this->session->get('ID');

        error_log('POST DATA: ' . print_r($schedID, true));

        if (empty($schedID)) {
            return $this->jsonResponse(false, 'No schedule provided for booking.');
        }

        $bookingDetails = [
            'userID' => $userID,
            'schedID' => $schedID,
            'status' => 'Pending',
        ];

        $receipt = $this->request->getFile('booking-receipt');

        error_log(print_r($this->schedulesAppointment, true));

        $this->fileUploadService->handleFileUpload($receipt, 'receipts', $userID, $bookingDetails, 'receipt');

        error_log('BOOKING: ' . print_r($bookingDetails, true));

        $insertDetails = $this->schedulesAppointment->insert($bookingDetails);

        if (!$insertDetails) {
            return $this->jsonResponse(false, 'Error inserting booking details.');
        }

        return $this->jsonResponse(true, 'Booked successfully!', $bookingDetails);
        
    }
}