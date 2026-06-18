<?php

namespace App\Models;

use CodeIgniter\Model;

class UserProfileModel extends Model
{
    protected $table            = 'user_profiles';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';

    protected $allowedFields    = [
        'user_id', 
        'dob', 
        'gender', 
        'address', 
        'profile_pic'
    ];

    
    protected $useTimestamps    = false;
}