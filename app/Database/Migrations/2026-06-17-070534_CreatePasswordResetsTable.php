<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePasswordResetsTable extends Migration
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
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'token' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
        ]);
        $attributes = ['ENGINE' => 'InnoDB'];

        // Primary Key
        $this->forge->addKey('id', true);
        
        // Performance Index for searching by email lookups
        $this->forge->addKey('email');
        
        $this->forge->createTable('password_resets',false, $attributes);
    }

    public function down()
    {
        $this->forge->dropTable('password_resets');
    }
}