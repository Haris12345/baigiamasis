<?php

namespace Bitfumes\Multiauth\Http\Controllers;

use Bitfumes\Multiauth\Model\Admin;
use App\Students;
use App\Imports\StudentsImport;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
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

    public function index(Request $request){
        $id = Students::select('id')->first();
        $students = DB::table('students')
        ->paginate(30);

        return view('multiauth::admin.students.index', compact('students', 'id'));
    }

    public function filter(Request $request){
        $id = Students::select('id')->first();
        $semester = $request->semester;
        $studies_form = $request->studies_form;
        $status = $request->status;

        if($semester != "0"){
            $students = DB::table('students')
            ->where('semester', '=', $semester)
            ->paginate(30);
        }
        if($studies_form != "0"){
            
            $students = DB::table('students')
            ->where('studies_form', '=', $studies_form)
            ->paginate(30);
        }
        if($status != "0"){
            $students = DB::table('students')
            ->where('status', '=', $status)
            ->paginate(30);
        }
        if($semester != "0" && $studies_form != "0"){
            $students = DB::table('students')
            ->where('semester', '=', $semester)
            ->where('studies_form', '=', $studies_form)
            ->paginate(30);
        }
        if($studies_form != "0" && $status != "0"){
            $students = DB::table('students')
            ->where('studies_form', '=', $studies_form)
            ->where('status', '=', $status)
            ->paginate(30);
        }
        if($semester != "0" && $status != "0"){
            $students = DB::table('students')
            ->where('semester', '=', $semester)
            ->where('status', '=', $status)
            ->paginate(30);
        }
        if($semester != "0" && $studies_form != "0" && $status != "0"){
            $students = DB::table('students')
            ->where('semester', '=', $semester)
            ->where('studies_form', '=', $studies_form)
            ->where('status', '=', $status)
            ->paginate(30);
        }
        if($semester == "0" && $studies_form == "0" && $status == "0"){
            $students = DB::table('students')
            ->paginate(30);
        }
        
        return view('multiauth::admin.students.index', compact('semester', 'studies_form', 'status', 'students', 'id'));
    }

    public function get($group){
        $id = Students::select('id')
        ->where('group', '=', $group)
        ->first();
        $students = DB::table('students')
        ->where('group', '=', $group)
        ->paginate(30);

        $accounts = DB::table('users')
        ->select('id')
        ->get();

        $students_no_acc = DB::table('students')
        ->select('students.id', 'students.name', 'students.last_name', 'students.email')
        ->leftJoin('users', 'students.id', '=', 'users.id')
        ->where('users.id', '=', NULL)
        ->where('students.group', '=', $group)
        ->get();

        return view('multiauth::admin.students.index', compact('students_no_acc', 'students', 'id', 'group'));
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
            'identity_code' => 'required|max:11',
            'name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
        ]);
        
        $code = DB::table('groups')
        ->select('studies_program_code')
        ->where('group_name', '=', $request->group)
        ->first();
        $studies_form = substr($request->group, -3, -2);
        
        if($studies_form == 'l'){
            $studies_form = 'Nuolatinė';
        }
        if($studies_form == 'i'){
            $studies_form = 'Ištestinė';
        }

        $year = substr($request->group, -2);
        $year = 2000 + (int)$year;

        DB::table('students')->insert([
            'name' => $request->name,
            'last_name' => $request->last_name,
            'identity_code' => $request->identity_code,
            'email' => $request->email,
            'status' => $request->status,
            'group' => $request->group,
            'course' => 1,
            'semester' => 1,
            'studies_form' => $studies_form,
            'studies_program_code' => $code->studies_program_code,
            'year' => $year,
            'created_at' => Carbon::now()
        ]);

        DB::table('groups')
        ->where('group_name', '=', $request->group)
        ->increment('students', 1);

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
        $studies_form = substr($request->group, -3, -2);
        
        if($studies_form == 'l'){
            $studies_form = 'Nuolatinė';
        }
        if($studies_form == 'i'){
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
            'status' => $request->status,
            'year' => $year
        ]);

        return redirect()->route('admin.students.show', $id)->with('message', 'Studentas pakoreguotas sėkmingai')->with('student', $student);
    }

    public function delete($id){
        $student = Students::find($id);
        $student->delete();
        return redirect('/admin/students')->with('message', 'Studentas buvo pašalintas iš duomenų bazės');
    }

    public function upload(){
        return view('multiauth::admin.students.upload');
    }

    public function import(Request $request){
        if($request->hasFile('import')){
            $students = Excel::toCollection(new StudentsImport(), $request->file('import'));
            foreach($students[0] as $column){
                $studies_form = substr($column[1], -3, -2);
                $year = substr($column[1], -2);
                $year = 2000 + (int)$year;
                if($studies_form == 'l'){
                    $studies_form = 'Nuolatinė';
                }
                if($studies_form == 'i'){
                    $studies_form = 'Ištestinė';
                }
                DB::table('students')->insert([
                    'studies_program_code' => $column[0],
                    'group' => $column[1],
                    'identity_code' => $column[2],
                    'name' => $column[3],
                    'last_name' => $column[4],
                    'email' => $column[5],
                    'status' => 'Studijuoja',
                    'course' => 1,
                    'semester' => 1,
                    'studies_form' => $studies_form,
                    'year' => $year,
                    'created_at' => Carbon::now()
                ]);

                DB::table('groups')
                ->where('group_name', '=', $column[1])
                ->increment('students', 1);
            }

            return back()->with('message', 'Studentai importuoti');
        }

        return back()->with('message', 'Studentai nebuvo įterpti');
    }

    public function download(){
        return response()->download(public_path('downloads/Studentų šablonas.xlsx'));
    }

    public function search(Request $request){
        $id = Students::select('id')->first();
        $search = $request->get('search');
        $results = DB::table('students')
        ->where('name', 'like', '%' . $search . '%')
        ->orwhere('last_name', 'like', '%' . $search . '%')
        ->orwhere('identity_code', 'like', '%' . $search . '%')
        ->orwhere('email', 'like', '%' . $search . '%')
        ->orwhere('group', 'like', '%' . $search . '%')
        ->paginate(30);

        return view('multiauth::admin.students.index', ['id' => $id, 'students' => $results]);
    }

    public function changeSemester($group){
        DB::table('students')
        ->where('group', '=', $group)
        ->increment('semester');

        return back()->with('message', "Grupė $group buvo perkelta į kitą semestrą");
    }

    public function disableAcc($group){
        $students = DB::table('students')
        ->where('group', '=', $group)
        ->get();

        foreach($students as $student){
            $user = DB::table('users')
            ->where('id', '=', $student->id)
            ->first();
            
            if($user != NULL){
                DB::table('users')
                ->where('id', '=', $student->id)
                ->update([
                    'active' => false
                ]);
            }         
        }

        return back()->with('message', 'Studentų paskyros buvo išjungtos');       
    }
}
