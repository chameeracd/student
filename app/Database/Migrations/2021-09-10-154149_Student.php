<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Student extends Migration
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
            'student_name' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'student_id' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('student_id');
        $this->forge->createTable('students');
    }

    public function down()
    {
        $this->forge->dropTable('students');
    }
}
