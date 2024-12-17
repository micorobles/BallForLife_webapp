<?php 

namespace App\Models;
use CodeIgniter\Model;


class Schedule extends Model 
{
    protected $table = 'schedules';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'title',
        'description',
        'venue',
        'startDate',
        'endDate',
        'color',
        'textColor',
        'maxPlayer',
        'gameFee',
        'notes',
        'is_deleted',
    ];
}