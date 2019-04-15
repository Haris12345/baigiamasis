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
        $groups_ft = DB::table('groups')
        ->leftJoin('study_plans_full_time', function($join){
            $join->on('groups.studies_program_code', '=', 'study_plans_full_time.studies_program_code');
            $join->on('groups.studies_form', '=', 'study_plans_full_time.studies_form');
        })
        ->groupBy('groups.studies_program_code')
        ->paginate(20);
        
        $groups_ex = DB::table('groups')
        ->leftJoin('study_plans_extended', function($join){
            $join->on('groups.studies_program_code', '=', 'study_plans_extended.studies_program_code');
            $join->on('groups.studies_form', '=', 'study_plans_extended.studies_form');
        })
        ->groupBy('groups.studies_program_code')
        ->paginate(20);
        return view('multiauth::admin.groups.index', compact('groups_ft', 'groups_ex', 'id'));
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
        $credits = array();
        $evaluation_type = array();

        $studies_program_code = $request->get('studies_plan');
        

        $year = substr($request->group_name, -2);
        $year = 2000 + (int)$year;

        if($studies_form == 'l'){
            $studies_program_code = substr($studies_program_code, 0, -2);
            $studies_form = 'Nuolatinė';
            for($i=1; $i<7; $i++){
                $query = DB::table('study_plans_full_time')
                ->select('subject_code', 'subject_name', 'subject_status', 'credits_sem'.$i, 'evaluation_type_sem'.$i)
                ->where('credits_sem'.$i, '!=', NULL, 'AND', 'studies_program_code', '=', $studies_program_code)
                ->get();

                $k = 0;
                foreach($query as $studies_plan){
                    if(isset($studies_plan->credits_sem1)){
                        array_push($credits, $studies_plan->credits_sem1);
                        array_push($evaluation_type, $studies_plan->evaluation_type_sem1);
                    }
                    if(isset($studies_plan->credits_sem2)){
                        array_push($credits, $studies_plan->credits_sem2);
                        array_push($evaluation_type, $studies_plan->evaluation_type_sem2);
                    }
                    if(isset($studies_plan->credits_sem3)){
                        array_push($credits, $studies_plan->credits_sem3);
                        array_push($evaluation_type, $studies_plan->evaluation_type_sem3);
                    }
                    if(isset($studies_plan->credits_sem4)){
                        array_push($credits, $studies_plan->credits_sem4);
                        array_push($evaluation_type, $studies_plan->evaluation_type_sem4);
                    }
                    if(isset($studies_plan->credits_sem5)){
                        array_push($credits, $studies_plan->credits_sem5);
                        array_push($evaluation_type, $studies_plan->evaluation_type_sem5);
                    }
                    if(isset($studies_plan->credits_sem6)){
                        array_push($credits, $studies_plan->credits_sem6);
                        array_push($evaluation_type, $studies_plan->evaluation_type_sem6);
                    }
                    DB::table('group_subjects')
                    ->insert([
                        'studies_program_code' => $studies_program_code,
                        'studies_form' => $studies_form,
                        'group' => $request->group_name,
                        'subject_code' => $studies_plan->subject_code,
                        'subject_name' => $studies_plan->subject_name,
                        'subject_status' => $studies_plan->subject_status,
                        'credits' => $credits[$k],
                        'evaluation_type' => $evaluation_type[$k],
                        'semester' => $i,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);
                    $k++;
                }
            }
        }
        if($studies_form == 'i'){
            $studies_program_code = substr($studies_program_code, 0, -1);
            $studies_form = 'Ištestinė';
            for($i=1; $i<7; $i++){
                $query = DB::table('study_plans_extended')
                ->select('subject_code', 'subject_name', 'subject_status', 'credits_sem'.$i, 'evaluation_type_sem'.$i)
                ->where('credits_sem'.$i, '!=', NULL, 'AND', 'studies_program_code', '=', $studies_program_code)
                ->get();

                $k = 0;
                foreach($query as $studies_plan){
                    if(isset($studies_plan->credits_sem1)){
                        array_push($credits, $studies_plan->credits_sem1);
                        array_push($evaluation_type, $studies_plan->evaluation_type_sem1);
                    }
                    if(isset($studies_plan->credits_sem2)){
                        array_push($credits, $studies_plan->credits_sem2);
                        array_push($evaluation_type, $studies_plan->evaluation_type_sem2);
                    }
                    if(isset($studies_plan->credits_sem3)){
                        array_push($credits, $studies_plan->credits_sem3);
                        array_push($evaluation_type, $studies_plan->evaluation_type_sem3);
                    }
                    if(isset($studies_plan->credits_sem4)){
                        array_push($credits, $studies_plan->credits_sem4);
                        array_push($evaluation_type, $studies_plan->evaluation_type_sem4);
                    }
                    if(isset($studies_plan->credits_sem5)){
                        array_push($credits, $studies_plan->credits_sem5);
                        array_push($evaluation_type, $studies_plan->evaluation_type_sem5);
                    }
                    if(isset($studies_plan->credits_sem6)){
                        array_push($credits, $studies_plan->credits_sem6);
                        array_push($evaluation_type, $studies_plan->evaluation_type_sem6);
                    }
                    if(isset($studies_plan->credits_sem7)){
                        array_push($credits, $studies_plan->credits_sem7);
                        array_push($evaluation_type, $studies_plan->evaluation_type_sem7);
                    }
                    if(isset($studies_plan->credits_sem8)){
                        array_push($credits, $studies_plan->credits_sem8);
                        array_push($evaluation_type, $studies_plan->evaluation_type_sem8);
                    }
                    DB::table('group_subjects')
                    ->insert([
                        'studies_program_code' => $studies_program_code,
                        'studies_form' => $studies_form,
                        'group' => $request->group_name,
                        'subject_code' => $studies_plan->subject_code,
                        'subject_name' => $studies_plan->subject_name,
                        'subject_status' => $studies_plan->subject_status,
                        'credits' => $credits[$k],
                        'evaluation_type' => $evaluation_type[$k],
                        'semester' => $i,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);
                    $k++;
                }
            }
        }

        DB::table('groups')->insert([
            'studies_program_code' => $studies_program_code,
            'group_name' => $request->group_name,
            'studies_form' => $studies_form,
            'students' => 0,
            'year' => $year,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        
        return back()->with('message', 'Grupė pridėta sėkmingai');
    }
   
}
