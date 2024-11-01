<?php

namespace App\Exports;

use App\Models\Lesson;
use App\Models\Classroom;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LessonExport implements FromCollection, WithHeadings, WithTitle, WithMapping, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Lesson::all();
    }

    public function map($lesson): array
    {
        // Map data ke array yang sesuai dengan headings
        return [
            $lesson->id,
            $lesson->name,
            $lesson->codeName,
            $lesson->class_id,
            $lesson->classroom->name,
        ];
    }
    public function headings(): array
    {
        return [
            'id',
            'name',
            'codeName',
            'class_id',
            'classroom',
        ];
    }
    public function title(): string
    {
        return 'Tabel Data Mata Pelajaran';
    }
    public function styles(Worksheet $sheet)
    {
        $highestColumn = $sheet->getHighestColumn();
        $highestRow = $sheet->getHighestRow();

        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ];
        $styleArray2 = [
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => ['argb' => 'DDDDDD'], // Kode warna abu-abu
            ],
        ];

        $range = 'A1:' . $highestColumn . $highestRow;
        $sheet->getStyle($range)->applyFromArray($styleArray);
        $sheet->getStyle('A1:E1')->applyFromArray($styleArray2);
        // Set column widths based on content length
        foreach (range('A', $highestColumn) as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }
    }
}