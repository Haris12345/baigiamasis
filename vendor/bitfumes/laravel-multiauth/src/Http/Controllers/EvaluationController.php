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
    
    public function index($group, $id){
        $student = DB::table('students')
        ->where('id', '=', $id)
        ->first();
        $debts = array();
        $debts_credits = array();
        
        for($i=1; $i<9; $i++){
            $query = DB::table('exams')
            ->leftJoin('group_subjects', 'exams.subject_code', '=', 'group_subjects.subject_code')
            ->where('exams.student_id', '=', $id)
            ->where('exams.comments', '=', 'Skola')
            ->where('group_subjects.studies_form', '=', $student->studies_form)
            ->where('group_subjects.semester', '=', $i)
            ->count();

            array_push($debts, $query);
        }

        for($i=1; $i<9; $i++){
            $query = DB::table('exams')
            ->leftJoin('group_subjects', 'exams.subject_code', '=', 'group_subjects.subject_code')
            ->where('exams.student_id', '=', $id)
            ->where('exams.comments', '=', 'Skola')
            ->where('group_subjects.studies_form', '=', $student->studies_form)
            ->where('group_subjects.semester', '=', $i)
            ->sum('group_subjects.credits');

            array_push($debts_credits, $query);
        }         

        $credits = array();
        if($student->studies_form == 'Nuolatinė'){
            for($i=1; $i<7; $i++){
                $query = DB::table('group_subjects')
                ->where('group', '=', $group)
                ->where('semester', '=', $i)
                ->sum('credits');

                array_push($credits, $query);
            }         
        }
        
        if($student->studies_form == 'Ištestinė'){
            for($i=1; $i<9; $i++){
                $query = DB::table('group_subjects')
                ->where('group', '=', $group)
                ->where('semester', '=', $i)
                ->sum('credits');

                array_push($credits, $query);
            }         
        }

        return view('multiauth::admin.students.individual-evaluation.index', compact('group', 'id', 'credits', 'student', 'debts', 'debts_credits'));
    }

    public function show($group, $id, $semester){
        $teachers = DB::table('teachers')
        ->select('id', 'name', 'last_name')
        ->get();

        $student = DB::table('students')
        ->select('name', 'last_name')
        ->where('id', '=', $id)
        ->first();

        $exam = DB::table('exams')
        ->select('student_id')
        ->where('student_id', '=', $id)
        ->first();

        $subjects = DB::table('exams')    
            ->leftJoin('group_subjects', function($join){
                $join->on('exams.subject_code', '=', 'group_subjects.subject_code');
                $join->on('exams.group', '=', 'group_subjects.group');
                $join->on('exams.semester', '=', 'group_subjects.semester');
            })
            ->where('exams.semester', '=', $semester)
            ->where('exams.student_id', '=', $id)
            ->where('exams.group', '=', $group)
            ->get();



        $exams = DB::table('exams')
        ->where('student_id', '=', $id)
        ->get();

        return view('multiauth::admin.students.individual-evaluation.semester', compact('group', 'id', 'exams', 'subjects', 'semester', 'student', 'teachers'));
    }

    public function edit($group, $id, $semester, $subject_code){
        $teachers = DB::table('teachers')
        ->select('id', 'name', 'last_name')
        ->get();
        
        $student = DB::table('students')
        ->select('name', 'last_name')
        ->where('id', '=', $id)
        ->first();

        $exam = DB::table('exams')
        ->where('group', '=', $group)
        ->where('student_id', '=', $id)
        ->where('subject_code', '=', $subject_code)
        ->where('semester', '=', $semester)
        ->first();

        return view('multiauth::admin.students.individual-evaluation.edit', compact('exam', 'group', 'id', 'semester', 'subject_code', 'student', 'teachers'));
    }

    public function update(Request $request, $group, $id, $semester, $subject_code){
        $admin = auth('admin')->user()->name;
        $student = DB::table('students')
        ->select('name', 'last_name')
        ->where('id', '=', $id)
        ->first();
       
        DB::table('exams')
        ->where('student_id', '=', $id)
        ->where('subject_code', '=', $subject_code)
        ->where('semester', '=', $semester)
        ->update([
            'teacher_id' => $request->teacher_id,
            'mark' => $request->mark,
            'comments' => $request->comments,
            'evaluated_by' => $admin,
            'date' => $request->date
        ]);

        $subjects = DB::table('exams')    
            ->leftJoin('group_subjects', function($join){
                $join->on('exams.subject_code', '=', 'group_subjects.subject_code');
                $join->on('exams.group', '=', 'group_subjects.group');
            })
            ->where('group_subjects.semester', '=', $semester)
            ->where('exams.student_id', '=', $id)
            ->where('exams.group', '=', $group)
            ->get();

        return back()->with('message', 'Pažymys buvo pakeistas');
    }

    public function debt($group, $id, $semester, $subject_code){
        $student = DB::table('students')
        ->select('id', 'name', 'last_name')
        ->where('id', '=', $id)
        ->first();

        $exam = DB::table('exams')
        ->where('group', '=', $group)
        ->where('student_id', '=', $id)
        ->where('subject_code', '=', $subject_code)
        ->where('semester', '=', $semester)
        ->first();

        return view('multiauth::admin.students.individual-evaluation.debt', compact('group', 'id', 'semester', 'subject_code', 'student', 'exam'));
    }

    public function debtUpdate(Request $request){
        DB::table('exams')
        ->where('student_id', '=', $request->student_id)
        ->where('group', '=', $request->group)
        ->where('subject_code', '=', $request->subject_code)
        ->where('semester', '=', $request->semester)
        ->update([
            'debt_price' => $request->sum,
            'debt_paid' => $request->paid
        ]);

        return back()->with('message', 'Skolos duomenys atnaujinti');
    }
}
