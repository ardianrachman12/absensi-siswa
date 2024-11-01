<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Teacher;
use Illuminate\Support\Str;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $teacher = [
            'name' => 'guru1',
            'username' => 'guru1',
            'role_id' => 2,
            'remember_token' => Str::random(10),
            'password' => Bcrypt('123'), // Menghash password menggunakan bcrypt
        ];
        $teacher2 = [
            'name' => 'guru2',
            'username' => 'guru2',
            'role_id' => 2,
            'remember_token' => Str::random(10),
            'password' => Bcrypt('123'), // Menghash password menggunakan bcrypt
        ];

        Teacher::create($teacher);
        Teacher::create($teacher2);
    }
}
