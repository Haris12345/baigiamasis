<?php

namespace Bitfumes\Multiauth\Http\Controllers;

use Bitfumes\Multiauth\Model\Admin;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Exports\AccountsExport;
use Carbon\Carbon;
use Illuminate\Support\Facades\URL;

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
        $account = DB::table('users')
        ->select('id', 'active')
        ->where('id', '=', $id)
        ->first();

        $group = DB::table('students')
        ->select('group')
        ->where('id', '=', $id)
        ->first();
        
        $student = DB::table('students')
        ->select('id', 'identity_code', 'name', 'last_name', 'email', 'group')
        ->where('id', '=', $id)
        ->first();

        return view('multiauth::admin.students.account', compact('account', 'student', 'group'));
    }

    public function create(Request $request, $id){
        $request->validate([
            'password' => 'required'
        ]);

        $student = DB::table('students')->select('id', 'name', 'last_name', 'email', 'group')
        ->where('id', '=', $id)
        ->first();

        $name = $student->name;
        $last_name = $student->last_name;
        $email = $student->email;
        $group = $student->group;
        
        DB::table('users')->insert([
            'id' => $student->id, 
            'email' => $email,
            'name' => $name,
            'last_name' => $last_name, 
            'password' => Hash::make($request->password), 
            'created_at' => Carbon::now()
        ]);
        
        return redirect(URL::temporarySignedRoute(
            'admin.students.account.createdAccount', now()->addMinutes(1), ['name' => $name, 'last_name' => $last_name, 'email' => $email, 'group' => $group, 'password' => $request->password]
        ));
    }

    public function generate(){
        $keylength = 10;
		$str = "abcdefghijklmnopqrstuvwxyz123456789";
		$randstr = substr(str_shuffle($str), 0, $keylength);
  
        return $randstr;
    }

    public function groupGenerate(Request $request){
        $students = json_decode($request->input('students.0'));

        $password = array();
        foreach($students as $student){
            $keylength = 10;
            $str = "abcdefghijklmnopqrstuvwxyz123456789";
            $randstr = substr(str_shuffle($str), 0, $keylength);

            array_push($password, $randstr);

            DB::table('users')
            ->insert([
                'id' => $student->id,
                'name' => $student->name,
                'last_name' => $student->last_name,
                'email' => $student->email,
                'password' => Hash::make($randstr),
                'created_at' => Carbon::now()
            ]); 
        }

        foreach($password as $key=>$value){
            $students[$key]->password = $value;
        }

        $students = json_decode(json_encode($students), true);

        return (new AccountsExport($students))->download("$request->group.xlsx");
    }

    public function update(Request $request){
        if(isset($request->active)){
            $active = 1;
        }
        else{
            $active = 0;
        }

        DB::table('users')
        ->where('id', '=', $request->student)
        ->update([
            'active' => $active
        ]);

        return back()->with('message', 'Studento paskyra buvo atnaujinta');
    }

    public function delete(Request $request){
        DB::table('users')
        ->where('id', '=', $request->student)
        ->delete();
        return back()->with('message', 'Paskyra buvo ištrinta');
    }

    public function createdAccount($name, $last_name, $email, $group, $password){
        return view('multiauth::admin.students.createdAccount', compact('name', 'last_name', 'email', 'group', 'password'));
    }
}
