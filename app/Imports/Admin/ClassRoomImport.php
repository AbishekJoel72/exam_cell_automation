<?php

namespace App\Imports\Admin;

use App\Models\Classroom;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ClassRoomImport implements ToCollection
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
                    case 'Room No':
                        $data['room_no'] = $row[$index];
                        break;

                    case 'Building':
                        $data['building'] = $row[$index];
                        break;

                    case 'Floor':
                        $data['floor'] = $row[$index];
                        break;

                    case 'Total Seats':
                        $data['total_seats'] = $row[$index];
                        break;
                }
            }

              if (!empty($data)) {
                Classroom::create($data);
            }
        }
    }
}
