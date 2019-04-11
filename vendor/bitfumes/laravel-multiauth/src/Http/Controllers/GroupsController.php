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
        $studies_form = substr($studies_form, -2);
        
        if($studies_form == 'nl'){
            $studies_form = 'Nuolatinė';
        }
        if($studies_form == 'ii'){
            $studies_form = 'Ištestinė';
        }

        $studies_program_code = $request->get('studies_plan');
        $studies_program_code = substr($studies_program_code, 0, -2);

        $year = substr($request->group_name, -2);
        $year = 2000 + (int)$year;

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
