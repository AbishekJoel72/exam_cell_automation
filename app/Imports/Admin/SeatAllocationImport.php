<?php

namespace App\Imports\Admin;

use App\Models\Classroom;
use App\Models\Exams;
use App\Models\SeatAllocations;
use App\Models\Student;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class SeatAllocationImport implements ToCollection
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

            $examName = null;
            $registerNo = null;
            $roomNo = null;

            foreach ($headers as $index => $header) {

                if (!isset($row[$index])) {
                    continue;
                }

                switch (trim($header)) {

                    case 'Exam Name':
                        $examName = trim($row[$index]);
                        break;

                    case 'Register No':
                        $registerNo = trim($row[$index]);
                        break;

                    case 'Room No':
                        $roomNo = trim($row[$index]);
                        break;

                    case 'Seat No':
                        $data['seat_no'] = trim($row[$index]);
                        break;

                    case 'Row No':
                        $data['row_no'] = trim($row[$index]);
                        break;
                }
            }

            // Exam Validation
            if ($examName) {

                $exam = Exams::where('exam_name', $examName)->first();

                if ($exam) {

                    $data['exam_id'] = $exam->id;

                } else {

                    $this->errors_list[] = [
                        'exam_name' => $examName,
                        'error_reason' => "Exam Name '$examName' system database-il illai.",
                    ];

                    continue;
                }
            }

            // Student Validation
            if ($registerNo) {

                $student = Student::where('register_no', $registerNo)->first();

                if ($student) {

                    $data['student_id'] = $student->id;

                } else {

                    $this->errors_list[] = [
                        'register_no' => $registerNo,
                        'error_reason' => "Register No '$registerNo' system database-il illai.",
                    ];

                    continue;
                }
            }

            // Classroom Validation
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

            if (!empty($data) && isset($data['exam_id']) &&isset($data['student_id']) &&isset($data['classroom_id'])) {
                SeatAllocations::create($data);
            }
        }
    }
}
