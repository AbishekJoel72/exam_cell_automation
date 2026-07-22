<?php

namespace App\Exports\Admin;

use App\Models\Faculties;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class FacultyCredentialsExport implements FromCollection, WithEvents, WithHeadings
{
    protected $request;
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $faculty = Faculties::select(
            'faculties.staff_code',
            'faculties.first_name',
            'faculties.last_name',
            'faculties.email',
            'faculties.phone'
        )
            ->join('registration', 'registration.username', '=', 'faculties.staff_code')
            ->where('registration.role', 'faculty ');

        if ($this->request->department_id) {
            $faculty->where('faculties.department_id', $this->request->department_id);
        }

        if ($this->request->staff_code) {
            $faculty->where('faculties.staff_code',$this->request->staff_code);
        }

        if ($this->request->faculty_name) {
            $faculty->whereRaw(
                "CONCAT(faculties.first_name,' ',faculties.last_name) LIKE ?",
                ['%'.$this->request->faculty_name.'%']
            );
        }

        if ($this->request->designation) {
            $faculty->where('faculties.designation',$this->request->designation);
        }

        if ($this->request->qualification) {
            $faculty->where('faculties.qualification',$this->request->qualification);
        }

        if ($this->request->status != '') {
            $faculty->where('faculties.status',$this->request->status);
        }

        return $faculty->get()->map(function ($row) {
            return [
                'Staff Code' => $row->staff_code,
                'Faculty Name' => $row->first_name.' '.$row->last_name,
                'Username' => $row->staff_code,
                'Password' => $row->staff_code,
                'Email' => $row->email,
                'Phone' => $row->phone,
            ];
        });

    }

    public function headings(): array
    {
        return [
            'Staff Code',
            'Faculty Name',
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
                $event->sheet->setCellValue('A1', 'Faculty login Details');
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
