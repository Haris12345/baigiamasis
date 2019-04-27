<?php

namespace App\Imports;

use App\Teachers;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;

class TeachersImport implements ToCollection, WithStartRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function Collection(Collection $rows)
    {
        foreach($rows as $row){
            Teachers::create([
                'identity_code' => $row[0],
                'role' => $row[1],
                'name' => $row[2],
                'last_name' => $row[3]
            ]);
        }        
    }

    public function startRow(): int{
        return 3;
    }
}