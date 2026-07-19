<?php

namespace App\Imports\Admin;

use App\Models\Course;
use App\Models\Department;
use App\Models\Subjects;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class SubjectImport implements ToCollection
{
   public $errors_list = [];
    public function collection(Collection $rows)
    {
        $headers = $rows->first()->toArray();
        $rows = $rows->skip(1);
        foreach ($rows as $row) {
            if ($row->filter()->isEmpty()) {
                continue;
            }
            $data = [];
            $deptCode = null;
            $courseCode = null;
            foreach ($headers as $index => $header) {
                if (!isset($row[$index])) continue;

                switch (trim($header)) {
                    case 'Department Code':
                        $deptCode = trim($row[$index]);
                        break;

                    case 'Course Code':
                        $courseCode = trim($row[$index]);
                        break;

                    case 'Semester':
                        $data['semester'] = $row[$index];
                        break;

                    case 'Subject Code':
                        $data['subject_code'] = $row[$index];
                        break;

                    case 'Subject Name':
                        $data['subject_name'] = $row[$index];
                        break;

                    case 'Credits':
                        $data['credits'] = $row[$index];
                        break;
                }
            }
            if ($deptCode) {

                $department = Department::where('department_code', $deptCode)->first();

                if ($department) {
                    $data['department_id'] = $department->id;
                } else {
                    $this->errors_list[] = [
                        'department_code' => $deptCode,
                        'course_code' => $courseCode ?? '',
                        'semester' => $data['semester'] ?? '',
                        'subject_code' => $data['subject_code'] ?? '',
                        'subject_name' => $data['subject_name'] ?? '',
                        'credits' => $data['credits'] ?? '',
                        'error_reason' => "Department Code '$deptCode' system database-il illai.",
                    ];

                    continue;
                }
            }

            // Course verification code block (Strictly matching course structure)
            if ($courseCode) {

                $course = Course::where('course_code', $courseCode)->first();

                if ($course) {
                    $data['course_id'] = $course->id;
                } else {
                    $this->errors_list[] = [
                        'department_code' => $deptCode ?? '',
                        'course_code' => $courseCode,
                        'semester' => $data['semester'] ?? '',
                        'subject_code' => $data['subject_code'] ?? '',
                        'subject_name' => $data['subject_name'] ?? '',
                        'credits' => $data['credits'] ?? '',
                        'error_reason' => "Course Code '$courseCode' system database-il illai.",
                    ];

                    continue;
                }
            }

            if (! empty($data) && isset($data['department_id']) && isset($data['course_id'])) {
                Subjects::create($data);
            }
        }
    }
}
