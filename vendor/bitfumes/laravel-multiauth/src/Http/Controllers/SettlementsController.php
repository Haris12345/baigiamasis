<?php

namespace Bitfumes\Multiauth\Http\Controllers;

use Bitfumes\Multiauth\Model\Admin;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class SettlementsController extends Controller
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
    
    public function index($group){
        $teachers = DB::table('teachers')
        ->select('id', 'name', 'last_name')
        ->get();
        $subjects = DB::table('group_subjects')
        ->where('group', '=', $group)
        ->get();
        
        return view('multiauth::admin.settlements.index', compact('subjects', 'group', 'teachers'));
    }
    
    public function show(Request $request, $group, $subject_code){
        $studies_form = substr($group, -3, -2);
        $credits = $request->credits;
        $evaluation_type = $request->evaluation_type;
        $semester = $request->semester;
        if($studies_form == 'l'){
            $studies_form = 'Nuolatinė';
            $students = DB::table('students')
            ->select('name', 'last_name')
            ->where('group', '=', $group)
            ->get();

            $subject = DB::table('study_plans_full_time')
            ->where('subject_code', '=', $subject_code)
            ->first();
        }
        if($studies_form == 'i'){
            $studies_form = 'Ištestinė';
            $students = DB::table('students')
            ->select('name', 'last_name')
            ->where('group', '=', $group)
            ->get();

            $subject = DB::table('study_plans_extended')
            ->where('subject_code', '=', $subject_code)
            ->first();
        }
        $teacher = DB::table('group_subjects')
            ->select('teacher_id', 'teacher_name', 'teacher_last_name')
            ->where('teacher_id', '=', $request->teacher_id)
            ->first();
        $students = DB::table('students')
        ->select('id', 'name', 'last_name', 'identity_code')
        ->where('group', '=', $group)
        ->get();
        return view('multiauth::admin.settlements.show', compact('group', 'subject', 'credits', 'evaluation_type', 'semester', 'teacher', 'students'));
    }

    public function assignTeacher(Request $request, $subject_code){
        $teacher = DB::table('teachers')
        ->select('name', 'last_name')
        ->where('id', '=', $request->teacher_id)
        ->first();
        DB::table('group_subjects')
        ->where('subject_code', '=', $subject_code)
        ->update([
            'teacher_id' => $request->teacher_id,
            'teacher_name' => $teacher->name,
            'teacher_last_name' => $teacher->last_name
        ]);

        return back()->with('message', 'Dėstytojas priskirtas');
    }

    public function create(Request $request){
        $IDs = $request->get('student_id');
        $i = 0;
        foreach($IDs as $id){
            DB::table('exams')
            ->insert([
                'studies_program_code' => $request->studies_program_code,
                'subject_code' => $request->subject_code,
                'subject_name' => $request->subject_name,
                'teacher_id' => $request->teacher_id,
                'student_id' => $id,
                'group' => $request->group,
                'mark' => $request->mark[$i],
                'comments' => $request->comments[$i],
                'settlement_type' => $request->evaluation_type,
                'studies_form' => $request->studies_form,
                'date' => $request->date,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
            $i++;
        }
        return back()->with('message', 'Pažymiai įrašyti');
    }
}
