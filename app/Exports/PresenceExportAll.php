<?php

namespace App\Exports;

use App\Models\Presence;
use App\Models\Attendance;
use App\Models\Anggota;
use App\Models\Classroom;
use App\Models\Lesson;
use App\Models\Teacher;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Carbon\Carbon;

class PresenceExportAll implements FromCollection,WithTitle, WithHeadings, WithMapping, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Presence::all();
    }
    
    public function headings(): array
    {
        return [
            'id',
            'title',
            'lesson',
            'classroom',
            'code',
            'input_by',
            'create_by',
            'status',
            'created_at',
        ];
    }

    public function title(): string
    {
        return 'Tabel Semua Data Presensi Siswa';
    }

    public function map($presence): array
    {
        $statusLabel = 'Alpa';

        if ($presence->status === 2) {
            $statusLabel = 'Izin';
        } elseif ($presence->status === 3) {
            $statusLabel = 'Sakit';
        } elseif ($presence->status === 1) {
            $statusLabel = 'Hadir';
        } else {
            $statusLabel = 'Alpa';
        }

        $createby = '';
        if ($presence->attendance->role_id === 2)
        $createby = $presence->attendance->teacher->name;
        else {
            $createby = $presence->attendance->user->name;
        }

        return [
            $presence->id,
            $presence->attendance->title,
            $presence->attendance->lesson->name, // Ubah relasi dan field sesuai dengan struktur Anda
            $presence->attendance->classroom->name, // Ubah relasi dan field sesuai dengan struktur Anda
            $presence->attendance->code, // Ubah relasi dan field sesuai dengan struktur Anda
            $presence->anggota->name,
            $createby,
            $statusLabel,
            Carbon::parse($presence->attendance->created_at)->format('d/m/Y'), // Format tanggal
        ];
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
            'alignment' => [
                'wrapText' => true, // Set wrapText to true
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
        $sheet->getStyle('A1:I1')->applyFromArray($styleArray2);
        // Set column widths based on content length
        foreach (range('A', $highestColumn) as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }
    }
}
