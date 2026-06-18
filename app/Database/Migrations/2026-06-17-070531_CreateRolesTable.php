<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRolesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'role_name' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'unique'     => true,
            ],
        ]);
        $attributes = ['ENGINE' => 'InnoDB'];

        // Primary Key
        $this->forge->addKey('id', true);
        $this->forge->createTable('roles',false, $attributes);
    }

    public function down()
    {
        $this->forge->dropTable('roles');
    }
}