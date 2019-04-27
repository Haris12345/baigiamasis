<?php

namespace Bitfumes\Multiauth\Http\Controllers;

use Bitfumes\Multiauth\Model\Admin;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class GroupsController extends Controller
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

    public function index(){
        $id = DB::table('groups')->select('id')->first();
        $groups = DB::table('groups')
        ->select('groups.studies_program_code', 'groups.group_name', 'groups.students', 'groups.studies_form', 'study_plans_full_time.studies_program_name AS program_name_ft', 'study_plans_extended.studies_program_name AS program_name_ex')
        ->leftJoin('study_plans_extended', 'groups.studies_program_code', 'study_plans_extended.studies_program_code')
        ->leftJoin('study_plans_full_time', 'groups.studies_program_code', 'study_plans_full_time.studies_program_code')
        ->groupBy('groups.id')
        ->paginate(20);

        return view('multiauth::admin.groups.index', compact('groups', 'id'));
    }

    public function new(){
        $studies_program_ft = DB::table('study_plans_full_time')->groupBy('studies_program_code')->get();
        $studies_program_ex = DB::table('study_plans_extended')->groupBy('studies_program_code')->get();
        
        return view('multiauth::admin.groups.new', compact('studies_program_ft', 'studies_program_ex'));
    }

    public function create(Request $request){
        $request->validate([
            'group_name' => 'required',
            'studies_plan' => 'required',
        ]);
        
        $studies_form = $request->get('studies_plan');
        $studies_form = substr($studies_form, -1);

        $studies_program_code = $request->get('studies_plan');
        

        $year = substr($request->group_name, -2);
        $year = 2000 + (int)$year;

        if($studies_form == 'l'){
            $studies_program_code = substr($studies_program_code, 0, -2);
            $studies_form = 'Nuolatinė';
            for($i=1; $i<7; $i++){
                $query = DB::table('study_plans_full_time')
                ->select('subject_code', 'subject_name', 'subject_status', 'credits_sem'.$i, 'evaluation_type_sem'.$i)
                ->where('credits_sem'.$i, '!=', NULL)
                ->where('studies_program_code', '=', $studies_program_code)
                ->get();
                
                foreach($query as $studies_plan){
                    if(isset($studies_plan->credits_sem1)){
                        $credits = $studies_plan->credits_sem1;
                        $evaluation_type = $studies_plan->evaluation_type_sem1;
                    }
                    if(isset($studies_plan->credits_sem2)){
                        $credits = $studies_plan->credits_sem2;
                        $evaluation_type = $studies_plan->evaluation_type_sem2;
                    }
                    if(isset($studies_plan->credits_sem3)){
                        $credits = $studies_plan->credits_sem3;
                        $evaluation_type = $studies_plan->evaluation_type_sem3;
                    }
                    if(isset($studies_plan->credits_sem4)){
                        $credits = $studies_plan->credits_sem4;
                        $evaluation_type = $studies_plan->evaluation_type_sem4;
                    }
                    if(isset($studies_plan->credits_sem5)){
                        $credits = $studies_plan->credits_sem5;
                        $evaluation_type = $studies_plan->evaluation_type_sem5;
                    }
                    if(isset($studies_plan->credits_sem6)){
                        $credits = $studies_plan->credits_sem6;
                        $evaluation_type = $studies_plan->evaluation_type_sem6;
                    }
                    DB::table('group_subjects')
                    ->insert([
                        'studies_program_code' => $studies_program_code,
                        'studies_form' => $studies_form,
                        'group' => $request->group_name,
                        'subject_code' => $studies_plan->subject_code,
                        'subject_name' => $studies_plan->subject_name,
                        'subject_status' => $studies_plan->subject_status,
                        'credits' => $credits,
                        'evaluation_type' => $evaluation_type,
                        'semester' => $i,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);
                }
            }
        }
        if($studies_form == 'i'){
            $studies_program_code = substr($studies_program_code, 0, -1);
            $studies_form = 'Ištestinė';
            for($i=1; $i<9; $i++){
                $query = DB::table('study_plans_extended')
                ->select('subject_code', 'subject_name', 'subject_status', 'credits_sem'.$i, 'evaluation_type_sem'.$i)
                ->where('credits_sem'.$i, '!=', NULL)
                ->where('studies_program_code', '=', $studies_program_code)
                ->get();

                foreach($query as $studies_plan){
                    if(isset($studies_plan->credits_sem1)){
                        $credits = $studies_plan->credits_sem1;
                        $evaluation_type = $studies_plan->evaluation_type_sem1;
                    }
                    if(isset($studies_plan->credits_sem2)){
                        $credits = $studies_plan->credits_sem2;
                        $evaluation_type = $studies_plan->evaluation_type_sem2;
                    }
                    if(isset($studies_plan->credits_sem3)){
                        $credits = $studies_plan->credits_sem3;
                        $evaluation_type = $studies_plan->evaluation_type_sem3;
                    }
                    if(isset($studies_plan->credits_sem4)){
                        $credits = $studies_plan->credits_sem4;
                        $evaluation_type = $studies_plan->evaluation_type_sem4;
                    }
                    if(isset($studies_plan->credits_sem5)){
                        $credits = $studies_plan->credits_sem5;
                        $evaluation_type = $studies_plan->evaluation_type_sem5;
                    }
                    if(isset($studies_plan->credits_sem6)){
                        $credits = $studies_plan->credits_sem6;
                        $evaluation_type = $studies_plan->evaluation_type_sem6;
                    }
                    if(isset($studies_plan->credits_sem7)){
                        $credits = $studies_plan->credits_sem7;
                        $evaluation_type = $studies_plan->evaluation_type_sem7;
                    }
                    if(isset($studies_plan->credits_sem8)){
                        $credits = $studies_plan->credits_sem8;
                        $evaluation_type = $studies_plan->evaluation_type_sem8;
                    }
                    DB::table('group_subjects')
                    ->insert([
                        'studies_program_code' => $studies_program_code,
                        'studies_form' => $studies_form,
                        'group' => $request->group_name,
                        'subject_code' => $studies_plan->subject_code,
                        'subject_name' => $studies_plan->subject_name,
                        'subject_status' => $studies_plan->subject_status,
                        'credits' => $credits,
                        'evaluation_type' => $evaluation_type,
                        'semester' => $i,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);
                }
            }
        }
        $students = DB::table('students')
        ->select('id')
        ->where('group', '=', $request->group_name)
        ->get();

        if(isset($students->id)){
            $students = count($students->id);
        }
        else{
            $students = 0;
        }
       
        DB::table('groups')->insert([
            'studies_program_code' => $studies_program_code,
            'group_name' => $request->group_name,
            'studies_form' => $studies_form,
            'students' => $students,
            'year' => $year,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        
        return back()->with('message', 'Grupė pridėta sėkmingai');
    }
   
    public function search(Request $request){
        $search = $request->get('search');
        $id = DB::table('groups')->select('id')->first();
        $results = DB::table('groups')
        ->select('groups.studies_program_code', 'groups.group_name', 'groups.students', 'groups.studies_form', 'study_plans_full_time.studies_program_name AS program_name_ft', 'study_plans_extended.studies_program_name AS program_name_ex')
        ->leftJoin('study_plans_extended', 'groups.studies_program_code', 'study_plans_extended.studies_program_code')
        ->leftJoin('study_plans_full_time', 'groups.studies_program_code', 'study_plans_full_time.studies_program_code')
        ->where('groups.group_name', 'like', '%' . $search . '%')
        ->orwhere('groups.studies_program_code', 'like', '%' . $search . '%')
        ->orwhere('groups.studies_form', 'like', '%' . $search . '%')
        ->orwhere('study_plans_full_time.studies_program_name', 'like', '%' . $search . '%')
        ->orwhere('study_plans_extended.studies_program_name', 'like', '%' . $search . '%')
        ->groupBy('groups.id')
        ->paginate(20);

        return view('multiauth::admin.groups.index', ['groups' => $results, 'id' => $id]);
    }
}
