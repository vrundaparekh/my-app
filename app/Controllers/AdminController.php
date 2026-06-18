<?php

namespace App\Controllers;

use App\Models\UserModel;

class AdminController extends BaseController
{
    public function index()
    {
        $userModel = new \App\Models\UserModel();

        $search = $this->request->getVar('search');
        $gender_filter = $this->request->getVar('gender_filter');
        
        $userModel->select('users.*, user_profiles.dob, user_profiles.gender, user_profiles.profile_pic, roles.role_name')
                ->join('user_profiles', 'user_profiles.user_id = users.id', 'left')
                ->join('roles', 'roles.id = users.role_id', 'left');

        if (!empty($search)) {
            $userModel->groupStart()
                    ->like('users.first_name', $search)
                    ->orLike('users.last_name', $search)
                    ->orLike('users.email', $search)
                    ->groupEnd();
        }

        if (!empty($gender_filter)) {
            $userModel->where('user_profiles.gender', $gender_filter);
        }

        $data = [
            'users'         => $userModel->paginate(5),
            'pager'         => $userModel->pager,
            'search'        => $search,
            'gender_filter' => $gender_filter
        ];

        return view('admin/dashboard', $data);
    }
    public function search()
    {
        $keyword = $this->request->getPost('keyword');
        $gender  = $this->request->getPost('gender_filter');

        $userModel = new \App\Models\UserModel();
        $query = $userModel->select('users.*, user_profiles.dob, user_profiles.gender, user_profiles.profile_pic, roles.role_name')
                        ->join('user_profiles', 'user_profiles.user_id = users.id', 'left')
                        ->join('roles', 'roles.id = users.role_id', 'left');

        if (!empty($keyword)) {
            $query->groupStart()
                ->like('users.first_name', $keyword)
                ->orLike('users.last_name', $keyword)
                ->orLike('users.email', $keyword)
                ->groupEnd();
        }

        if (!empty($gender)) {
            $query->where('user_profiles.gender', $gender);
        }

        $data['users'] = $query->findAll();
        return view('admin/user_table_rows', $data);
    }
   public function store()
    {
        $userModel = new \App\Models\UserModel();

        $validation = \Config\Services::validation();
        $validation->setRules([
            'first_name' => 'required|alpha_space|min_length[2]',
            'last_name'  => 'required|alpha_space|min_length[2]',
            'email'      => 'required|valid_email|is_unique[users.email]',
            'dob'        => 'required|valid_date[Y-m-d]',
            'gender'     => 'required|in_list[male,female,other]',
            'password'   => 'required|min_length[6]',
            'role_id'    => 'required|integer',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return $this->response->setJSON([
                'success' => false, 
                'message' => implode(' ', $validation->getErrors())
            ]);
        }

        $db = \Config\Database::connect();
        $db->transStart();

        $userId = $userModel->insert([
            'first_name' => $this->request->getPost('first_name'),
            'last_name'  => $this->request->getPost('last_name'),
            'email'      => $this->request->getPost('email'),
            'password'   => password_hash($this->request->getPost('password'), PASSWORD_BCRYPT),
            'role_id'    => $this->request->getPost('role_id'), 
            'status'     => 'active'
        ]);

        $profilePicName = null;
        $file = $this->request->getFile('profile_pic');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $profilePicName = $file->getRandomName();
            $file->move(FCPATH . 'uploads/profile_pics', $profilePicName);
        }
        $db->table('user_profiles')->insert([
            'user_id'     => $userId,
            'dob'         => $this->request->getPost('dob'),
            'gender'      => $this->request->getPost('gender'),
            'address'     => '', 
            'profile_pic' => $profilePicName
        ]);

        $db->transComplete();

        if ($db->transStatus() === false) {
            return $this->response->setJSON([
                'success' => false, 
                'message' => 'Database operation transaction error.'
            ]);
        }

        return $this->response->setJSON([
            'success' => true, 
            'message' => 'New user account registered successfully!'
        ]);
    }
    public function view($id = null)
    {
        $userModel = new \App\Models\UserModel();
        $user = $userModel->select('users.*, user_profiles.dob, user_profiles.gender, user_profiles.address, user_profiles.profile_pic, roles.role_name')
                        ->join('user_profiles', 'user_profiles.user_id = users.id', 'left')
                        ->join('roles', 'roles.id = users.role_id', 'left')
                        ->where('users.id', $id)
                        ->first();

        if (!$user) {
            return '<div class="alert alert-danger mb-0">System entity data entry missing.</div>';
        }

        $data['user'] = $user;
        return view('admin/user_view_modal', $data);
    }
    public function edit($id = null)
    {
        $userModel = new \App\Models\UserModel();

        $user = $userModel->select('users.*, user_profiles.dob, user_profiles.gender, user_profiles.address, user_profiles.profile_pic')
                        ->join('user_profiles', 'user_profiles.user_id = users.id', 'left')
                        ->where('users.id', $id)
                        ->first();

        if (!$user) {
            return '<div class="alert alert-danger mb-0">User record not found.</div>';
        }
        $data['user'] = $user;
        return view('admin/user_edit_modal', $data); 
    }
    public function update($user_id = null)
{

    if ($user_id === null) {
        $user_id = $this->request->getPost('user_id');
    }

    $userModel = new \App\Models\UserModel();
    $user = $userModel->find($user_id);

    if (!$user) {
        return $this->response->setJSON(['success' => false, 'message' => 'User not found. ID checked: ' . var_export($user_id, true)]);
    }
    
    $validation = \Config\Services::validation();
    $validation->setRules([
        'first_name' => 'required|alpha_space|min_length[2]',
        'last_name'  => 'required|alpha_space|min_length[2]',
        'email'      => "required|valid_email|is_unique[users.email,id,{$user_id}]",
        'role_id'    => 'required|integer',
    ]);

    if (!$validation->withRequest($this->request)->run()) {
        return $this->response->setJSON(['success' => false, 'message' => implode(' ', $validation->getErrors())]);
    }

    $db = \Config\Database::connect();
    $db->transStart();

        $db->table('users')->where('id', $user_id)->update([
        'first_name' => $this->request->getPost('first_name'),
        'last_name'  => $this->request->getPost('last_name'),
        'email'      => $this->request->getPost('email'),
        'role_id'    => $this->request->getPost('role_id'),
    ]);

    $profileData = [
        'dob'     => $this->request->getPost('dob') ?: null,
        'gender'  => $this->request->getPost('gender') ?: null,
        'address' => $this->request->getPost('address'),
    ];

    $file = $this->request->getFile('profile_pic');
    if ($file && $file->isValid() && !$file->hasMoved()) {
        $newName = $file->getRandomName();
        $file->move(FCPATH . 'uploads/profile_pics', $newName);
        $profileData['profile_pic'] = $newName;
    }

    $db->table('user_profiles')->where('user_id', $user_id)->update($profileData);

    $db->transComplete();

    if ($db->transStatus() === false) {
        return $this->response->setJSON(['success' => false, 'message' => 'Database update error.']);
    }

    return $this->response->setJSON(['success' => true, 'message' => 'User account configuration modified successfully!']);
}
    public function delete($id = null)
    {
        $userModel = new \App\Models\UserModel();

        $user = $userModel->find($id);
        if (!$user) {
            return $this->response->setJSON(['success' => false, 'message' => 'User record not found.']);
        }
        if ($id == session()->get('userId')) {
            return $this->response->setJSON(['success' => false, 'message' => 'Security Constraint: You cannot delete your own authenticated session account.']);
        }

        $updated = $userModel->update($id, ['status' => 'inactive','deleted_at' => date('Y-m-d H:i:s')]);

        if ($updated) {
            return $this->response->setJSON(['success' => true, 'message' => 'User account deleted successfully!']);
        }

        return $this->response->setJSON(['success' => false, 'message' => 'Failed to update user status record.']);
    }
    public function exportExcel()
    {
        $userModel = new \App\Models\UserModel();
        $users = $userModel->select('users.id, users.first_name, users.last_name, users.email, users.status, user_profiles.dob, user_profiles.gender, roles.role_name')
                        ->join('user_profiles', 'user_profiles.user_id = users.id', 'left')
                        ->join('roles', 'roles.id = users.role_id', 'left')
                        ->findAll();

        $filename = "user_data_" . date('Ymd_His') . ".xlsx";

        header("Content-Type: application/vnd.ms-excel; charset=utf-8");
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Pragma: public");
        echo '<table border="1">';
        echo '<tr style="background-color: #212529; color: #ffffff; font-weight: bold;">';
        echo '<th>ID</th><th>Full Name</th><th>Email Address</th><th>DOB</th><th>Gender</th><th>System Role</th><th>Account Status</th>';
        echo '</tr>';

        foreach ($users as $user) {
            echo '<tr>';
            echo '<td>' . $user['id'] . '</td>';
            echo '<td>' . esc($user['first_name'] . ' ' . $user['last_name']) . '</td>';
            echo '<td>' . esc($user['email']) . '</td>';
            echo '<td>' . esc($user['dob'] ?: 'N/A') . '</td>';
            echo '<td>' . ucfirst(esc($user['gender'] ?: 'N/A')) . '</td>';
            echo '<td>' . esc($user['role_name'] ?? 'User') . '</td>';
            echo '<td>' . ucfirst(esc($user['status'])) . '</td>';
            echo '</tr>';
        }
        echo '</table>';
        exit;
    }

    public function exportPdf()
    {
        $userModel = new \App\Models\UserModel();
        $users = $userModel->select('users.id, users.first_name, users.last_name, users.email, users.status, user_profiles.dob, user_profiles.gender, roles.role_name')
                        ->join('user_profiles', 'user_profiles.user_id = users.id', 'left')
                        ->join('roles', 'roles.id = users.role_id', 'left')
                        ->findAll();

        $html = '
        <h2 style="text-align: center; font-family: sans-serif; color: #333;">Users</h2>
        <p style="text-align: center; font-family: sans-serif; font-size: 12px; color: #666;">Generated on: ' . date('Y-m-d H:i:s') . '</p>
        <table width="100%" border="1" cellpadding="8" cellspacing="0" style="font-family: sans-serif; font-size: 13px; border-collapse: collapse; border: 1px solid #ddd;">
            <thead>
                <tr style="background-color: #f2f2f2; font-weight: bold; text-align: left;">
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>DOB</th>
                    <th>Gender</th>
                    <th>Role</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>';

        foreach ($users as $user) {
            $html .= '
            <tr>
                <td>' . $user['id'] . '</td>
                <td>' . esc($user['first_name'] . ' ' . $user['last_name']) . '</td>
                <td>' . esc($user['email']) . '</td>
                <td>' . esc($user['dob'] ?: 'N/A') . '</td>
                <td>' . ucfirst(esc($user['gender'] ?: 'N/A')) . '</td>
                <td>' . esc($user['role_name'] ?? 'User') . '</td>
                <td>' . ucfirst(esc($user['status'])) . '</td>
            </tr>';
        }

       $html .= '</tbody></table>';

    $mpdf = new \Mpdf\Mpdf([
        'mode' => 'utf-8',
        'format' => 'A4-Landscape',
        'margin_top' => 15,
        'margin_bottom' => 15
    ]);

    $mpdf->WriteHTML($html);
    
    if (ob_get_length()) {
        ob_clean(); 
    }
    
    $this->response->setHeader('Content-Type', 'application/pdf');

    $mpdf->Output('user_data_' . date('Ymd_His') . '.pdf', 'D');     
    exit();
    }
    public function healthcareAssistant()
    {
        return view('admin/healthcare_assistant');
    }
}