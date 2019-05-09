<?php

namespace Bitfumes\Multiauth\Http\Controllers;

use Bitfumes\Multiauth\Model\Admin;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Teachers;
use App\Imports\TeachersImport;
use Illuminate\Support\Carbon;

class TeachersController extends Controller
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
        $teachers = DB::table('teachers')->get();
        return view('multiauth::admin.teachers.index')->with('teachers', $teachers);
    }

    public function new(){
        return view('multiauth::admin.teachers.new');
    }

    public function create(Request $request){
        $request->validate([
            'birth_date' => 'required',
            'role' => 'required',
            'name' => 'required',
            'last_name' => 'required',
        ]);
        
        DB::table('teachers')
        ->insert([
            'birth_date' => $request->birth_date,
            'role' => $request->role,
            'name' => $request->name,
            'last_name' => $request->last_name,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        return back()->with('message', 'Dėstytojas sėkmingai pridėtas');
    }

    public function upload(){
        
        return view('multiauth::admin.teachers.upload');
    }

    public function import(Request $request){
        if($request->hasFile('import')){
            $teachers = Excel::toCollection(new TeachersImport(), $request->file('import'));
           
            foreach($teachers[0] as $column){
                $birth_date = substr($column[0], 3, -3);
                DB::table('teachers')->insert([
                    'birth_date' => $birth_date,
                    'role' => $column[1],
                    'name' => $column[2],
                    'last_name' => $column[3],
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);
            }
            return back()->with('message', 'Dėstytojai importuoti');
        }  
    }

    public function download(){
        return response()->download(public_path('downloads/Dėstytojų šablonas.xlsx'));
    }

    public function search(Request $request){
        $search = $request->get('search');
        $results = DB::table('teachers')
        ->where('name', 'like', '%' . $search . '%')
        ->orwhere('last_name', 'like', '%' . $search . '%')
        ->orwhere('birth_date', 'like', '%' . $search . '%')
        ->orwhere('role', 'like', '%' . $search . '%')
        ->paginate(30);

        return view('multiauth::admin.teachers.index', ['teachers' => $results]);
    }
}

