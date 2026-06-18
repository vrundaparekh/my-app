<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    
   
    protected $useSoftDeletes   = true;

    
    protected $allowedFields    = [
        'first_name', 
        'last_name', 
        'email', 
        'password', 
        'role_id', 
        'status',
        'reset_token',
        'deleted_at',
        'address',
        'gender'
    ];

    
    protected $useTimestamps    = true;
    protected $dateFormat       = 'datetime';
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';
    protected $deletedField     = 'deleted_at';

    
    protected $validationRules      = [
        'email'      => 'required|valid_email|is_unique[users.email,id,{id}]',
        'first_name' => 'required|alpha_space|min_length[2]',
        'last_name'  => 'required|alpha_space|min_length[2]',
        'password'   => 'required|min_length[6]',
        'role_id'    => 'required|is_not_unique[roles.id]',
    ];
    
    protected $validationMessages   = [];
    protected $skipValidation       = false;
}