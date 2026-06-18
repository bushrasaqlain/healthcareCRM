<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateShareTokensTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'booking_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'token' => [
                'type' => 'VARCHAR',
                'constraint' => 64,
            ],
            'created_at' => [
                'type' => 'DATETIME',
            ],
            'expires_at' => [
                'type' => 'DATETIME',
            ],
            'view_count' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0,
            ],
        ]);
        
        $this->forge->addKey('id', true);
        $this->forge->addKey(['booking_id', 'token']);
        $this->forge->addKey('expires_at');
        $this->forge->addForeignKey('booking_id', 'patient_test_bookings', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('share_tokens');
    }

    public function down()
    {
        $this->forge->dropTable('share_tokens');
    }
}