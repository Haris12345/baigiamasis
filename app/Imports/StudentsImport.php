<?php

namespace App\Imports;

use App\Students;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;

class StudentsImport implements ToCollection, WithStartRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function Collection(Collection $rows)
    {
        foreach($rows as $row){
            Students::create([
                'studies_program_code' => $row[0],
                'group' => $row[1],
                'identity_code' => $row[2],
                'name' => $row[3],
                'last_name' => $row[4],
                'email' => $row[5]
            ]);
        }        
    }

    public function startRow(): int{
        return 3;
    }
}
