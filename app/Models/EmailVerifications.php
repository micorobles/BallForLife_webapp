<?php 

namespace App\Models;
use CodeIgniter\Model;


class EmailVerifications extends Model 
{
    protected $table = 'email_verifications';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'email',
        'otp',
        'created_at',
    ];
}