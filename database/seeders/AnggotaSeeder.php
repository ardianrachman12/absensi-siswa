<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Anggota;
use Illuminate\Support\Str;
use Carbon\Carbon; // Import class Carbon untuk mengatur waktu


class AnggotaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data user yang akan diisi pada tabel 'users'
        $siswa1 = [
            [
            'name' => 'user1',
            'username' => 'user1',
            'class_id' => 1,
            'role_id' => 3,
            'remember_token' => Str::random(10),
            'password' => Bcrypt('123'), // Menghash password menggunakan bcrypt
            'created_at' => Carbon::now(), // Tambahkan nilai waktu saat ini ke kolom created_at
            'updated_at' => Carbon::now(),
        ],
        [
            'name' => 'user2',
            'username' => 'user2',
            'class_id' => 1,
            'role_id' => 3,
            'remember_token' => Str::random(10),
            'password' => Bcrypt('123'), // Menghash password menggunakan bcrypt
            'created_at' => Carbon::now(), // Tambahkan nilai waktu saat ini ke kolom created_at
            'updated_at' => Carbon::now(),
        ],
        [
            'name' => 'user3',
            'username' => 'user3',
            'class_id' => 1,
            'role_id' => 3,
            'remember_token' => Str::random(10),
            'password' => Bcrypt('123'), // Menghash password menggunakan bcrypt
            'created_at' => Carbon::now(), // Tambahkan nilai waktu saat ini ke kolom created_at
            'updated_at' => Carbon::now(),
        ],
        [
            'name' => 'user4',
            'username' => 'user4',
            'class_id' => 1,
            'role_id' => 3,
            'remember_token' => Str::random(10),
            'password' => Bcrypt('123'), // Menghash password menggunakan bcrypt
            'created_at' => Carbon::now(), // Tambahkan nilai waktu saat ini ke kolom created_at
            'updated_at' => Carbon::now(),
        ],
    ];
    $siswa2 = [
        [
            'name' => 'user5',
            'username' => 'user5',
            'class_id' => 2,
            'role_id' => 3,
            'remember_token' => Str::random(10),
            'password' => Bcrypt('123'), // Menghash password menggunakan bcrypt
            'created_at' => Carbon::now(), // Tambahkan nilai waktu saat ini ke kolom created_at
            'updated_at' => Carbon::now(),
        ],
        
    ];
    $siswa3 = [
        [
            'name' => 'user6',
            'username' => 'user6',
            'class_id' => 3,
            'role_id' => 3,
            'remember_token' => Str::random(10),
            'password' => Bcrypt('123'), // Menghash password menggunakan bcrypt
            'created_at' => Carbon::now(), // Tambahkan nilai waktu saat ini ke kolom created_at
            'updated_at' => Carbon::now(),
        ],
        ];
        // Memasukkan data ADMIN ke dalam tabel 'users'
        Anggota::insert($siswa1);
        Anggota::insert($siswa2);
        Anggota::insert($siswa3);
    }
}
