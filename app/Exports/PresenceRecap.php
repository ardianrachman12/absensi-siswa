<?php

namespace App\Exports;

use App\Models\Presence;
use App\Models\Attendance;
use App\Models\Anggota;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
// use Maatwebsite\Excel\Concerns\WithMapping;
// use Maatwebsite\Excel\Concerns\WithCustomTotals;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

class PresenceRecap implements FromQuery, WithHeadings, WithStyles
{
    use Exportable;

    private $id;
    private $totals;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function headings(): array
    {
        return [
            'title',
            'class_id',
            'lesson_id',
            'input_by',
            'status',
            'total alpa',
            'total hadir',
            'total izin',
            'total sakit',
        ];
    }

    public function query()
    {

        return DB::table('presences')
            ->join('attendances', 'presences.attendance_id', '=', 'attendances.id')
            ->join('classrooms', 'attendances.class_id', '=', 'classrooms.id')
            ->join('lessons', 'attendances.lesson_id', '=', 'lessons.id')
            ->join('anggotas', 'presences.inputby_id', '=', 'anggotas.id')
            ->where('presences.inputby_id', $this->id)
            ->select(
                'attendances.title as title',
                'classrooms.name as classroom_name',
                'lessons.name as lesson_name',
                'anggotas.name as anggota_name',
                DB::raw('CASE
                    WHEN presences.status = 2 THEN "Izin"
                    WHEN presences.status = 3 THEN "Sakit"
                    WHEN presences.status = 1 THEN "Hadir"
                    ELSE "Alpa"
                END as status_label'),
            )
            ->orderBy('presences.created_at', 'ASC'); // Sesuaikan dengan urutan yang Anda inginkan
            
            // Hitung total Alpa dan Hadir
            $alpaCount = $data->where('status_label', 'Alpa')->count();
            $hadirCount = $data->where('status_label', 'Hadir')->count();
            $hadirCount = $data->where('status_label', 'Izin')->count();
            $hadirCount = $data->where('status_label', 'Sakit')->count();

            // Simpan total Alpa dan Hadir ke dalam variabel totals
            $this->totals = [
                'F2' => $alpaCount,
                'G2' => $hadirCount,
                'H2' => $izinCount,
                'I2' => $sakitCount,
            ];

            return $data;
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
        $sheet->getStyle('A1:E1')->applyFromArray($styleArray2);
        
         // Set column widths based on content length
        foreach (range('A', $highestColumn) as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        // Menambahkan rumus COUNTIF ke sel F2 dan G2
        $sheet->setCellValue('F2', "=COUNTIF(E2:E" . $highestRow . ",\"Alpa\")");
        $sheet->setCellValue('G2', "=COUNTIF(E2:E" . $highestRow . ",\"Hadir\")");
        $sheet->setCellValue('H2', "=COUNTIF(E2:E" . $highestRow . ",\"Izin\")");
        $sheet->setCellValue('I2', "=COUNTIF(E2:E" . $highestRow . ",\"Sakit\")");

    }

    // public function map($query): array
    // {
    //     $totals = $this->calculateTotals();
    //     // Map data yang akan ditampilkan pada lembar kerja Excel
    //     return [
    //         $query->title,
    //         $query->lesson_name,
    //         $query->classroom_name,
    //         $query->anggota_name,
    //         $query->status_label,
    //         $totals['F2'],
    //         $totals['G2'],
    //         $totals['H2'],
    //         $totals['I2'],
    //     ];
    // }
}

// class PresenceRecap implements FromQuery, WithHeadings, WithStyles, WithMapping
// {
//     use Exportable;

//     private $id;

//     public function __construct($id)
//     {
//         $this->id = $id;
//     }

//     public function headings(): array
//     {
//         return [
//             'title',
//             'lesson_id',
//             'class_id',
//             'input_by',
//             'status',
//         ];
//     }

//     public function query()
//     {
//         // Hitung jumlah status
//         $statusCounts = [
//             0 => 0,
//             1 => 0,
//             2 => 0,
//             3 => 0,
//         ];

//         $query = DB::table('presences')
//             ->join('attendances', 'presences.attendance_id', '=', 'attendances.id')
//             ->join('classrooms', 'attendances.class_id', '=', 'classrooms.id')
//             ->join('lessons', 'attendances.lesson_id', '=', 'lessons.id')
//             ->join('anggotas', 'presences.inputby_id', '=', 'anggotas.id')
//             ->where('presences.inputby_id', $this->id)
//             ->select(
//                 'attendances.title as title',
//                 'classrooms.name as classroom_name',
//                 'lessons.name as lesson_name',
//                 'anggotas.name as anggota_name',
//                 DB::raw('CASE
//                     WHEN presences.status = 2 THEN "Izin"
//                     WHEN presences.status = 3 THEN "Sakit"
//                     WHEN presences.status = 1 THEN "Hadir"
//                     ELSE "Alpa"
//                 END as status_label')
//             )
//             ->orderBy('presences.created_at', 'ASC') // Sesuaikan dengan urutan yang Anda inginkan
//             ->get(); // Eksekusi query untuk mendapatkan data

//         // Hitung jumlah status berdasarkan hasil query
//         foreach ($query as $row) {
//             $status = $row->status_label;
//             if (array_key_exists($status, $statusCounts)) {
//                 $statusCounts[$status]++;
//             }
//         }

//         // Simpan jumlah status dalam properti
//         $this->statusCounts = $statusCounts;

//         return $query;
//     }
   
//     public function styles(Worksheet $sheet)
//     {
//         $highestColumn = $sheet->getHighestColumn();
//         $highestRow = $sheet->getHighestRow();

//         $styleArray = [
//             'borders' => [
//                 'allBorders' => [
//                     'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
//                     'color' => ['argb' => '000000'],
//                 ],
//             ],
//             'alignment' => [
//                 'wrapText' => true, // Set wrapText to true
//             ],
//         ];
//         $styleArray2 = [
//             'fill' => [
//                 'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
//                 'color' => ['argb' => 'DDDDDD'], // Kode warna abu-abu
//             ],
//         ];
//         $range = 'A1:' . $highestColumn . $highestRow;
//         $sheet->getStyle($range)->applyFromArray($styleArray);
//         $sheet->getStyle('A1:E1')->applyFromArray($styleArray2);
        
//          // Set column widths based on content length
//         foreach (range('A', $highestColumn) as $column) {
//             $sheet->getColumnDimension($column)->setAutoSize(true);
//         }
//     }

//     public function map($query): array
//     {
//         // Map data yang akan ditampilkan pada lembar kerja Excel
//         return [
//             $query->title,
//             $query->lesson_name,
//             $query->classroom_name,
//             $query->anggota_name,
//             $query->status_label,
//         ];
//     }

//     public function registerEvents(): array
//     {
//         // Hitung jumlah hadir, alpa, izin, dan sakit
//         $statusCounts = $this->statusCounts;

//         return [
//             AfterSheet::class => function (AfterSheet $event) use ($statusCounts) {
//                 // Dapatkan sel terakhir untuk menambahkan jumlah status
//                 $lastRow = $event->sheet->getHighestDataRow() + 1;

//                 // Tambahkan jumlah status ke lembar kerja
//                 $event->sheet->setCellValue("A$lastRow", 'Jumlah Hadir:');
//                 $event->sheet->setCellValue("B$lastRow", $statusCounts[1]);
//                 $event->sheet->setCellValue("A" . ($lastRow + 1), 'Jumlah Alpa:');
//                 $event->sheet->setCellValue("B" . ($lastRow + 1), $statusCounts[0]);
//                 $event->sheet->setCellValue("A" . ($lastRow + 2), 'Jumlah Izin:');
//                 $event->sheet->setCellValue("B" . ($lastRow + 2), $statusCounts[2]);
//                 $event->sheet->setCellValue("A" . ($lastRow + 3), 'Jumlah Sakit:');
//                 $event->sheet->setCellValue("B" . ($lastRow + 3), $statusCounts[3]);
//             },
//         ];
//     }
// }

// class PresenceRecap implements FromQuery, WithHeadings, WithStyles, WithMapping
// {
//     use Exportable;

//     private $id;

//     public function __construct($id)
//     {
//         $this->id = $id;
//     }

//     public function headings(): array
//     {
//         return [
//             'title',
//             'lesson_id',
//             'class_id',
//             'input_by',
//             'status',
//             'Jumlah Hadir',
//             'Jumlah Alpa',
//             'Jumlah Izin',
//             'Jumlah Sakit',
//         ];
//     }

//     public function query()
//     {
//         return DB::table('presences')
//             ->join('attendances', 'presences.attendance_id', '=', 'attendances.id') // Join dengan tabel attendances
//             ->join('classrooms', 'attendances.class_id', '=', 'classrooms.id') // Join dengan tabel classrooms
//             ->join('lessons', 'attendances.lesson_id', '=', 'lessons.id') // Join dengan tabel lessons
//             ->join('anggotas', 'presences.inputby_id', '=', 'anggotas.id') // Join dengan tabel lessons
//             ->where('presences.inputby_id', $this->id)
//             ->orderBy('presences.created_at', 'ASC'); // Sesuaikan dengan urutan yang Anda inginkan
            
//             $query->select(
//                 'attendances.title',
//                 'classrooms.name as classroom_name',
//                 'lessons.name as lesson_name',
//                 'anggotas.name as anggota_name',
//                 DB::raw('CASE
//                     WHEN presences.status = 2 THEN "Izin"
//                     WHEN presences.status = 3 THEN "Sakit"
//                     WHEN presences.status = 1 THEN "Hadir"
//                     ELSE "Alpa"
//                 END as status_label'),
//                 DB::raw($this->statusCounts['Hadir'] . ' as jumlah_hadir'),
//                 DB::raw($this->statusCounts['Alpa'] . ' as jumlah_alpa'),
//                 DB::raw($this->statusCounts['Izin'] . ' as jumlah_izin'),
//                 DB::raw($this->statusCounts['Sakit'] . ' as jumlah_sakit')
//             );
//            // Hitung jumlah status
//             $statusCounts = [
//                 'Alpa' => 0,
//                 'Hadir' => 0,
//                 'Izin' => 0,
//                 'Sakit' => 0,
//             ];

//             foreach ($query as $row) {
//                 $status = $row->status_label;
//                 if (array_key_exists($status, $statusCounts)) {
//                     $statusCounts[$status]++;
//                 }
//             }

//         // Simpan jumlah status dalam properti
//         $this->statusCounts = $statusCounts;

//         return $query;
//     }
//     public function styles(Worksheet $sheet)
//     {
//         $highestColumn = $sheet->getHighestColumn();
//         $highestRow = $sheet->getHighestRow();

//         $styleArray = [
//             'borders' => [
//                 'allBorders' => [
//                     'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
//                     'color' => ['argb' => '000000'],
//                 ],
//             ],
//             'alignment' => [
//                 'wrapText' => true, // Set wrapText to true
//             ],
//         ];
//         $styleArray2 = [
//             'fill' => [
//                 'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
//                 'color' => ['argb' => 'DDDDDD'], // Kode warna abu-abu
//             ],
//         ];
//         $range = 'A1:' . $highestColumn . $highestRow;
//         $sheet->getStyle($range)->applyFromArray($styleArray);
//         $sheet->getStyle('A1:E1')->applyFromArray($styleArray2);
        
//          // Set column widths based on content length
//         foreach (range('A', $highestColumn) as $column) {
//             $sheet->getColumnDimension($column)->setAutoSize(true);
//         }
//     }

//     public function map($row): array
//     {
//         // Map data yang akan ditampilkan pada lembar kerja Excel
//         return [
//             $row->title,
//             $row->lesson_id,
//             $row->class_id,
//             $row->inputby_id,
//             $row->status_label,
//             $row->jumlah_hadir,
//             $row->jumlah_alpa,
//             $row->jumlah_izin,
//             $row->jumlah_sakit,
//         ];
//     }
// }
