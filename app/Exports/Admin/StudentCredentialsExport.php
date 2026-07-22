<?php

namespace App\Exports\Admin;

use App\Models\Student;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class StudentCredentialsExport implements FromCollection, WithHeadings, WithEvents
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $students = Student::select(
            'students.register_no',
            'students.first_name',
            'students.last_name',
            'students.email',
            'students.phone'
        )
            ->join('registration', 'registration.username', '=', 'students.register_no')
            ->where('registration.role', 'student');

        if ($this->request->department_id) {
            $students->where('students.department_id', $this->request->department_id);
        }

        if ($this->request->course_id) {
            $students->where('students.course_id', $this->request->course_id);
        }

        if ($this->request->semester) {
            $students->where('students.semester', $this->request->semester);
        }

        if ($this->request->section) {
            $students->where('students.section', $this->request->section);
        }

        if ($this->request->academic_year) {
            $students->where('students.academic_year', $this->request->academic_year);
        }

        if ($this->request->register_no) {
            $students->where('students.register_no', $this->request->register_no);
        }

        return $students->get()->map(function ($row) {
            return [
                'Register No' => $row->register_no,
                'Student Name' => $row->first_name.' '.$row->last_name,
                'Username' => $row->register_no,
                'Password' => $row->register_no,
                'Email' => $row->email,
                'Phone' => $row->phone,
            ];

        });
    }

    public function headings(): array
    {
        return [
            'Register No',
            'Student Name',
            'Username',
            'Password',
            'Email',
            'Phone',
        ];
    }

    public function registerEvents(): array
    {
        return [

            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->insertNewRowBefore(1, 1);
                $event->sheet->setCellValue('A1', 'Login Details');
                $event->sheet->mergeCells('A1:F1');

                $event->sheet->getStyle('A1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 18,
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                ]);

                $event->sheet->getStyle('A2:F2')->getFont()->setBold(true);

                $lastRow = $event->sheet->getHighestRow();

                $event->sheet->getStyle('A2:F'.$lastRow)
                    ->getBorders()
                    ->getAllBorders()
                    ->setBorderStyle(Border::BORDER_THIN);

                foreach (range('A', 'F') as $column) {
                    $event->sheet->getDelegate()
                        ->getColumnDimension($column)
                        ->setAutoSize(true);
                }

                $event->sheet->getStyle('A2:F'.$lastRow)
                    ->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER);

                $event->sheet->getStyle('A2:F'.$lastRow)
                    ->getAlignment()
                    ->setVertical(Alignment::VERTICAL_CENTER);
            },

        ];
    }
}
