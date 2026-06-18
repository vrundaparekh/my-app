<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run()
    {
        $this->db->table('roles')->where('id >', 0)->delete();

        $data = [
            ['id' => 1, 'role_name' => 'Admin'],
            ['id' => 2, 'role_name' => 'User'],
            ['id' => 3, 'role_name' => 'Staff'],
            ['id' => 4, 'role_name' => 'Manager'],
        ];

        $this->db->table('roles')->insertBatch($data);
    }
}
