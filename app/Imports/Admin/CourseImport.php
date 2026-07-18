<?php

namespace App\Imports\Admin;

use App\Models\Course;
use App\Models\Department;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class CourseImport implements ToCollection
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
            foreach ($headers as $index => $header) {
                if (!isset($row[$index])) continue;

                switch (trim($header)) {
                    case 'Department Code':
                        $deptCode = trim($row[$index]);
                        break;

                    case 'Course Code':
                        $data['course_code'] = $row[$index];
                        break;

                    case 'Course Name':
                        $data['course_name'] = $row[$index];
                        break;

                    case 'Duration':
                        $data['duration'] = $row[$index];
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
                        'course_code' => $data['course_code'] ?? '',
                        'course_name' => $data['course_name'] ?? '',
                        'duration' => $data['duration'] ?? '',
                        'error_reason' => "Department Code '$deptCode' system database-il illai.",
                    ];

                    continue;
                }
            }

            if (! empty($data) && isset($data['department_id'])) {
                Course::create($data);
            }
        }
    }
}
