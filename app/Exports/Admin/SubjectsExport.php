<?php

namespace App\Exports\Admin;

use Illuminate\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class SubjectsExport implements FromView, WithEvents
{
    protected $subjectses;

    public function __construct($subjectses)
    {
        $this->subjectses = $subjectses;
    }

    public function view(): View
    {
        return view('Export.excel.subject_excel', ['subjectses' => $this->subjectses]);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function ($event) {
                $event->sheet->insertNewRowBefore(1, 1);

                $event->sheet->setCellValue('A1', 'Subject List');
                $event->sheet->mergeCells('A1:H1');
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

                $lastRow = count($this->subjectses) + 2;
                $event->sheet->getStyle('A2:H2')->getFont()->setBold(true);

                $event->sheet->getStyle('A2:H'.$lastRow)
                    ->getBorders()
                    ->getAllBorders()
                    ->setBorderStyle(Border::BORDER_THIN);

                foreach (range('A', 'H') as $column) {
                    $event->sheet->getDelegate()
                        ->getColumnDimension($column)
                        ->setAutoSize(true);
                }
            },
        ];
    }
}
