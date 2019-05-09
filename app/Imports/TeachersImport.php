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

    public function transformDate($value, $format = 'YYYY-mm-dd')
    {
        try {
            return \Carbon\Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value));
        } catch (\ErrorException $e) {
            return \Carbon\Carbon::createFromFormat($format, $value);
        }
    }
    public function Collection(Collection $rows)
    {
        foreach($rows as $row){
            Teachers::create([
                'birth_date' => $this->transformDate($row[0]),
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