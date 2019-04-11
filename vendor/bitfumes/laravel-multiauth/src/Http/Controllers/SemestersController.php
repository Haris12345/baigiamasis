<?php

namespace Bitfumes\Multiauth\Http\Controllers;

use Bitfumes\Multiauth\Model\Admin;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\EvaluationProcedure;
use App\Imports\SemestersImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class SemestersController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->middleware('role:super', ['only'=>'show']);
    }
    
    public function import(Request $request){
        $studies = Excel::ToCollection(new SemestersImport(), $request->file('import_semesters'));
        foreach($studies[0] as $row){
            DB::table('evaluation_procedure')->insert([
                'studies_program_code' => $request->get('code'),
                'subject_code' => $row[0],
                'semester' => $row[1],
                'credits' => $row[2],
                'evaluation_type' => $row[3],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }
        return back()->with('message', 'Vertinimo tvarka sėkmingai pridėta');
    }
}
