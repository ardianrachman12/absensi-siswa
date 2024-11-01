<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Lesson;
use Carbon\Carbon;

class LessonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $lesson1 = [
            [
                'name' => 'BAHASA INGGRIS',
                'codeName' => 'BING',
                'class_id' => '1',
                'created_at' => Carbon::now(), // Tambahkan nilai waktu saat ini ke kolom created_at
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'BAHASA INDONESIA',
                'codeName' => 'BIND',
                'class_id' => '1',
                'created_at' => Carbon::now(), // Tambahkan nilai waktu saat ini ke kolom created_at
                'updated_at' => Carbon::now(),
                ]
                
            ];
            $lesson2 = [
                [
                    'name' => 'BAHASA JAWA',
                    'codeName' => 'BJAW',
                    'class_id' => '2',
                    'created_at' => Carbon::now(), // Tambahkan nilai waktu saat ini ke kolom created_at
                    'updated_at' => Carbon::now(),
                ],
                [
                    'name' => 'DESAIN WEB',
                    'codeName' => 'DWEB',
                    'class_id' => '2',
                    'created_at' => Carbon::now(), // Tambahkan nilai waktu saat ini ke kolom created_at
                    'updated_at' => Carbon::now(),
                    ]
                ];
            $lesson3 = [
                [
                    'name' => 'ILMU PENGETAHUAN ALAM',
                    'codeName' => 'IPA',
                    'class_id' => '3',
                    'created_at' => Carbon::now(), // Tambahkan nilai waktu saat ini ke kolom created_at
                    'updated_at' => Carbon::now(),
                ]
        ];

        Lesson::insert($lesson1);
        Lesson::insert($lesson2);
        Lesson::insert($lesson3);
    }

}
