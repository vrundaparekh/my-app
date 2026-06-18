<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Setup Admin login credentials for assessment criteria [cite: 133]
        $userData = [
            'first_name' => 'System',
            'last_name'  => 'Admin',
            'email'      => 'admin@admin.com',
            // Securely encrypted password using BCRYPT 
            'password'   => password_hash('admin123', PASSWORD_BCRYPT),
            'role_id'    => 1, // Admin Role ID from our roles table 
            'status'     => 'active',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        // Insert
        $this->db->table('users')->insert($userData);
        $newUserId = $this->db->insertID();

        $this->db->table('user_profiles')->insert([
            'user_id'     => $newUserId,
            'dob'         => '1990-01-01',
            'gender'      => 'male',
            'address'     => 'Admin Headquarters',
            'profile_pic' => null
        ]);
    }
}
