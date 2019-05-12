<?php

namespace Bitfumes\Multiauth\Http\Controllers;

use Bitfumes\Multiauth\Model\Admin;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Exports\SummaryExport;
use Illuminate\Support\Collection;

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
        ->where('subject_code', '!=', NULL)
        ->orderBy('semester', 'ASC')
        ->get();

        $exams = DB::table('exams')
        ->select('subject_code', 'semester')
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

        $status = DB::table('group_subjects')
        ->select('subject_status')
        ->where('subject_code', '=', $subject_code)
        ->where('group', '=', $group)
        ->where('subject_status', 'like', '%[%')
        ->first();

        if(isset($status)){
            $decoded = json_decode($status->subject_status, true);
            $students = array();
            foreach($decoded as $id){
                $student = DB::table('students')
                ->select('id', 'name', 'last_name', 'identity_code')
                ->where('id', '=', $id)
                ->where('group', '=', $group)
                ->where('status', '=', 'Studijuoja')
                ->orwhere('group', '=', $group)
                ->where('id', '=', $id)
                ->where('status', '=', 'Išvykęs į dalines studijas')
                ->orwhere('group', '=', $group)
                ->where('id', '=', $id)
                ->where('status', '=', 'Pertrauktos studijos')
                ->first();
                if($student != NULL){
                    array_push($students, $student);
                }  
            }
            $students = collect($students);
        }
        else{
            $students = DB::table('students')
            ->select('id', 'name', 'last_name', 'identity_code')
            ->where('group', '=', $group)
            ->where('status', '=', 'Studijuoja')
            ->orwhere('group', '=', $group)
            ->where('status', '=', 'Išvykęs į dalines studijas')
            ->orwhere('group', '=', $group)
            ->where('status', '=', 'Pertrauktos studijos')
            ->get();
        }
       
        return view('multiauth::admin.settlements.show', compact('group', 'subject', 'credits', 'evaluation_type', 'semester', 'teacher', 'students'));
    }

    public function assignTeacher(Request $request, $subject_code, $semester){
        $teacher = DB::table('teachers')
        ->select('name', 'last_name')
        ->where('id', '=', $request->teacher_id)
        ->first();

        if($request->teacher_id == "Nepriskirtas"){
            return back()->with('error', 'Nepriskirtas joks dėstytojas');
        }

        DB::table('group_subjects')
        ->where('subject_code', '=', $subject_code)
        ->where('semester', '=', $semester)
        ->update([
            'teacher_id' => $request->teacher_id,
            'teacher_name' => $teacher->name,
            'teacher_last_name' => $teacher->last_name
        ]);

        return back()->with('message', 'Dėstytojas priskirtas');
    }

    public function create(Request $request){
        $admin = auth('admin')->user()->name;
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
                'semester' => $request->semester,
                'mark' => $request->mark[$i],
                'comments' => $request->comments[$i],
                'settlement_type' => $request->evaluation_type,
                'studies_form' => $request->studies_form,
                'date' => $request->date,
                'evaluated_by' => $admin,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
            $i++;
        }
        $group = $request->group;
        
        return redirect(route('admin.settlements', $group))->with('message', 'Pažymiai buvo įrašyti');
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

        $status = DB::table('group_subjects')
        ->select('subject_status')
        ->where('subject_code', '=', $subject_code)
        ->where('group', '=', $group)
        ->where('subject_status', 'like', '%[%')
        ->first();

        if(isset($status)){
            $decoded = json_decode($status->subject_status, true);
            $students = array();
            foreach($decoded as $id){
                $student = DB::table('students')
                ->leftJoin('exams', 'students.id', '=', 'exams.student_id')
                ->select('students.id', 'students.identity_code', 'students.name', 'students.last_name', 'exams.group', 'exams.mark')
                ->where('exams.group', '=', $group)
                ->where('exams.comments', '=', 'Perlaikymas')
                ->where('exams.subject_code', '=', $subject_code)
                ->where('students.status', '=', 'Studijuoja')
                ->where('students.id', '=', $id)
                ->orwhere('exams.comments', '=', 'Skola')
                ->where('exams.group', '=', $group)
                ->where('exams.subject_code', '=', $subject_code)
                ->where('students.status', '=', 'Studijuoja')
                ->where('students.id', '=', $id)
                ->first();

                if($student != NULL){
                    array_push($students, $student);
                }  
            }
            $students = collect($students);
        }
        else{
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
        }

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

        if($request->evaluation_type == 'prj.'){
            $evaluation = 'Projektas';
            $subject_name = $request->subject_name . ' praktika';
        }
        else{
            $evaluation = 'Egzaminas';
            $subject_name = $request->subject_name;
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
        $students = DB::table('students')
        ->select('id', 'name', 'last_name')
        ->where('group', '=', $group)
        ->get();

        $code = DB::table('group_subjects')
        ->select('studies_program_code')
        ->where('group', '=', $group)
        ->first();
            
        $studies_form = substr($group, -3, -2);
        if($studies_form == 'l'){
            $studies_form = "Nuolatinė";
            $not_assigned = DB::table('study_plans_full_time')
            ->select('subject_code')
            ->where('studies_program_code', '=', $code->studies_program_code)
            ->orderBy('subject_code', 'DESC')
            ->first();
        }
        if($studies_form == 'i'){
            $studies_form == "Ištestinė";
            $not_assigned = DB::table('study_plans_extended')
            ->select('subject_code')
            ->where('studies_program_code', '=', $code->studies_program_code)
            ->orderBy('subject_code', 'DESC')
            ->first();
        }
        $max = DB::table('group_subjects')
        ->select('subject_code')
        ->where('studies_program_code', '=', $code->studies_program_code)
        ->where('studies_form', '=', $studies_form)
        ->orderBy('subject_code', 'DESC')
        ->first();

        $subjects = DB::table('group_subjects')
        ->where('subject_code', '=', NULL)
        ->where('group', '=', $group)
        ->get();

        $assigned_subjects = DB::table('group_subjects')
        ->where('subject_code', '>', $not_assigned->subject_code)
        ->where('group', '=', $group)
        ->get();

        return view('multiauth::admin.settlements.assignSubject', compact('students', 'group', 'subjects', 'assigned_subjects'));
    }

    public function updateSubject(Request $request){
        if(isset($request->old_subject)){

            $studies_form_abrv = substr($request->group, -3, -2);
            if($studies_form_abrv == 'l'){
                $studies_form = 'NUolatinė';
            }
            if($studies_form_abrv == 'i'){
                $studies_form = 'Ištestinė';
            }
            $max = DB::table('group_subjects')
            ->where('studies_program_code', '=', $request->studies_program_code)
            ->orderBy('subject_code', 'DESC')
            ->first();

            $students = json_encode($request->student, true);
            $group_abrv = substr($max->subject_code, 0, -2);
            $max = substr($max->subject_code, -2);
            (int)$max++;
            $code = $group_abrv . $max;
            DB::table('group_subjects')
            ->where('subject_name', '=', $request->old_subject)
            ->where('group', '=', $request->group)
            ->insert([
                'studies_program_code' => $request->studies_program_code,
                'studies_form' => $studies_form,
                'group' => $request->group,
                'subject_status' => $students,
                'subject_name' => $request->subject,
                'subject_code' => $code,
                'semester' => $request->semester,
                'credits' => $request->credits,
                'evaluation_type' => $request->evaluation,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
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

        return back()->with('message', 'Pasirenkamųjų dalykų sąrašas buvo atnaujintas');
    }

    public function update(Request $request){
        // $admin = auth('admin')->user()->name;
        // $student = DB::table('students')
        // ->select('name', 'last_name')
        // ->where('id', '=', $id)
        // ->first();
       
        // DB::table('exams')
        // ->where('student_id', '=', $id)
        // ->where('subject_code', '=', $subject_code)
        // ->where('semester', '=', $semester)
        // ->update([
        //     'teacher_id' => $request->teacher_id,
        //     'mark' => $request->mark,
        //     'comments' => $request->comments,
        //     'evaluated_by' => $admin,
        //     'date' => $request->date
        // ]);

        // $subjects = DB::table('exams')    
        //     ->leftJoin('group_subjects', function($join){
        //         $join->on('exams.subject_code', '=', 'group_subjects.subject_code');
        //         $join->on('exams.group', '=', 'group_subjects.group');
        //     })
        //     ->where('group_subjects.semester', '=', $semester)
        //     ->where('exams.student_id', '=', $id)
        //     ->where('exams.group', '=', $group)
        //     ->get();
        
        
        $admin = auth('admin')->user()->name;
        $IDs = $request->get('student_id');
        $i = 0;
        foreach($IDs as $id){
            DB::table('exams')
            ->where('student_id', '=', $id)
            ->where('subject_code', '=', $request->subject_code)
            ->where('studies_program_code', '=', $request->studies_program_code)
            ->where('studies_form', '=', $request->studies_form)
            ->where('semester', '=', $request->semester)
            ->update([
                'mark' => $request->mark[$i],
                'comments' => $request->comments[$i],
                'evaluated_by' => $admin,
                'updated_at' => Carbon::now(),
            ]);
            $i++;
        }
        $group = $request->group;
        
        return redirect(route('admin.settlements', $group))->with('message', 'Pažymiai buvo įrašyti');
    }

    public function deleteSubject($subject, $group){
        DB::table('group_subjects')
        ->where('subject_code', '=', $subject)
        ->where('group', '=', $group)
        ->delete();

        return back()->with('message', 'Dalykas buvo ištrintas');
    }

    public function summary($group){
        $subjects = DB::table('group_subjects')
        ->select('studies_program_code', 'semester', 'subject_code', 'group', 'credits', 'subject_name')
        ->orderBy('semester')
        ->where('group', '=', $group)
        ->where('subject_code', '!=', NULL)
        ->get();

        if(substr($subjects[0]->group, -3, -2) == 'l'){
            $studies_form = 'Nuolatinė';
            $studies_program_name = DB::table('study_plans_full_time')
            ->select('studies_program_name')
            ->where('studies_program_code', '=', $subjects[0]->studies_program_code)
            ->where('studies_form', '=', $studies_form)
            ->first();
        }
        if(substr($subjects[0]->group, -3, -2) == 'i'){
            $studies_form = 'Ištestinė';
            $studies_program_name = DB::table('study_plans_extended')
            ->select('studies_program_name')
            ->where('studies_program_code', '=', $subjects[0]->studies_program_code)
            ->where('studies_form', '=', $studies_form)
            ->first();
        }

        $students = DB::table('students')
        ->select('id', 'name', 'last_name')
        ->where('group', '=', $group)
        ->groupBy('id')
        ->get();
        
        $all_exams =  DB::table('exams')
        ->select('mark', 'subject_code', 'semester', 'student_id')
        ->where('group', '=', $group)
        ->get();

        $average = array();
        foreach($students as $student){
            $quantity = DB::table('exams')
            ->where('group', '=', $group)
            ->where('student_id', '=', $student->id)
            ->count();

            
            $student_marks = 0;
            foreach($subjects as $subject){
                $student_mark = DB::table('exams')
                ->select('mark')
                ->where('group', '=', $group)
                ->where('student_id', '=', $student->id)
                ->where('semester', '=', $subject->semester)
                ->where('subject_code', '=', $subject->subject_code)
                ->first();

                if(isset($student_mark->mark)){
                    if(substr($student_mark->mark, 0, 2) != 'Ne'){
                        $student_marks = (int)$student_marks + (int)substr($student_mark->mark, 0, 2) * (int)$subject->credits;
                    }      
                } 
            }

            if($quantity > 0){
                $student_marks = round($student_marks / $quantity, 2);
                array_push($average, $student_marks);
            }          
        }
     
        return view('multiauth::admin.settlements.summary', compact('studies_program_name', 'all_exams', 'subjects', 'exams', 'students', 'average'));
    }
}
