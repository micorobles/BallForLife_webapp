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
        return $this->db->table('schedules-appointment')->where('is_deleted', false)->countAllResults();
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