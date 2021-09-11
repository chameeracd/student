<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Mark extends Migration
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
            'student_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true
            ],
            'subject_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true
            ],
            'grade_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true
            ],
            'mark' => [
                'type' => 'TINYINT'
            ],
            'semester' => [
                'type' => 'TINYINT'
            ],
            'year' => [
                'type' => 'VARCHAR',
                'constraint' => '5',
            ]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('student_id', 'students', 'id');
        $this->forge->addForeignKey('subject_id', 'subjects', 'id');
        $this->forge->addForeignKey('grade_id', 'grades', 'id');
        $this->forge->createTable('marks');
    }

    public function down()
    {
        $this->forge->dropTable('marks');
    }
}
