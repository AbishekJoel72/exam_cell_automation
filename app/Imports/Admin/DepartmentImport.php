<?php

namespace App\Imports\Admin;

use App\Models\Department;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class DepartmentImport implements ToCollection
{
     public function collection(Collection $rows)
    {
        $headers = $rows->first()->toArray();
        $rows = $rows->skip(1);

        foreach ($rows as $row) {
            if ($row->filter()->isEmpty()) {
                continue;
            }
            $data = [];
            foreach ($headers as $index => $header) {
                switch (trim($header)) {
                    case 'Department Code':
                        $data['department_code'] = $row[$index];
                        break;

                    case 'Department Name':
                        $data['department_name'] = $row[$index];
                        break;
                }
            }

            if (!empty($data)) {
                Department::create($data);
            }
        }
    }
}
