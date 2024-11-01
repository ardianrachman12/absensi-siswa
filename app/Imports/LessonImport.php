<?php

namespace App\Imports;

use App\Models\Lesson;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class LessonImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    private $startRow = 2;

    public function model(array $row)
    {
        return new Lesson([
            'name'          => $row['name'],
            'codeName'      => $row['code'],
            'class_id'      => $row['class_id'],
        ]);
    }
    
    public function startRow(): int
    {
        return $this->startRow;
    }
}
