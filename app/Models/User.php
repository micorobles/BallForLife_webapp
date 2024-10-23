<?php 

namespace App\Models;
use CodeIgniter\Model;


class User extends Model 
{
    protected $table = 'user';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'coverPhoto',
        'profilePic',
        'firstname',    
        'lastname',
        'contactNum',
        'position',
        'heightFeet',
        'heightInch',
        'weight',
        'skills',
        'email',
        'password',
        'status',
    ];
}