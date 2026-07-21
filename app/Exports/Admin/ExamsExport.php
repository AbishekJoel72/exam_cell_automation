<?php

namespace App\Exports\Admin;

use Illuminate\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class ExamsExport implements FromView, WithEvents
{
   protected $exams;

    public function __construct($exams)
    {
        $this->exams = $exams;
    }

    public function view(): View
    {
        return view('Export.excel.exams_excel', ['exams' => $this->exams]);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function ($event) {
                $event->sheet->insertNewRowBefore(1, 1);

                $event->sheet->setCellValue('A1', 'Faculties List');
                $event->sheet->mergeCells('A1:I1');
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

                $lastRow = count($this->exams) + 2;
                $event->sheet->getStyle('A2:I2')->getFont()->setBold(true);

                $event->sheet->getStyle('A2:I'.$lastRow)
                    ->getBorders()
                    ->getAllBorders()
                    ->setBorderStyle(Border::BORDER_THIN);

                foreach (range('A', 'I') as $column) {
                    $event->sheet->getDelegate()
                        ->getColumnDimension($column)
                        ->setAutoSize(true);
                }
            },
        ];
    }
}
