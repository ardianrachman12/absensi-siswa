<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data user yang akan diisi pada tabel 'users'
        $user1 = [
            'username' => 'admin1',
            'name' => 'admin',
            'role_id' => 1,
            'remember_token' => Str::random(10),
            'password' => Bcrypt('123'), // Menghash password menggunakan bcrypt
        ];

        // Memasukkan data ADMIN ke dalam tabel 'users'
        User::create($user1);
    }
}

