<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class SummaryExport implements FromCollection, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use Exportable;

    private $summary;

    public function __construct($summary){
        $this->summary = $summary;
    }

    public function collection()
    {
        return collect([
            'summary' => $this->summary
        ]);
    }
}
