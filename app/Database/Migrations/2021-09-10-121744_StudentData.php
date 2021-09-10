<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class StudentData extends Migration
{
        public function up()
        {
                $this->forge->addField([
                        'id'=> [
                                'type'           => 'INT',
                                'constraint'     => 5,
                                'unsigned'       => true,
                                'auto_increment' => true,
                        ],
                        'student_id' => [
                                'type'       => 'VARCHAR',
                                'constraint' => '100',
                        ],
                        'subject' => [
                                'type'       => 'VARCHAR',
                                'constraint' => '255',
                        ],
                        'mark' => [
                                'type'       => 'TINYINT'
                        ],
                        'semester' => [
                                'type'       => 'VARCHAR',
                                'constraint' => '100',
                        ],
                        'student_name' => [
                                'type'       => 'VARCHAR',
                                'constraint' => '255',
                        ],
                        'grade' => [
                                'type'       => 'VARCHAR',
                                'constraint' => '100',
                        ],
                        'year' => [
                                'type'       => 'VARCHAR',
                                'constraint' => '5',
                        ],
                ]);
                $this->forge->addKey('id', true);
                $this->forge->addKey('student_id');
                $this->forge->addKey('grade');
                $this->forge->addKey('subject');
                $this->forge->createTable('student_mark');
        }

        public function down()
        {
                $this->forge->dropTable('student_mark');
        }
}
