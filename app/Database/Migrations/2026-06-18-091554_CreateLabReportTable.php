<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLabReportsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE,
            ],
            'fk_booking_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
            ],
            'fk_test_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
            ],
            'fk_patient_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
            ],
            'report_file' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'report_status' => [
                'type' => 'ENUM',
                'constraint' => ['pending', 'uploaded', 'verified'],
                'default' => 'pending',
            ],
            'uploaded_at' => [
                'type' => 'DATETIME',
                'null' => TRUE,
            ],
            'verified_at' => [
                'type' => 'DATETIME',
                'null' => TRUE,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => TRUE,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => TRUE,
            ],
        ]);
        
        $this->forge->addKey('id', TRUE);
        
      
        $this->forge->createTable('lab_reports');
    }

    public function down()
    {
        $this->forge->dropTable('lab_reports', true);
    }
}