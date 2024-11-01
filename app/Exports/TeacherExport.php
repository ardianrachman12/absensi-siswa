<?php

namespace App\Exports;

use App\Models\Teacher;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TeacherExport implements FromCollection, WithHeadings, WithTitle, WithMapping, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Teacher::all();
    }

    public function map($teacher): array
    {
        // Map data ke array yang sesuai dengan headings
        return [
            $teacher->id,
            $teacher->name,
            $teacher->username,
        ];
    }
    public function headings(): array
    {
        return [
            'id',
            'name',
            'username',
        ];
    }
    public function title(): string
    {
        return 'Tabel Data Guru';
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
        $sheet->getStyle('A1:C1')->applyFromArray($styleArray2);
        // Set column widths based on content length
        foreach (range('A', $highestColumn) as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }
    }
}
