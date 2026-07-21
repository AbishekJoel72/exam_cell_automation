<?php

namespace App\Exports\Admin;

use Illuminate\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class StudentExport implements FromView, WithEvents
{
   protected $student;

    public function __construct($student)
    {
        $this->student = $student;
    }

    public function view(): View
    {
        return view('Export.excel.student_excel', ['student' => $this->student]);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function ($event) {
                $event->sheet->insertNewRowBefore(1, 1);

                $event->sheet->setCellValue('A1', 'Student List');
                $event->sheet->mergeCells('A1:N1');
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

                $lastRow = count($this->student) + 2;
                $event->sheet->getStyle('A2:N2')->getFont()->setBold(true);

                $event->sheet->getStyle('A2:N'.$lastRow)
                    ->getBorders()
                    ->getAllBorders()
                    ->setBorderStyle(Border::BORDER_THIN);

                foreach (range('A', 'N') as $column) {
                    $event->sheet->getDelegate()
                        ->getColumnDimension($column)
                        ->setAutoSize(true);
                }
            },
        ];
    }
}
