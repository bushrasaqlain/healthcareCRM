<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePatientsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true,
            ],
            'patient_name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'phone_number' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
            ],
            'age' => [
                'type' => 'INT',
                'null' => true,
            ],
            'gender' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => true,
            ],
            'home_address' => [
                'type' => 'TEXT',
            ],
            'pin_location' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'instructions' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('patients');
    }

    public function down()
    {
        $this->forge->dropTable('patients');
    }
}