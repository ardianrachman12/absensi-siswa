<?php

namespace App\Imports;

use App\Models\Classroom;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ClassroomImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    private $startRow = 2;
    public function model(array $row)
    {
        return new Classroom([
            'name' => $row['name'],
        ]);
    }
    
    public function startRow(): int
    {
        return $this->startRow;
    }

}
