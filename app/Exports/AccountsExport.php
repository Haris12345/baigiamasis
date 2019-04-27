<?php

namespace App\Exports;

use App\Account;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class AccountsExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use Exportable;

    private $students;

    public function __construct($students){
        $this->students = $students;

    }

    public function collection(){
        return collect([
            'students' => $this->students
        ]);
    }

    public function headings(): array{
        return [
            'ID',
            'Vardas',
            'Pavardė',
            'El. paštas',
            'Slaptažodis'
        ];
    }
}
