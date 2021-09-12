<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MarkSeeder extends Seeder
{
    public function run()
    {
        $students = $this->getStudents();
        $subjects = $this->getSubjects();
        $grades = $this->getGrades();

        $this->db->disableForeignKeyChecks();

        $this->db->query("TRUNCATE TABLE students");
        $this->db->query("TRUNCATE TABLE subjects");
        $this->db->query("TRUNCATE TABLE grades");
        $this->db->query("TRUNCATE TABLE marks");

        $this->db->enableForeignKeyChecks();

        $this->db->table('students')->insertBatch($students);
        $this->db->table('subjects')->insertBatch($subjects);
        $this->db->table('grades')->insertBatch($grades);

        $query = $this->db->query("SELECT id FROM students");
        $studentIds = array_column($query->getResult('array'), 'id');

        $query = $this->db->query("SELECT id FROM subjects");
        $subjectIds = array_column($query->getResult('array'), 'id');

        $query = $this->db->query("SELECT id FROM grades");
        $gradeIds = array_column($query->getResult('array'), 'id');

        $batch = (getenv('bulk.batchSize')) ? getenv('bulk.batchSize') : 10000;
        $repeat = (getenv('bulk.repeats')) ? getenv('bulk.repeats') : 1000;
        for ($i = 0; $i < $batch; $i++) {
            $data = array();
            for ($j = 0; $j < $repeat; $j++) {
                $values = array();
                
                $values['student_id'] = $studentIds[array_rand($studentIds)];
                $values['subject_id'] = $subjectIds[array_rand($subjectIds)];
                $values['grade_id'] = $gradeIds[array_rand($gradeIds)];
                $values['mark'] = rand(0,100);
                $values['semester'] = rand(1,2);
                $values['year'] = $this->getYear();

                $data[] = $values;
            }

            $this->db->table('marks')->insertBatch($data);
        }
    }

    protected function getYear() {
        $start = strtotime("2010-01-01");
        $end = strtotime("2020-01-01");

        $timestamp = mt_rand($start, $end);

        return date("Y", $timestamp);
    }

    protected function getStudents() {
        $students = array();
        $students[] = [
            'student_id' => 'STD_00001',
            'student_name' => 'Kaylah Ferry'
        ];
        $students[] = [
            'student_id' => 'STD_00002',
            'student_name' => 'Maggie Murazik'
        ];
        $students[] = [
            'student_id' => 'STD_00003',
            'student_name' => 'Taurean Bogisich'
        ];
        $students[] = [
            'student_id' => 'STD_00004',
            'student_name' => 'Malika Murphy'
        ];
        $students[] = [
            'student_id' => 'STD_00005',
            'student_name' => 'Amara Cole'
        ];
        $students[] = [
            'student_id' => 'STD_00006',
            'student_name' => 'Lucio Kling'
        ];
        $students[] = [
            'student_id' => 'STD_00007',
            'student_name' => 'Hayden Carroll'
        ];
        $students[] = [
            'student_id' => 'STD_00008',
            'student_name' => 'Eden Sporer'
        ];
        $students[] = [
            'student_id' => 'STD_00009',
            'student_name' => 'Shayna Okuneva'
        ];
        $students[] = [
            'student_id' => 'STD_00010',
            'student_name' => 'Ova Kertzmann'
        ];
        $students[] = [
            'student_id' => 'STD_00011',
            'student_name' => 'Destiney Block'
        ];
        $students[] = [
            'student_id' => 'STD_00012',
            'student_name' => 'Owen White'
        ];
        $students[] = [
            'student_id' => 'STD_00013',
            'student_name' => 'Mireille Schiller'
        ];
        $students[] = [
            'student_id' => 'STD_00014',
            'student_name' => 'Leopold Beahan'
        ];
        $students[] = [
            'student_id' => 'STD_00015',
            'student_name' => 'Anne Gutkowski'
        ];
        $students[] = [
            'student_id' => 'STD_00016',
            'student_name' => 'Annabel Streich'
        ];
        $students[] = [
            'student_id' => 'STD_00017',
            'student_name' => 'Sylvia Wiegand'
        ];
        $students[] = [
            'student_id' => 'STD_00018',
            'student_name' => 'Jeanette Bergnaum'
        ];
        $students[] = [
            'student_id' => 'STD_00019',
            'student_name' => 'Edna Raynor'
        ];
        $students[] = [
            'student_id' => 'STD_00020',
            'student_name' => 'Charlie Volkman'
        ];

        return $students;
    }

    protected function getSubjects() {
        $subjects = array();
        $subjects[] = [
            'name' => 'English'
        ];
        $subjects[] = [
            'name' => 'Maths'
        ];
        $subjects[] = [
            'name' => 'Science'
        ];
        $subjects[] = [
            'name' => 'Art'
        ];
        $subjects[] = [
            'name' => 'IT'
        ];
        $subjects[] = [
            'name' => 'Tech'
        ];
        $subjects[] = [
            'name' => 'Media'
        ];

        return $subjects;
    }

    protected function getGrades() {
        $grades = array();
        $grades[] = [
            'grade' => '1'
        ];
        $grades[] = [
            'grade' => '2'
        ];
        $grades[] = [
            'grade' => '3'
        ];
        $grades[] = [
            'grade' => '4'
        ];
        $grades[] = [
            'grade' => '5'
        ];
        $grades[] = [
            'grade' => '6'
        ];
        $grades[] = [
            'grade' => '7'
        ];
        $grades[] = [
            'grade' => '8'
        ];
        $grades[] = [
            'grade' => '9'
        ];
        $grades[] = [
            'grade' => '10'
        ];
        $grades[] = [
            'grade' => '11'
        ];
        $grades[] = [
            'grade' => '12'
        ];

        return $grades;
    }
}
