<?php

namespace App\Imports;

use App\StudyPlansExtended;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class StudyPlansExtendedImport implements ToModel, WithStartRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new StudyPlansFullTime([
            'subject_name' => $row[0],
            'subject_code' => $row[1],
            'subject_status' => $row[2],
            'credits_sem1' =>$row[3],
            'evaluation_type_sem1' => $row[4],
            'credits_sem2' => $row[5],
            'evaluation_type_sem2' => $row[6],
            'credits_sem3' => $row[7],
            'evaluation_type_sem3' => $row[8],
            'credits_sem4' => $row[9],
            'evaluation_type_sem4' => $row[10],
            'credits_sem5' => $row[11],
            'evaluation_type_sem5' => $row[12],
            'credits_sem6' => $row[13],
            'evaluation_type_sem6' => $row[14],
            'credits_sem7' => $row[15],
            'evaluation_type_sem7' => $row[16],
            'credits_sem8' => $row[17],
            'evaluation_type_sem8' => $row[18],
            'ECTS_credits' => $row[15],
        ]);
    }

    public function startRow(): int{
        return 3;
    }
}
