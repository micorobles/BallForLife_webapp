<?php 

namespace App\Models;
use CodeIgniter\Model;


class Dashboard extends Model 
{

    // ADMIN

    public function getTotalUsers() 
    {
        return $this->db->table('user')->where('is_deleted', false)->countAllResults();
    }
    public function getPendingUsers() 
    {
        return $this->db->table('user')->where('status', 'Pending')->countAllResults();
    }
    public function getTotalSchedules()
    {
        return $this->db->table('schedules')->where('is_deleted', false)->countAllResults();
    }
    public function getUpcomingSchedules()
    {
        return $this->db->table('schedules')->where('is_deleted', false)
                                                       ->where('startDate >', date('Y-m-d H:i:s'))
                                                       ->countAllResults();
    }
    public function getAppointmentRequests()
    {
        // return $this->db->table('schedules-appointment')->where('is_deleted', false)
        //                                                            ->where('status', 'Pending') 
        //                                                            ->countAllResults();

        //     return $this->db->table('schedules-appointment')->select('COUNT(*) AS requests_count')
        //                                                                ->join('schedules', 'schedID = schedules.ID', 'left') 
        //                                                                ->where('schedules.startDate >', date('Y-m-d H:i:s'))
        //                                                                ->where('schedules-appointment.is_deleted', false)
        //                                                                ->where('status', 'Pending') 
        //                                                                ->groupBy('schedules.startDate') // Ensure grouping to make COUNT work correctly
        //                                                                ->countAllResults();
        // }
        $query = $this->db->table('schedules-appointment')
                  ->join('schedules', 'schedID = schedules.ID', 'left')
                  ->where('schedules.startDate >', date('Y-m-d H:i:s'))
                  ->where('schedules-appointment.is_deleted', false)
                  ->where('status', 'Pending')
                  ->groupBy('schedules.startDate')
                  ->get();

        return count($query->getResultArray());
    }
    // USERS
    
    public function getAppointmentPending()
    {
        return $this->db->table('schedules-appointment')->where('is_deleted', false)
                                                        ->where('userID', session()->get('ID'))
                                                        ->where('status', 'Pending')
                                                        ->countAllResults();
    }
    public function getAppointmentJoined()
    {
        return $this->db->table('schedules-appointment')->where('is_deleted', false)
                                                        ->where('userID', session()->get('ID'))
                                                        ->where('status', 'Joined')
                                                        ->countAllResults();
    }
}