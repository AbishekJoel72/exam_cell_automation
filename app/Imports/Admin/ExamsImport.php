<?php

namespace App\Imports\Admin;

use App\Models\Department;
use App\Models\Exams;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use PhpOffice\PhpSpreadsheet\Shared\Date;
class ExamsImport implements ToCollection
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

                if (!isset($row[$index])) {
                    continue;
                }

                switch (trim($header)) {

                    case 'Department Code':
                        $departmentCode = trim($row[$index]);
                        break;

                    case 'Exam Name':
                        $data['exam_name'] = trim($row[$index]);
                        break;

                    case 'Exam Type':
                        $data['exam_type'] = trim($row[$index]);
                        break;

                    case 'Exam Cycle':
                        $data['exam_cycle'] = trim($row[$index]);
                        break;

                    case 'Exam Date':

                        $value = $row[$index];

                        if (!empty($value)) {

                            if (is_numeric($value)) {
                                $data['exam_date'] = Date::excelToDateTimeObject($value)->format('Y-m-d');
                            } else {
                                $data['exam_date'] = date('Y-m-d', strtotime($value));
                            }

                        }

                        break;

                    case 'Start Time':

                        $value = $row[$index];

                        if (!empty($value)) {

                            if (is_numeric($value)) {
                                $data['start_time'] = Date::excelToDateTimeObject($value)->format('H:i:s');
                            } else {
                                $data['start_time'] = date('H:i:s', strtotime($value));
                            }

                        }

                        break;

                    case 'End Time':

                        $value = $row[$index];

                        if (!empty($value)) {

                            if (is_numeric($value)) {
                                $data['end_time'] = Date::excelToDateTimeObject($value)->format('H:i:s');
                            } else {
                                $data['end_time'] = date('H:i:s', strtotime($value));
                            }

                        }

                        break;
                }
            }

            // Department Validation
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

            if (!empty($data) && isset($data['department_id'])) {

                Exams::create($data);
            }
        }
    }
}
