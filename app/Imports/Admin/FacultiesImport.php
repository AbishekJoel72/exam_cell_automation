<?php

namespace App\Imports\Admin;

use App\Models\Department;
use App\Models\Faculties;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class FacultiesImport implements ToCollection
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

            foreach ($headers as $index => $header) {

                if (! isset($row[$index])) {
                    continue;
                }

                switch (trim($header)) {

                    case 'Department Code':
                        $departmentCode = trim($row[$index]);
                        break;

                    case 'Staff Code':
                        $data['staff_code'] = trim($row[$index]);
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

                    case 'Designation':
                        $data['designation'] = trim($row[$index]);
                        break;

                    case 'Qualification':
                        $data['qualification'] = trim($row[$index]);
                        break;

                    case 'Experience':
                        $data['experience'] = trim($row[$index]);
                        break;

                }
            }

            // Department Verification
            if ($departmentCode) {

                $department = Department::where('department_code', $departmentCode)->first();

                if ($department) {

                    $data['department_id'] = $department->id;

                } else {

                    $this->errors_list[] = [
                        'department_code' => $departmentCode,
                        'staff_code' => $data['staff_code'] ?? '',
                        'first_name' => $data['first_name'] ?? '',
                        'last_name' => $data['last_name'] ?? '',
                        'gender' => $data['gender'] ?? '',
                        'dob' => $data['dob'] ?? '',
                        'email' => $data['email'] ?? '',
                        'phone' => $data['phone'] ?? '',
                        'designation' => $data['designation'] ?? '',
                        'qualification' => $data['qualification'] ?? '',
                        'experience' => $data['experience'] ?? '',
                        'error_reason' => "Department Code '$departmentCode' system database-il illai.",
                    ];

                    continue;
                }
            }

            if (! empty($data) && isset($data['department_id'])) {
                Faculties::create($data);
            }
        }
    }
}
