<?php

namespace Bitfumes\Multiauth\Http\Controllers;

use Bitfumes\Multiauth\Model\Admin;
use App\Students;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class StudentsController extends Controller
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

    public function index(){
        $id = Students::select('id')->first();
        $students = DB::table('students')
        ->paginate(30);
        
        return view('multiauth::admin.students.index', compact('students', 'id'));
    }

    public function get($group){
        $id = Students::select('id')
        ->where('group', '=', $group)
        ->first();
        $students = DB::table('students')->paginate(30);

        return view('multiauth::admin.students.index', compact('students', 'id', 'group'));
    }

    public function new($group){
        
        return view('multiauth::admin.students.new', compact('groups_ft', 'groups_ex', 'group'));
    }

    public function show($id){
        $student = DB::table('students')
        ->where('id', '=', $id)
        ->first();
        return view('multiauth::admin.students.show')->with('student', $student);
    }

    public function create(Request $request){
        $request->validate([
            'identity_code' => 'required',
            'name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:students',
        ]);
        
        $code = DB::table('groups')
        ->select('studies_program_code')
        ->where('group_name', '=', $request->group)
        ->first();
        $studies_form = substr($request->group, -4, -2);
        
        if($studies_form == 'nl'){
            $studies_form = 'Nuolatinė';
        }
        if($studies_form == 'ii'){
            $studies_form = 'Ištestinė';
        }

        $year = substr($request->group, -2);
        $year = 2000 + (int)$year;

        DB::table('students')->insert([
            'name' => $request->name,
            'last_name' => $request->last_name,
            'identity_code' => $request->identity_code,
            'email' => $request->email,
            'status' => 'Nestudijuojantis',
            'group' => $request->group,
            'course' => 1,
            'semester' => 1,
            'studies_form' => $studies_form,
            'studies_program_code' => $code->studies_program_code,
            'year' => $year,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        return back()->with('message', 'Studentas sukurtas sėkmingai');

    }

    public function edit($id){
        $group = DB::table('groups')->select('group_name')->get();
        $student = DB::table('students')
        ->where('id', '=', $id)
        ->first();
        return view('multiauth::admin.students.edit', compact('group', 'student'));
       
    }

    public function update(Request $request, $id){
        $student = Students::find($id);
        $request->validate([
            'name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'group' => 'required',
            'semester' => 'required'
        ]);

        $course = round($request->semester/2, 0);
        $studies_form = substr($request->group, -4, -2);
        
        if($studies_form == 'nl'){
            $studies_form = 'Nuolatinė';
        }
        if($studies_form == 'ii'){
            $studies_form = 'Ištestinė';
        }
        $year = substr($request->group, -2);
        $year = 2000 + (int)$year;

        DB::table('students')
        ->where('id', '=', $id)
        ->update([
            'name' => $request->name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'group' => $request->group,
            'semester' => $request->semester,
            'course' => $course,
            'studies_form' => $studies_form,
            'year' => $year
        ]);

        return redirect('/admin/students/show/'. $id)->with('message', 'Studentas pakoreguotas sėkmingai')->with('student', $student);
    }

    public function delete($id){
        $student = Students::find($id);
        $student->delete();
        return redirect('/admin/students')->with('message', 'Studentas buvo pašalintas iš duomenų bazės');
    }

    public function account($id){
        $student = DB::table('students')
        ->leftJoin('study_programs', 'students.study_program_id', '=', 'study_programs.id')
        ->select('students.id', 'students.name', 'students.last_name', 'students.email')
        ->where('students.id', '=', $id)
        ->get();
        return view('multiauth::admin.students.account')->with('student', $student);
    }

    public function newAccount(Request $request, $id){
        // pakoreguoti paskyru kurima stvarkyti redirecta po paskyros kurimo
        $request->validate([
            'password' => 'required'
        ]);
        
        $student = DB::table('students')->select('id', 'name', 'last_name', 'email')
        ->where('id', '=', $id)
        ->first();
        
        DB::table('users')->insert(
            ['id' => $student->id, 'email' => $student->email, 'password' => Hash::make($request->password), 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        return redirect('multiauth::admin.students.index')->with('message', 'Studento paskyra sukurta sėkmingai');
    }

    public function generate(){
        $keylength = 8;
		$str = "abcdefghijklmnopqrstuvwxyz123456789";
		$randstr = substr(str_shuffle($str), 0, $keylength);
  
        return $randstr;
    }
}
