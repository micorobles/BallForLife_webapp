<?php 

namespace App\Models;
use CodeIgniter\Model;


class ScheduleAppointment extends Model 
{
    protected $table = 'schedules-appointment';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'userID',
        'schedID',
        'receipt',
        'status',
        'remarks',
        'is_deleted',
    ];
}