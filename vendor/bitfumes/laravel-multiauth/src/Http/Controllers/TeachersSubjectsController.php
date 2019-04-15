<?php

namespace Bitfumes\Multiauth\Http\Controllers;

use Bitfumes\Multiauth\Model\Admin;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class TeachersSubjectsController extends Controller
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
    
    public function get(){
        $teachers = DB::table('teachers')
        ->select('name', 'last_name')
        ->get();

        return $teachers;
    }

    public function index(Request $request, $group, $subject_code){
        DB::table('teachers_subjects')
        ->insert([
            'teacher_id' => $request->teacher_id,
            'group' => $group,
            'subject_code' =>  $subject_code
        ]);

        return back()->with('message', 'Dėstytojas priskirtas');
    }
}
