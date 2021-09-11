<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Grade extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'grade' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('grades');
    }

    public function down()
    {
        $this->forge->dropTable('grades');
    }
}
