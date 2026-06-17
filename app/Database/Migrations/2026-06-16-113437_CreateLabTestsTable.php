<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLabTestsTable extends Migration
{
public function up()
{
    $this->forge->addField([
        'id' => [
            'type'           => 'INT',
            'auto_increment' => true,
        ],
        'lab_id' => [
            'type' => 'INT',
        ],
        'test_code' => [
            'type'       => 'VARCHAR',
            'constraint' => 100,
            'null'       => true,
        ],
        'test_name' => [
            'type'       => 'VARCHAR',
            'constraint' => 255,
        ],
        'rate' => [
            'type'       => 'DECIMAL',
            'constraint' => '10,2',
            'default'    => 0,
        ],
        'sample' => [
            'type'       => 'VARCHAR',
            'constraint' => 255,
            'null'       => true,
        ],
        'reporting_time' => [
            'type'       => 'VARCHAR',
            'constraint' => 100,
            'null'       => true,
        ],
        'created_at' => [
            'type' => 'DATETIME',
            'null' => true,
        ],
    ]);

    $this->forge->addPrimaryKey('id');
    $this->forge->addForeignKey('lab_id', 'labs', 'id', 'CASCADE', 'CASCADE');
    $this->forge->createTable('lab_tests');
}
public function down()
{
    $this->forge->dropTable('lab_tests');
}
}
