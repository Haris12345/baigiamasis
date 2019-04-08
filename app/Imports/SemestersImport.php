<?php

namespace App\Imports;

use App\EvaluationProcedure;
use Maatwebsite\Excel\Concerns\ToModel;

class SemestersImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new EvaluationProcedure([
            'subject_code' => $row[0],
            'semester' => $row[1],
            'credits' => $row[2],
            'evaluation_type' => $row[3],
        ]);
    }
}
