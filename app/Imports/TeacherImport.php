<?php

namespace App\Imports;

use App\Models\Teacher;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TeacherImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    private $startRow = 2;

    public function model(array $row)
    {
        return new Teacher([
            'name'          => $row['name'],
            'username'      => $row['username'],
            'password'      => bcrypt($row['password']),
            'remember_token'=> Str::random(10),
        ]);
    }

    public function startRow(): int
    {
        return $this->startRow;
    }
}
