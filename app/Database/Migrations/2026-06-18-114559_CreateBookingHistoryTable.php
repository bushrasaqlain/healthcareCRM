<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBookingHistoryTable extends Migration
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
            'booking_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false,
            ],
            'patient_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false,
            ],
            'status' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => false,
            ],
            'changed_by' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'changed_at' => [
                'type'       => 'DATETIME',
                'null'       => false,
            ],
            'notes' => [
                'type'       => 'TEXT',
                'null'       => true,
            ],
            'created_at' => [
                'type'       => 'DATETIME',
                'null'       => true,
                'default'    => null,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey('booking_id');
        $this->forge->addKey('patient_id');
        $this->forge->addKey('status');
        $this->forge->addKey('changed_at');

        // Add foreign key constraints if your database supports them
        // Uncomment these if you want foreign key constraints
        /*
        $this->forge->addForeignKey(
            'booking_id',
            'patient_test_bookings',
            'id',
            'CASCADE',
            'CASCADE'
        );
        
        $this->forge->addForeignKey(
            'patient_id',
            'patients',
            'id',
            'CASCADE',
            'CASCADE'
        );
        */

        $this->forge->createTable('booking_status_history');
    }

    public function down()
    {
        $this->forge->dropTable('booking_status_history', true);
    }
}



