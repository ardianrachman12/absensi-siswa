<?php

namespace App\Imports;

use App\Models\Anggota;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SiswaImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    private $startRow = 2;

    public function model(array $row)
    {
        return new Anggota([
            'name'          => $row['name'],
            'username'      => $row['username'],
            'password'      => bcrypt($row['password']),
            'class_id'      => $row['class_id'],
            'remember_token'=> Str::random(10),
        ]);
    }

    public function startRow(): int
    {
        return $this->startRow;
    }
}
