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
        ->orderBy('semester', 'ASC')
        ->get();

        $exams = DB::table('exams')
        ->select('subject_code')
        ->where('group', '=', $group)
        ->get();
        
        return view('multiauth::admin.settlements.index', compact('exams', 'subjects', 'group', 'teachers'));
    }
    
    public function show(Request $request, $group, $subject_code){
        $studies_form = substr($group, -3, -2);
        $credits = $request->credits;
        $evaluation_type = $request->evaluation_type;
        $semester = $request->semester;

        $subject = DB::table('group_subjects')
        ->where('subject_code', '=', $subject_code)
        ->where('group', '=', $group)
        ->first();

        $teacher = DB::table('group_subjects')
            ->select('teacher_id', 'teacher_name', 'teacher_last_name')
            ->where('teacher_id', '=', $request->teacher_id)
            ->first();
        $students = DB::table('students')
        ->select('id', 'name', 'last_name', 'identity_code')
        ->where('group', '=', $group)
        ->where('status', '=', 'Studijuoja')
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

    public function showRetention(Request $request, $group, $subject_code){
        $studies_form = substr($group, -3, -2);
        $credits = $request->credits;
        $evaluation_type = $request->evaluation_type;
        $semester = $request->semester;

        $subject = DB::table('group_subjects')
        ->where('subject_code', '=', $subject_code)
        ->first();

        $teacher = DB::table('group_subjects')
        ->select('teacher_id', 'teacher_name', 'teacher_last_name')
        ->where('teacher_id', '=', $request->teacher_id)
        ->first();

        $students = DB::table('students')
        ->leftJoin('exams', 'students.id', '=', 'exams.student_id')
        ->select('students.id', 'students.identity_code', 'students.name', 'students.last_name', 'exams.group', 'exams.mark')
        ->where('exams.group', '=', $group)
        ->where('exams.comments', '=', 'Perlaikymas')
        ->where('exams.subject_code', '=', $subject_code)
        ->where('students.status', '=', 'Studijuoja')
        ->orwhere('exams.comments', '=', 'Skola')
        ->where('exams.group', '=', $group)
        ->where('exams.subject_code', '=', $subject_code)
        ->where('students.status', '=', 'Studijuoja')
        ->get();

        return view('multiauth::admin.settlements.showRetention', compact('group', 'subject', 'credits', 'evaluation_type', 'semester', 'teacher', 'students'));
    }

    public function print(Request $request){             
        $group = substr($request->group, 0, -2);
        $semester = $request->semester;
        $course = round($request->semester/2, 0);
        $teacher = DB::table('teachers')
        ->select('role', 'name', 'last_name')
        ->where('id', '=', $request->teacher_id)
        ->first();

        if($request->evaluation_type == 'egz.'){
            $evaluation = 'Egzaminas';
            $subject_name = $request->subject_name;   
        }
        if($request->evaluation_type == 'prj.'){
            $evaluation = 'Projektas';
            $subject_name = $request->subject_name . ' praktika';
        }

        switch($course){
            case 1:
                $course = 'I';
                break;
            case 2:
                $course = 'II';
                break;
            case 3:
                $course = 'III';
                break;
            case 4:
                $course = 'IV';
                break;
        }

        $date = $request->date;
        $year = substr($date, 0, 4);
        $students = array();

        foreach($request->student_id as $id){
            $student = DB::table('students')
            ->select('name', 'last_name')
            ->where('id', '=', $id)
            ->first();

            array_push($students, $student);
        }
        

        return view('multiauth::admin.settlements.print', compact('course', 'group', 'semester', 'teacher', 'evaluation', 'subject_name', 'date', 'year', 'students'));
    }

    public function assignSubject($group){
        $code = DB::table('group_subjects')
        ->select('studies_program_code')
        ->where('group', '=', $group)
        ->first();

        $studies_form = substr($group, -3, -2);
        if($studies_form == 'l'){
            $max = DB::table('study_plans_full_time')
            ->select('subject_code')
            ->where('studies_program_code', '=', $code->studies_program_code)
            ->orderBy('subject_code', 'DESC')
            ->first();
        }
        if($studies_form == 'i'){
            $max = DB::table('study_plans_extended')
            ->select('subject_code')
            ->where('studies_program_code', '=', $code->studies_program_code)
            ->orderBy('subject_code', 'DESC')
            ->first();
        }
        $subjects = DB::table('group_subjects')
        ->where('subject_code', '=', NULL)
        ->where('group', '=', $group)
        ->get();

        $assigned_subjects = DB::table('group_subjects')
        ->where('subject_code', '>', $max->subject_code)
        ->where('group', '=', $group)
        ->get();

        return view('multiauth::admin.settlements.assignSubject', compact('group', 'subjects', 'assigned_subjects'));
    }

    public function updateSubject(Request $request){
        
        if(isset($request->old_subject)){
            $studies_form = substr($request->group, -3, -2);
        
            if($studies_form == 'l'){
                $max = DB::table('study_plans_full_time')
                ->select('subject_code')
                ->where('studies_program_code', '=', $request->studies_program_code)
                ->orderBy('subject_code', 'DESC')
                ->first();
            }
            if($studies_form == 'i'){
                $max = DB::table('study_plans_extended')
                ->where('studies_program_code', '=', $request->studies_program_code)
                ->orderBy('subject_code', 'DESC')
                ->first();
            }
    
            $group_abrv = substr($max->subject_code, 0, -2);
            $max = substr($max->subject_code, -2);
            (int)$max++;
            $code = $group_abrv . $max;
            DB::table('group_subjects')
            ->where('subject_name', '=', $request->old_subject)
            ->where('group', '=', $request->group)
            ->update([
                'subject_name' => $request->subject,
                'subject_code' => $code,
                'evaluation_type' => $request->evaluation
            ]);
        }
        else{
            DB::table('group_subjects')
            ->where('subject_code', '=', $request->subject_code)
            ->where('group', '=', $request->group)
            ->update([
                'subject_name' => $request->subject,
                'credits' => $request->credits,
                'semester' => $request->semester,
                'evaluation_type' => $request->evaluation,
            ]);
        }
            
        return back()->with('message', 'Dalykas buvo atnaujintas');
    }

    public function update(Request $request){
        $IDs = $request->get('student_id');
        $i = 0;
        foreach($IDs as $id){
            DB::table('exams')
            ->where('student_id', '=', $id)
            ->update([
                'mark' => $request->mark[$i],
                'comments' => $request->comments[$i],
                'updated_at' => Carbon::now(),
            ]);
            $i++;
        }
        return back()->with('message', 'Pažymiai atnaujinti');
    }
}
