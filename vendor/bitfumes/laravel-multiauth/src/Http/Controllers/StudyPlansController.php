<?php

namespace Bitfumes\Multiauth\Http\Controllers;

use Bitfumes\Multiauth\Model\Admin;
use App\StudyPlansFullTime;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Imports\StudyPlansFullTimeImport;
use App\Imports\StudyPlansExtendedImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class StudyPlansController extends Controller
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
        $full_time = DB::select(DB::raw(" SELECT * FROM study_plans_full_time  WHERE id IN (
            SELECT MAX(id) FROM study_plans_full_time GROUP BY studies_program_code)"));
        $extended = DB::select(DB::raw(" SELECT * FROM study_plans_extended  WHERE id IN (
            SELECT MAX(id) FROM study_plans_extended GROUP BY studies_program_code)"));
        $id_ft = DB::table('study_plans_full_time')->first();
        $id_ex = DB::table('study_plans_extended')->first();

        return view('multiauth::admin.studies.index', compact('id_ft', 'id_ex', 'full_time', 'extended'));
    }
   
    public function upload(){
        return view('multiauth::admin.studies.upload');
    }

    public function import(Request $request){
        $studies_program = $request->get('studies_program');
        $studies_form = $request->get('studies_form');
        $studies_program_code = $request->get('studies_program_code');

        if($studies_form == 'Nuolatinė'){
            $studies = Excel::toCollection(new StudyPlansFullTimeImport(), $request->file('import'));
            foreach($studies[0] as $column){
                DB::table('study_plans_full_time')->insert([
                    'studies_program_code' => $studies_program_code,
                    'studies_program_name' => $studies_program,
                    'studies_form' => $studies_form,
                    'subject_name' => $column[0],
                    'subject_code' => $column[1],
                    'subject_status' => $column[2],
                    'credits_sem1' =>$column[3],
                    'evaluation_type_sem1' => $column[4],
                    'credits_sem2' => $column[5],
                    'evaluation_type_sem2' => $column[6],
                    'credits_sem3' => $column[7],
                    'evaluation_type_sem3' => $column[8],
                    'credits_sem4' => $column[9],
                    'evaluation_type_sem4' => $column[10],
                    'credits_sem5' => $column[11],
                    'evaluation_type_sem5' => $column[12],
                    'credits_sem6' => $column[13],
                    'evaluation_type_sem6' => $column[14],
                    'ECTS_credits' => $column[15],
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);
            }
        }
        if($studies_form == 'Ištestinė'){
            $studies = Excel::toCollection(new StudyPlansExtendedImport(), $request->file('import'));
            foreach($studies[0] as $column){
                DB::table('study_plans_extended')->insert([
                    'studies_program_code' => $studies_program_code,
                    'studies_program_name' => $studies_program,
                    'studies_form' => $studies_form,
                    'subject_name' => $column[0],
                    'subject_code' => $column[1],
                    'subject_status' => $column[2],
                    'credits_sem1' =>$column[3],
                    'evaluation_type_sem1' => $column[4],
                    'credits_sem2' => $column[5],
                    'evaluation_type_sem2' => $column[6],
                    'credits_sem3' => $column[7],
                    'evaluation_type_sem3' => $column[8],
                    'credits_sem4' => $column[9],
                    'evaluation_type_sem4' => $column[10],
                    'credits_sem5' => $column[11],
                    'evaluation_type_sem5' => $column[12],
                    'credits_sem6' => $column[13],
                    'evaluation_type_sem6' => $column[14],
                    'credits_sem7' => $column[15],
                    'evaluation_type_sem7' => $column[16],
                    'credits_sem8' => $column[17],
                    'evaluation_type_sem8' => $column[18],
                    'ECTS_credits' => $column[19],
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);
            }
        }
        else{
            return redirect()->route('admin.studies.upload');
        }
    
        return redirect()->route('admin.studies')->with('message', 'Studijų planas pridėtas');
    }

    public function show($id, $studies_form){
        
        //checking studies form
        if($studies_form == 'Nuolatinė'){
            $study_plans = DB::table('study_plans_full_time')
            ->where('studies_program_code', '=', $id)
            ->orderBy('subject_code', 'asc')
            ->get();
        }
        if($studies_form == 'Ištestinė'){
            $study_plans = DB::table('study_plans_extended')
            ->where('studies_program_code', '=', $id)
            ->orderBy('subject_code', 'asc')
            ->get();
        }

        return view('multiauth::admin.studies.show', compact('study_plans', 'studies_form'));
    }
}






























 // public function index(){
    //     $id = Study_programs::select('id')->first();
    //     $studies = Study_programs::orderBy('updated_at', 'desc')->paginate(30);
    //     return view('multiauth::admin.studies.index', compact('studies', 'id'));
    // }

    // public function new(){
    //     return view('multiauth::admin.studies.new');
    // }

    // public function create(Request $request){
    //     $request->validate([
    //         'study_program' => 'required',
    //         'study_form' => 'required',
    //         'study_program_abrv' => 'required',
    //     ]);

    //     $input = request()->all();
    //     $studies = Study_programs::create($input);

    //     return back()->with('message', 'Studijų programa sukurta sėkmingai');
    // }

    // public function delete($id){
    //     $studies = Study_programs::find($id);
    //     $studies->delete();
    //     $students = Students::where('study_program_id', '=', $id)->get();
        
    //     if ($students != null) {
    //         return $ids = explode(",", $students);
    //         $student = Students::whereIn('id', $ids)->delete();
    //         return redirect('/admin/studies')->with('message', 'Studijų programa buvo pašalinta iš duomenų bazės');
    //     }
    //     return redirect('/admin/studies')->with('message', 'Studijų programa buvo pašalinta iš duomenų bazės');
    // }