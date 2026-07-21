<?php

namespace App\Exports\Admin;

use Illuminate\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class DepartmentExport implements FromView, WithEvents
{
    protected $departments;

    public function __construct($departments)
    {
        $this->departments = $departments;
    }

    public function view(): View
    {
        return view('Export.excel.department_excel', ['departments' => $this->departments]);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function ($event) {
                $event->sheet->insertNewRowBefore(1, 1);

                $event->sheet->setCellValue('A1', 'Department List');
                $event->sheet->mergeCells('A1:D1');
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

                $lastRow = count($this->departments) + 2;
                $event->sheet->getStyle('A2:D2')->getFont()->setBold(true);

                $event->sheet->getStyle('A2:D'.$lastRow)
                    ->getBorders()
                    ->getAllBorders()
                    ->setBorderStyle(Border::BORDER_THIN);

                // Auto Width
                foreach (range('A', 'D') as $column) {
                    $event->sheet->getDelegate()
                        ->getColumnDimension($column)
                        ->setAutoSize(true);
                }
            },
        ];
    }
}
