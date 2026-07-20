<?php

namespace App\Imports\Admin;

use App\Models\Classroom;
use App\Models\Course;
use App\Models\Department;
use App\Models\Student;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class StudentImport implements ToCollection
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

            $departmentCode = null;
            $courseCode = null;
            $roomNo = null;

            foreach ($headers as $index => $header) {

                if (! isset($row[$index])) {
                    continue;
                }

                switch (trim($header)) {

                    case 'Department Code':
                        $departmentCode = trim($row[$index]);
                        break;

                    case 'Course Code':
                        $courseCode = trim($row[$index]);
                        break;

                    case 'Room No':
                        $roomNo = trim($row[$index]);
                        break;

                    case 'First Name':
                        $data['first_name'] = trim($row[$index]);
                        break;

                    case 'Last Name':
                        $data['last_name'] = trim($row[$index]);
                        break;

                    case 'Gender':
                        $data['gender'] = strtolower(trim($row[$index]));
                        break;

                    case 'Date of Birth':

                        $value = $row[$index];

                        if (! empty($value)) {

                            if (is_numeric($value)) {
                                $data['dob'] = Date::excelToDateTimeObject($value)->format('Y-m-d');
                            } else {
                                $data['dob'] = date('Y-m-d', strtotime($value));
                            }

                        }

                        break;

                    case 'Email':
                        $data['email'] = trim($row[$index]);
                        break;

                    case 'Phone':
                        $data['phone'] = trim($row[$index]);
                        break;

                    case 'Register No':
                        $data['register_no'] = trim($row[$index]);
                        break;

                    case 'Roll No':
                        $data['roll_no'] = trim($row[$index]);
                        break;

                    case 'Academic Year':
                        $data['academic_year'] = trim($row[$index]);
                        break;

                    case 'Current Year':
                        $data['current_year'] = trim($row[$index]);
                        break;

                    case 'Semester':
                        $data['semester'] = trim($row[$index]);
                        break;

                    case 'Section':
                        $data['section'] = trim($row[$index]);
                        break;

                }
            }

            // Department
            if ($departmentCode) {

                $department = Department::where('department_code', $departmentCode)->first();

                if ($department) {
                    $data['department_id'] = $department->id;
                } else {

                    $this->errors_list[] = [
                        'department_code' => $departmentCode,
                        'error_reason' => "Department Code '$departmentCode' system database-il illai.",
                    ];

                    continue;
                }
            }

            // Course
            if ($courseCode) {

                $course = Course::where('course_code', $courseCode)->first();

                if ($course) {
                    $data['course_id'] = $course->id;
                } else {

                    $this->errors_list[] = [
                        'course_code' => $courseCode,
                        'error_reason' => "Course Code '$courseCode' system database-il illai.",
                    ];

                    continue;
                }
            }

            // Classroom
            if ($roomNo) {

                $classroom = Classroom::where('room_no', $roomNo)->first();

                if ($classroom) {
                    $data['classroom_id'] = $classroom->id;
                } else {

                    $this->errors_list[] = [
                        'room_no' => $roomNo,
                        'error_reason' => "Room No '$roomNo' system database-il illai.",
                    ];

                    continue;
                }
            }

            if (! empty($data) && isset($data['department_id']) && isset($data['course_id']) && isset($data['classroom_id'])) {
                Student::create($data);
            }
        }
    }
}
