<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MarkSeeder extends Seeder
{
    public function run()
    {
        $students = $this->getStudents();
        $subjects = $this->getSubjects();

        for ($i = 0; $i < 10000; $i++) {
            $data = array();
            for ($j = 0; $j < 1000; $j++) {
                $values = array();

                $k = array_rand($students);
                $student = $students[$k];
                
                $values['student_id'] = $student['id'];
                $values['subject'] = $subjects[array_rand($subjects)];
                $values['mark'] = rand(0,100);
                $values['semester'] = rand(1,2);
                $values['student_name'] = $student['name'];
                $values['grade'] = rand(1,12);
                $values['year'] = $this->getYear();

                $data[] = $values;
            }

            $this->db->table('student_mark')->insertBatch($data);
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
            'id' => 'STD_00001',
            'name' => 'Kaylah Ferry'
        ];
        $students[] = [
            'id' => 'STD_00002',
            'name' => 'Maggie Murazik'
        ];
        $students[] = [
            'id' => 'STD_00003',
            'name' => 'Taurean Bogisich'
        ];
        $students[] = [
            'id' => 'STD_00004',
            'name' => 'Malika Murphy'
        ];
        $students[] = [
            'id' => 'STD_00005',
            'name' => 'Amara Cole'
        ];
        $students[] = [
            'id' => 'STD_00006',
            'name' => 'Lucio Kling'
        ];
        $students[] = [
            'id' => 'STD_00007',
            'name' => 'Hayden Carroll'
        ];
        $students[] = [
            'id' => 'STD_00008',
            'name' => 'Eden Sporer'
        ];
        $students[] = [
            'id' => 'STD_00009',
            'name' => 'Shayna Okuneva'
        ];
        $students[] = [
            'id' => 'STD_00010',
            'name' => 'Ova Kertzmann'
        ];
        $students[] = [
            'id' => 'STD_00011',
            'name' => 'Destiney Block'
        ];
        $students[] = [
            'id' => 'STD_00012',
            'name' => 'Owen White'
        ];
        $students[] = [
            'id' => 'STD_00013',
            'name' => 'Mireille Schiller'
        ];
        $students[] = [
            'id' => 'STD_00014',
            'name' => 'Leopold Beahan'
        ];
        $students[] = [
            'id' => 'STD_00015',
            'name' => 'Anne Gutkowski'
        ];
        $students[] = [
            'id' => 'STD_00016',
            'name' => 'Annabel Streich'
        ];
        $students[] = [
            'id' => 'STD_00017',
            'name' => 'Sylvia Wiegand'
        ];
        $students[] = [
            'id' => 'STD_00018',
            'name' => 'Jeanette Bergnaum'
        ];
        $students[] = [
            'id' => 'STD_00019',
            'name' => 'Edna Raynor'
        ];
        $students[] = [
            'id' => 'STD_00020',
            'name' => 'Charlie Volkman'
        ];

        return $students;
    }

    protected function getSubjects() {
        $subjects = array();
        $subjects = [
            'English',
            'Maths',
            'Science',
            'Art',
            'IT',
            'Tech',
            'Media',
            'Extra'
        ];

        return $subjects;
    }
}
