<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Classroom;

class ClassroomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $class1 = [
            'name' => 'X OTKP',
        ];
        $class2 = [
            'name' => 'X MM',
        ];
        $class3 = [
            'name' => 'X RPL',
        ];

        Classroom::create($class1);
        Classroom::create($class2);
        Classroom::create($class3);
    }
}
