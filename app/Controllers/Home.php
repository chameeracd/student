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
            $students[null] = '-- Select --';
            $students[$student['id']] = $student['student_id'];
        }

        $subjectModel = new \App\Models\SubjectModel();
        $subjectList = $subjectModel->findAll();
        $subjects = array();
        $categories = array();
        foreach($subjectList as $subject) {
            $subjects[null] = '-- Select --';
            $subjects[$subject['id']] = $subject['name'];
            $categories[$subject['id']] = $subject['name'];
        }

        $gradeModel = new \App\Models\GradeModel();
        $gradeList = $gradeModel->findAll();
        $grades = array();
        foreach($gradeList as $grade) {
            $grades[null] = '-- Select --';
            $grades[$grade['id']] = $grade['grade'];
        }

        $yearStart  = date('Y', strtotime('-10 year'));
        $yearEnd = date('Y', strtotime('+10 year'));
        $years = array();
        for($yearStart; $yearStart <= $yearEnd; $yearStart++) {
            $years[null] = '-- Select --';
            $years[$yearStart] = $yearStart;
        }

        $data['students'] = $students;
        $data['subjects'] = $subjects;
        $data['grades'] = $grades;
        $data['years'] = $years;

        if ($this->request->getMethod() == 'post') {
            //chart generation
            $boxplot = array();
            $barchart = array();
            $markModel = new \App\Models\MarkModel();

            $boxplot['categories'] = array_values($categories);
            $barchart['categories'] = array_values($categories);

            $plot = array();
            $where = array();
            $studentData = array();
            if($this->request->getPost('student')) {
                $where['student_id'] = $this->request->getPost('student');
            }
            if($this->request->getPost('grade')) {
                $where['grade_id'] = $this->request->getPost('grade');
            }
            if($this->request->getPost('year')) {
                $where['year'] = $this->request->getPost('year');
            }

            $i = 0;
            foreach($categories as $subId => $sub) {
                $marks = $markModel->select('mark')
                                ->where('subject_id', $subId)
                                ->findAll();

                $barWhere = $where;
                $barWhere['subject_id'] = $subId;
                $totalAvgMarks = $markModel->select('SUM(mark) AS total, AVG(mark) AS avg')
                                        ->where($barWhere)
                                        ->findAll();

                if($this->request->getPost('student')) {
                    $where['subject_id'] = $subId;
                    $studentMarks = $markModel->select('mark')
                                        ->where($where)
                                        ->findAll();
 
                    foreach(array_column($studentMarks, 'mark') as $studentMark) {
                        if($this->request->getPost('subject')) {
                            if($subId == $this->request->getPost('subject')) {
                                $studentData[] = array($i, (int) $studentMark);  
                            }
                        } else {
                            $studentData[] = array($i, (int) $studentMark);
                        }
                    }
                }

                $values = $this->getBoxPlotValues(array_column($marks, 'mark'));
                $barchart['total'][] = (int) $totalAvgMarks[0]['total'];
                $barchart['avg'][] = (float) $totalAvgMarks[0]['avg'];

                $plot[] =  array((int) $values['min'], (int) $values['q1'], (int) $values['median'], (int) $values['q3'], (int) $values['max']);

                $i++;
            }
            $boxplot['plot'] = $plot;
            $boxplot['data'] = $studentData;

            $data['boxplot'] = $boxplot;
            $data['barchart'] = $barchart;
        }

        return view('home', $data);
    }

    protected function getBoxPlotValues($array)
    {
        $return = array(
            'lower_outlier'  => 0,
            'min'            => 0,
            'q1'             => 0,
            'median'         => 0,
            'q3'             => 0,
            'max'            => 0,
            'higher_outlier' => 0,
        );

        $array_count = count($array);
        sort($array, SORT_NUMERIC);

        $return['min']            = $array[0];
        $return['lower_outlier']  = $return['min'];
        $return['max']            = $array[$array_count - 1];
        $return['higher_outlier'] = $return['max'];
        $middle_index             = floor($array_count / 2);
        $return['median']         = $array[$middle_index]; // Assume an odd # of items
        $lower_values             = array();
        $higher_values            = array();

        // If we have an even number of values, we need some special rules
        if ($array_count % 2 == 0)
        {
            // Handle the even case by averaging the middle 2 items
            $return['median'] = round(($return['median'] + $array[$middle_index - 1]) / 2);

            foreach ($array as $idx => $value)
            {
                if ($idx < ($middle_index - 1)) $lower_values[]  = $value; // We need to remove both of the values we used for the median from the lower values
                elseif ($idx > $middle_index)   $higher_values[] = $value;
            }
        }
        else
        {
            foreach ($array as $idx => $value)
            {
                if ($idx < $middle_index)     $lower_values[]  = $value;
                elseif ($idx > $middle_index) $higher_values[] = $value;
            }
        }

        $lower_values_count = count($lower_values);
        $lower_middle_index = floor($lower_values_count / 2);
        $return['q1']       = $lower_values[$lower_middle_index];
        if ($lower_values_count % 2 == 0)
            $return['q1'] = round(($return['q1'] + $lower_values[$lower_middle_index - 1]) / 2);

        $higher_values_count = count($higher_values);
        $higher_middle_index = floor($higher_values_count / 2);
        $return['q3']        = $higher_values[$higher_middle_index];
        if ($higher_values_count % 2 == 0)
            $return['q3'] = round(($return['q3'] + $higher_values[$higher_middle_index - 1]) / 2);

        // Check if min and max should be capped
        $iqr = $return['q3'] - $return['q1']; // Calculate the Inner Quartile Range (iqr)
        if ($return['q1'] > $iqr)                  $return['min'] = $return['q1'] - $iqr;
        if ($return['max'] - $return['q3'] > $iqr) $return['max'] = $return['q3'] + $iqr;

        return $return;
    }
}
