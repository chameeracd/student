<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        $studentModel = new \App\Models\StudentModel();
        $studentList = $studentModel->findAll();
        $students = array();
        foreach($studentList as $student) {
            $students[] = '-- Select --';
            $students[$student['id']] = $student['student_id'];
        }

        $subjectModel = new \App\Models\SubjectModel();
        $subjectList = $subjectModel->findAll();
        $subjects = array();
        foreach($subjectList as $subject) {
            $subjects[] = '-- Select --';
            $subjects[$subject['id']] = $subject['name'];
        }

        $gradeModel = new \App\Models\GradeModel();
        $gradeList = $gradeModel->findAll();
        $grades = array();
        foreach($gradeList as $grade) {
            $grades[] = '-- Select --';
            $grades[$grade['id']] = $grade['grade'];
        }

        $yearStart  = date('Y', strtotime('-10 year'));
        $yearEnd = date('Y', strtotime('+10 year'));
        $years = array();
        for($yearStart; $yearStart <= $yearEnd; $yearStart++) {
            $years[] = '-- Select --';
            $years[$yearStart] = $yearStart;
        }

        $data['students'] = $students;
        $data['subjects'] = $subjects;
        $data['grades'] = $grades;
        $data['years'] = $years;

        if ($this->request->getMethod() == 'post') {
            //chart generation
        }

        return view('home', $data);
    }
}
