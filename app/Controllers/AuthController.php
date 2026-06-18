<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel; 

class AuthController extends BaseController
{
    protected $session;

    public function __construct()
    {
        $this->session = \Config\Services::session();
    }

    public function showRegisterForm()
    {
        if (session()->get('isLoggedIn')) {
            if (session()->get('roleId') == 1) {
                return redirect()->to(base_url('admin/dashboard'));
            } else {
                return redirect()->to(base_url('user/dashboard'));
            }
        }

        return view('auth/register');
    }

    public function showLoginForm()
    {
        if (session()->get('isLoggedIn')) {
            if (session()->get('roleId') == 1) {
                return redirect()->to(base_url('admin/dashboard'));
            } else {
                return redirect()->to(base_url('user/dashboard'));
            }
            }

         return view('auth/login');
    }

    public function login()
    {
        $rules = [
            'email'    => 'required|valid_email',
            'password' => 'required'
        ];

    if (!$this->validate($rules)) {
        return redirect()->back()->withInput()->with('error', $this->validator->listErrors());
    }

    $userModel = new UserModel();
    
    $user = $userModel->where('email', $this->request->getPost('email'))->first();
    if (!$user) {
        return redirect()->back()->withInput()->with('error', 'Invalid login credentials.');   
    }
    if ($user['status'] === 'inactive') {
    return redirect()->back()->withInput()->with('error', 'Your account has been deactivated. Please contact system administration.');
    }
    $db = \Config\Database::connect();
    $roleRow = $db->table('roles')->where('id', $user['role_id'])->get()->getRowArray();
    if ($user) {
        
        if (password_verify($this->request->getPost('password'), $user['password'])) {
            
            $sessionData = [
                'userId'     => $user['id'],
                'firstName'  => $user['first_name'],
                'lastName'   => $user['last_name'],
                'email'      => $user['email'],
                'roleId'     => $user['role_id'],
                'roleName'   => $roleRow ? $roleRow['role_name'] : 'User',
                'isLoggedIn' => true,
            ];
            
            session()->set($sessionData);

           if (session()->get('roleId') == 1) {
                return redirect()->to(base_url('admin/dashboard'))->with('success', 'Welcome Admin!');
            } else {
                return redirect()->to(base_url('user/dashboard'))->with('success', 'Welcome to your dashboard!');
            }
        }
    }
    return redirect()->to(base_url('login'))->withInput()->with('error', 'Invalid Email or Password.');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('login'))->with('success', 'Logged out successfully.');
    }
    public function register()
    {
        $rules = [
            'first_name'      => 'required|alpha_space|min_length[2]|max_length[50]',
            'last_name'       => 'required|alpha_space|min_length[2]|max_length[50]',
            'email'           => 'required|valid_email|is_unique[users.email]',
            'dob'             => 'required|valid_date[Y-m-d]',
            'gender'          => 'required|in_list[male,female,other]',
            'address'         => 'required|string|max_length[255]',
            'password'        => 'required|min_length[6]|max_length[255]',
            'confirm_password'=> 'required|matches[password]',
            'profile_pic'     => 'uploaded[profile_pic]|is_image[profile_pic]|mime_in[profile_pic,image/jpg,image/jpeg,image/png]|max_size[profile_pic,2048]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->to(base_url('register'))->withInput()->with('errors', $this->validator->getErrors());
        }

        $db = \Config\Database::connect();
        $db->transStart();

        try {
            $file = $this->request->getFile('profile_pic');
            $profilePicName = null;

            if ($file && $file->isValid() && !$file->hasMoved()) {
                $profilePicName = $file->getRandomName();
                $file->move(ROOTPATH . 'public/uploads/profile_pics', $profilePicName);
            }

            $userModel = new \App\Models\UserModel();
            $userData = [
                'first_name' => $this->request->getVar('first_name'),
                'last_name'  => $this->request->getVar('last_name'),
                'email'      => $this->request->getVar('email'),
                'password'   => password_hash($this->request->getVar('password'), PASSWORD_BCRYPT),
                'role_id'    => 2,
                'status'     => 'active'
            ];
            
            $userModel->insert($userData);
            $newUserId = $userModel->getInsertID();

            
            $profileData = [
                'user_id'     => $newUserId,
                'dob'         => $this->request->getVar('dob'),
                'gender'      => $this->request->getVar('gender'),
                'address'     => $this->request->getVar('address'),
                'profile_pic' => $profilePicName
            ];

            $db->table('user_profiles')->insert($profileData);

            $db->transComplete();

            if ($db->transStatus() === false) {
                throw new \Exception('Database pipeline execution constraint failed.');
            }

            return redirect()->to(base_url('login'))->with('success', 'Account created successfully! You can now log in.');

        } catch (\Exception $e) {
            $db->transRollback();
            return redirect()->to(base_url('register'))->withInput()->with('error', 'System Error: ' . $e->getMessage());
        }
    }
    public function forgotPassword()
{
    return view('auth/forgot_password');
}

public function processForgot()
{
    $email = $this->request->getPost('email');
    $userModel = new \App\Models\UserModel();
    $user = $userModel->where('email', $email)->first();

    if (!$user) {
        return $this->response->setJSON([
            'success' => false, 
            'message' => 'No account found with that email address.'
        ]);
    }
    if ($user['status'] === 'inactive') 
    {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'This account has been suspended. Password reset is disabled.'
        ]);
    }
    $token = bin2hex(random_bytes(16));
    $userModel->update($user['id'], ['reset_token' => $token]);

    $simulateLink = base_url('reset-password/' . $token);
    
    return $this->response->setJSON([
        'success' => true,
        'message' => "<strong>Success!</strong> Link generated.<br><br> <a href='{$simulateLink}' class='alert-link text-decoration-underline fw-bold'>Click Here to Reset Password</a>"
    ]);
}

public function resetPassword($token)
{
    $userModel = new \App\Models\UserModel();
    $user = $userModel->where('reset_token', $token)->first();

    if (!$user) {
        return redirect()->to(base_url('forgot-password'))->with('error', 'Invalid or expired password reset token.');
    }

    return view('auth/reset_password', ['token' => $token]);
}

public function processReset($token)
{
    $userModel = new \App\Models\UserModel();
    $user = $userModel->where('reset_token', $token)->first();

    if (!$user) {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Invalid or expired password reset token.'
        ]);
    }
    $password = $this->request->getPost('password');
    $confirmPassword = $this->request->getPost('confirm_password');

    if ($password !== $confirmPassword) {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Passwords do not match.'
        ]);
    }
    $userModel->update($user['id'], [
        'password'    => password_hash($password, PASSWORD_BCRYPT),
        'reset_token' => null 
    ]);
    return $this->response->setJSON([
        'success' => true,
        'message' => '<strong>Password Updated Successfully!</strong> Your new credentials are live.'
    ]);
}

}