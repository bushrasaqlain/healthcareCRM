<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePatientTestsBooking extends Migration
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
            'fk_patient_id' => [
                // References patients.id — see the commented foreign key
                // below once that table exists.
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'fk_test_id' => [
                // References tests.id (the tests table already exists).
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'status' => [
                // Matches the status pills used on the Lab Partner Dashboard.
                'type'       => 'ENUM',
                'constraint' => [
                    'In Process',
                    'Phlebotomist Assigned',
                    'Arrived',
                    'Sample Collected',
                    'Report Ready',
                    'Refused',
                ],
                'default' => 'In Process',
            ],
            'eta' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'discount_percent' => [
                'type'       => 'INT',
                'constraint' => '11',
                 'unsigned'   => true,
            ],
            'paid_status' => [
                'type'       => 'ENUM',
                'constraint' => ['cash', 'prepaid'],
                'default'    => 'prepaid',
            ],
            'date_created' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'date_updated' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->addKey('fk_patient_id');
        $this->forge->addKey('fk_test_id');

        // Enabled now since tests already exists.
        // onUpdate CASCADE keeps things in sync if a test's id ever changes;
        // onDelete RESTRICT stops a test from being deleted while it's
        // still referenced by a booking, protecting historical records.
        $this->forge->addForeignKey('fk_test_id', 'lab_tests', 'id', 'CASCADE', 'RESTRICT');

        // Uncomment once a patients table exists, adjusting the table/column
        // names below if yours differ.
        // $this->forge->addForeignKey('fk_patient_id', 'patients', 'id', 'CASCADE', 'RESTRICT');

        $this->forge->createTable('patient_test_bookings');
    }

    public function down()
    {
        $this->forge->dropTable('patient_test_bookings');
    }
}
