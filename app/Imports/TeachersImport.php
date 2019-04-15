<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use App\Teachers;
use Maatwebsite\Excel\Concerns\WithStartRow;

class TeachersImport implements ToModel, WithStartRow
{
    /**
    * @param Collection $collection
    */
    public function model(array $row)
    {
        return new Teachers([
           'identity_code' => $row[0],
           'role' => $row[1],
           'name' => $row[2],
           'last_name' => $row[3]
        ]);
    }

    public function startRow(): int{
        return 3;
    }
}
