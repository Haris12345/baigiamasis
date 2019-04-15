<?php

namespace Bitfumes\Multiauth\Http\Controllers;

use Bitfumes\Multiauth\Model\Admin;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class AccountsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        $this->middleware('auth:admin');
        $this->middleware('role:super', ['only'=>'show']);
    }

   

    public function index($id){
        $acc = DB::table('users')
        ->select('id')
        ->where('id', '=', $id)
        ->first();

        if(isset($acc)){
            $student = 'SET';
        }
        else{
            $student = DB::table('students')
            ->select('id', 'identity_code', 'name', 'last_name', 'email')
            ->where('id', '=', $id)
            ->first();
        }

        return view('multiauth::admin.students.account')->with('student', $student);
    }

    public function create(Request $request, $id){
        $request->validate([
            'password' => 'required'
        ]);
        
        $student = DB::table('students')->select('id', 'name', 'last_name', 'email')
        ->where('id', '=', $id)
        ->first();
        
        DB::table('users')->insert([
            'id' => $student->id, 
            'email' => $student->email,
            'name' => $student->name,
            'last_name' => $student->last_name, 
            'password' => Hash::make($request->password), 
            'created_at' => Carbon::now(), 
            'updated_at' => Carbon::now()
        ]);
        return back()->with('multiauth::admin.students.index')->with('message', 'Studento paskyra sukurta sėkmingai');
    }

    public function generate(){
        $keylength = 8;
		$str = "abcdefghijklmnopqrstuvwxyz123456789";
		$randstr = substr(str_shuffle($str), 0, $keylength);
  
        return $randstr;
    }
}
