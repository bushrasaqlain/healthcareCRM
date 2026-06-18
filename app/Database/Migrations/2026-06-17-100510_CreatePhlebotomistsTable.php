<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePhlebotomistsTable extends Migration
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
        'name' => [
            'type'       => 'VARCHAR',
            'constraint' => 150,
        ],
        'city' => [
            'type'       => 'VARCHAR',
            'constraint' => 100,
            'null'       => true,
        ],
        'status' => [
            'type'       => 'ENUM',
            'constraint' => ['active', 'inactive'],
            'default'    => 'active',
        ],
        'created_at' => [
            'type' => 'DATETIME',
            'null' => true,
        ],
    ]);

    $this->forge->addPrimaryKey('id');
    $this->forge->addForeignKey('lab_id', 'labs', 'id', 'CASCADE', 'CASCADE');
    $this->forge->createTable('phlebotomists');
}

public function down()
{
    $this->forge->dropTable('phlebotomists');
}
}
