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
    
        return redirect()->route('admin.studies.upload')->with('message', 'Studijų planas pridėtas');
    }

    public function show($id, $studies_form){
        
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

        return view('multiauth::admin.studies.show', compact('id', 'study_plans', 'studies_form'));
    }

    public function new(){
        return view('multiauth::admin.studies.new');
    }

    public function create(Request $request){
        $count = count($request->semester);
        $m = 0;
        if($request->studies_form == 'Nuolatinė'){
            for($i=0; $i<$count; $i++){
                $subject_num = $m+1;
                $subject_num = sprintf("%02d", $subject_num);
                $subject_code = $request->studies_program_code_abrv . $subject_num;

                for($k=1; $k<7; $k++){
                    if($request->semester[$i] == $k){
                        $credits_string = 'credits_sem'.$k;
                        $evaluation_string = 'evaluation_type_sem'.$k;
                    }
                }
                
                if($request->id[$i] == 0){
                    DB::table('study_plans_full_time')
                    ->insert([
                        'studies_program_code' => $request->studies_program_code,
                        'studies_program_name' => $request->studies_program,
                        'studies_form' => $request->studies_form,
                        'subject_name' => $request->subject_name[$m],
                        'subject_code' => $subject_code,
                        'subject_status' => $request->subject_status[$m],
                        $credits_string => $request->credits[$i],
                        $evaluation_string => $request->evaluation_type[$i],
                        'ECTS_credits' => $request->credits[$i],
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);
                    $m++;
                }
                else{
                    $ects = DB::table('study_plans_full_time')
                    ->select('ECTS_credits')
                    ->where('subject_name', '=', $request->subject_name[$m-1])
                    ->first();
                    $ects = $ects->ECTS_credits + $request->credits[$i];
                    DB::table('study_plans_full_time')
                    ->where('subject_name', '=', $request->subject_name[$m-1])
                    ->update([
                        $credits_string => $request->credits[$i],
                        $evaluation_string => $request->evaluation_type[$i],
                        'ECTS_credits' => $ects
                    ]);
                }     
            } 
        }
        if($request->studies_form == 'Ištestinė'){
            for($i=0; $i<$count; $i++){
                $subject_num = $m+1;
                $subject_num = sprintf("%02d", $subject_num);
                $subject_code = $request->studies_program_code_abrv . $subject_num;

                for($k=1; $k<9; $k++){
                    if($request->semester[$i] == $k){
                        $credits_string = 'credits_sem'.$k;
                        $evaluation_string = 'evaluation_type_sem'.$k;
                    }
                }
                
                if($request->id[$i] == 0){
                    DB::table('study_plans_extended')
                    ->insert([
                        'studies_program_code' => $request->studies_program_code,
                        'studies_program_name' => $request->studies_program,
                        'studies_form' => $request->studies_form,
                        'subject_name' => $request->subject_name[$m],
                        'subject_code' => $subject_code,
                        'subject_status' => $request->subject_status[$m],
                        $credits_string => $request->credits[$i],
                        $evaluation_string => $request->evaluation_type[$i],
                        'ECTS_credits' => $request->credits[$i],
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);
                    $m++;
                }
                else{
                    $ects = DB::table('study_plans_extended')
                    ->select('ECTS_credits')
                    ->where('subject_name', '=', $request->subject_name[$m-1])
                    ->first();
                    $ects = $ects->ECTS_credits + $request->credits[$i];
                    DB::table('study_plans_extended')
                    ->where('subject_name', '=', $request->subject_name[$m-1])
                    ->update([
                        $credits_string => $request->credits[$i],
                        $evaluation_string => $request->evaluation_type[$i],
                        'ECTS_credits' => $ects
                    ]);
                }     
            } 
        }
        return back()->with('message', 'Studijų programa pridėta');
    }

    public function edit($id, $studies_form){
        if($studies_form == 'Nuolatinė'){
            $study_plans = DB::table('study_plans_full_time')
            ->where('studies_program_code', '=', $id)
            ->get();
        }
        if($studies_form == 'Ištestinė'){
            $study_plans = DB::table('study_plans_extended')
            ->where('studies_program_code', '=', $id)
            ->get();
        }
        
        return view('multiauth::admin.studies.edit', compact('id', 'studies_form', 'study_plans'));
    }

    public function update(Request $request){
        if($request->studies_form == "Nuolatinė"){
            $count = count($request->subject_code);
            for($i=0; $i<$count; $i++){
                DB::table('study_plans_full_time')
                ->where('subject_code', '=', $request->subject_code[$i])
                ->where('studies_program_code', '=', $request->studies_program_code)
                ->where('subject_name', '=', $request->subject[$i])
                ->update([
                    'credits_sem1' => $request->credits[0][$i],
                    'evaluation_type_sem1' => $request->evaluation[0][$i],
                    'credits_sem2' => $request->credits[1][$i],
                    'evaluation_type_sem2' => $request->evaluation[1][$i],
                    'credits_sem3' => $request->credits[2][$i],
                    'evaluation_type_sem3' => $request->evaluation[2][$i],
                    'credits_sem4' => $request->credits[3][$i],
                    'evaluation_type_sem4' => $request->evaluation[3][$i],
                    'credits_sem5' => $request->credits[4][$i],
                    'evaluation_type_sem5' => $request->evaluation[4][$i],
                    'credits_sem6' => $request->credits[5][$i],
                    'evaluation_type_sem6' => $request->evaluation[5][$i],
                    'updated_at' => Carbon::now()
                ]);
                $sum = 0;
                for($k=0; $k<6; $k++){
                    $sum += $request->credits[$k][$i];
                    if($request->credits[$k][$i] != NULL){
                        DB::table('group_subjects')
                        ->where('studies_program_code', '=', $request->studies_program_code)
                        ->where('studies_form', '=', $request->studies_form)
                        ->where('subject_code', '=', $request->subject_code[$i])
                        ->update([
                            'semester' => $k+1,
                            'credits' => $request->credits[$k][$i],
                            'evaluation_type' => $request->evaluation[$k][$i],
                            'updated_at' => Carbon::now()
                        ]);
                    }
                }
                DB::table('study_plans_full_time')
                ->where('subject_code', '=', $request->subject_code[$i])
                ->where('studies_program_code', '=', $request->studies_program_code)
                ->where('subject_name', '=', $request->subject[$i])
                ->update([
                    'ECTS_credits' => $sum
                ]);
            }       
        }
        if($request->studies_form == "Ištestinė"){
            $count = count($request->subject_code);
            for($i=0; $i<$count; $i++){
                DB::table('study_plans_extended')
                ->where('subject_code', '=', $request->subject_code[$i])
                ->where('studies_program_code', '=', $request->studies_program_code)
                ->where('subject_name', '=', $request->subject[$i])
                ->update([
                    'credits_sem1' => $request->credits[0][$i],
                    'evaluation_type_sem1' => $request->evaluation[0][$i],
                    'credits_sem2' => $request->credits[1][$i],
                    'evaluation_type_sem2' => $request->evaluation[1][$i],
                    'credits_sem3' => $request->credits[2][$i],
                    'evaluation_type_sem3' => $request->evaluation[2][$i],
                    'credits_sem4' => $request->credits[3][$i],
                    'evaluation_type_sem4' => $request->evaluation[3][$i],
                    'credits_sem5' => $request->credits[4][$i],
                    'evaluation_type_sem5' => $request->evaluation[4][$i],
                    'credits_sem6' => $request->credits[5][$i],
                    'evaluation_type_sem6' => $request->evaluation[5][$i],
                    'credits_sem7' => $request->credits[6][$i],
                    'evaluation_type_sem7' => $request->evaluation[6][$i],
                    'credits_sem8' => $request->credits[7][$i],
                    'evaluation_type_sem8' => $request->evaluation[7][$i],
                    'updated_at' => Carbon::now()
                ]);
            }
            $sum = 0;
            for($k=0; $k<8; $k++){
                $sum += $request->credits[$k][$i];
                if($request->credits[$k][$i] != NULL){
                    DB::table('group_subjects')
                    ->where('studies_program_code', '=', $request->studies_program_code)
                    ->where('studies_form', '=', $request->studies_form)
                    ->where('subject_name', '=', $request->subject[$i])
                    ->update([
                        'semester' => $k,
                        'credits' => $request->credits[$k][$i],
                        'evaluation_type' => $request->evaluation[$k][$i],
                        'updated_at' => Carbon::now()
                    ]);
                }
                DB::table('study_plans_extended')
                ->where('subject_code', '=', $request->subject_code[$i])
                ->where('studies_program_code', '=', $request->studies_program_code)
                ->where('subject_name', '=', $request->subject[$i])
                ->update([
                    'ECTS_credits' => $sum
                ]);
            }
        }
        return back()->with('message', 'Studijų planas pakoreguotas');
    }

    public function delete($studies_program_code, $studies_form){
        if($studies_form == 'Nuolatinė'){
            DB::table('study_plans_full_time')
            ->where('studies_program_code', '=', $studies_program_code)
            ->delete();

            DB::table('group_subjects')
            ->where('studies_program_code', '=', $studies_program_code)
            ->where('studies_form', '=', $studies_form)
            ->delete();
        }
        if($studies_form == 'Ištestinė'){
            DB::table('study_plans_extended')
            ->where('studies_program_code', '=', $studies_program_code)
            ->delete();

            DB::table('group_subjects')
            ->where('studies_program_code', '=', $studies_program_code)
            ->where('studies_form', '=', $studies_form)
            ->delete();
        }
        
        return redirect('/admin/studies');
    }

    public function downloadFt(){
        return response()->download(public_path('downloads/Nuolatinių studijų šablonas.xlsx'));
    }
    public function downloadEx(){
        return response()->download(public_path('downloads/Ištestinių studijų šablonas.xlsx'));
    }

    public function search(Request $request, $studies_program_code, $studies_form){
        $search = $request->get('search');
        if($studies_form == 'Nuolatinė'){
            $results = DB::table('study_plans_full_time')
            ->where('studies_program_code', '=', $studies_program_code)
            ->where('studies_form', '=', $studies_form)
            ->where('subject_name', 'like', '%' . $search . '%')
            ->orwhere('ECTS_credits', 'like', '%' . $search . '%')
            ->where('studies_program_code', '=', $studies_program_code)
            ->where('studies_form', '=', $studies_form)
            ->get();
        }
        if($studies_form == 'Ištestinė'){
            $results = DB::table('study_plans_extended')
            ->where('studies_program_code', '=', $studies_program_code)
            ->where('studies_form', '=', $studies_form)
            ->where('subject_name', 'like', '%' . $search . '%')
            ->orwhere('ECTS_credits', 'like', '%' . $search . '%')
            ->where('studies_program_code', '=', $studies_program_code)
            ->where('studies_form', '=', $studies_form)
            ->get();
        }
       
        return view('multiauth::admin.studies.show', ['id' => $studies_program_code, 'studies_form' => $studies_form, 'study_plans' => $results]);
    }

    public function editSearch(Request $request, $studies_program_code, $studies_form){
        $search = $request->get('search');
        if($studies_form == 'Nuolatinė'){
            $results = DB::table('study_plans_full_time')
            ->where('studies_program_code', '=', $studies_program_code)
            ->where('studies_form', '=', $studies_form)
            ->where('subject_name', 'like', '%' . $search . '%')
            ->orwhere('ECTS_credits', 'like', '%' . $search . '%')
            ->where('studies_program_code', '=', $studies_program_code)
            ->where('studies_form', '=', $studies_form)
            ->get();
        }
        if($studies_form == 'Ištestinė'){
            $results = DB::table('study_plans_extended')
            ->where('studies_program_code', '=', $studies_program_code)
            ->where('studies_form', '=', $studies_form)
            ->where('subject_name', 'like', '%' . $search . '%')
            ->orwhere('ECTS_credits', 'like', '%' . $search . '%')
            ->where('studies_program_code', '=', $studies_program_code)
            ->where('studies_form', '=', $studies_form)
            ->get();
        }

        return view('multiauth::admin.studies.edit', ['id' => $studies_program_code, 'studies_form' => $studies_form, 'study_plans' => $results]);
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