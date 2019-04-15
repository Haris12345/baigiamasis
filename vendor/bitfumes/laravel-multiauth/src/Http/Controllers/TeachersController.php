<?php

namespace Bitfumes\Multiauth\Http\Controllers;

use Bitfumes\Multiauth\Model\Admin;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Teachers;
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
            'identity_code' => 'required',
            'role' => 'required',
            'name' => 'required',
            'last_name' => 'required',
        ]);

        DB::table('teachers')
        ->insert([
            'identity_code' => $request->identity_code,
            'role' => $request->role,
            'name' => $request->name,
            'last_name' => $request->last_name
        ]);

        return back()->with('message', 'Dėstytojas sėkmingai pridėtas');
    }

    public function upload(){
        
        return view('multiauth::admin.teachers.upload');
    }

    public function import(Request $request){
        $request->validate([
            'identity_code' => 'required',
            'role' => 'required',
            'name' => 'required',
            'last_name' => 'required',
        ]);

        $teachers = Excel::import(new Teachers(), $request->file('import'));
        return dd($teachers);
        return back()->with('message', 'Dėstytojai importuoti sėkmingai');
    }
}

