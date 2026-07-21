<?php

namespace App\Exports\Admin;

use Illuminate\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class SeatAllocationExport implements FromView, WithEvents
{
   protected $seatAllocation;

    public function __construct($seatAllocation)
    {
        $this->seatAllocation = $seatAllocation;
    }

    public function view(): View
    {
        return view('Export.excel.seatallocation_excel', ['seatAllocation' => $this->seatAllocation]);
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

                $lastRow = count($this->seatAllocation) + 2;
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
