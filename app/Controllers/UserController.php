<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class UserController extends BaseController
{
    public function index()
    {
        
        $userId = session()->get('userId');
        
        $userModel = new \App\Models\UserModel();
        
        
        $user = $userModel->select('users.*, user_profiles.dob, user_profiles.gender, user_profiles.address, user_profiles.profile_pic, roles.role_name')
                          ->join('user_profiles', 'user_profiles.user_id = users.id', 'left')
                          ->join('roles', 'roles.id = users.role_id', 'left')
                          ->where('users.id', $userId)
                          ->first();

        $data['user'] = $user;

        return view('user/dashboard', $data);
    }
}