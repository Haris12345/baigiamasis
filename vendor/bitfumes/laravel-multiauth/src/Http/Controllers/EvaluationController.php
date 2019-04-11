<?php

namespace Bitfumes\Multiauth\Http\Controllers;

use Bitfumes\Multiauth\Model\Admin;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class EvaluationController extends Controller
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
    
    public function index($id){
        $student = DB::table('students')
        ->where('id', '=', $id)
        ->first();

        if($student->studies_form == 'Nuolatinė'){
            $semesters = DB::table('study_plans_full_time')
            ->where('studies_program_code', '=', $student->studies_program_code)
            ->get();
        }
        if($student->studies_form == 'Ištestinė'){
            $semesters = DB::table('study_plans_extended')
            ->where('studies_program_code', '=', $student->studies_program_code)
            ->get();
        }
       
        return view('multiauth::admin.students.individual-evaluation.index', compact('id', 'semesters', 'student'));
    }

    public function show($id, $semester){
        $student = DB::table('students')
        ->where('id', '=', $id)
        ->first();

        return view('multiauth::admin.students.individual-evaluation.semester', compact('id', 'semester', 'student'));
    }
}
