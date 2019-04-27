<?php

namespace App\Http\Controllers;

use Auth;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(){
        $user = Auth::user();
        if ($user->updated_at == null) {
            return redirect(route('password'));
        }
        else{
            $debts = DB::table('exams')
            ->where('student_id', '=', $user->id)
            ->where('comments', '=', 'skola')
            ->count();

            $exams = DB::table('exams')
            ->select('subject_name', 'mark')
            ->where('student_id', '=', $user->id)
            ->orderBy('updated_at', 'DESC')
            ->take(5)
            ->get();
            return view('home', compact('debts', 'exams'));  
        }
    }

    public function showChangePasswordForm(){
        return view('auth.passwords.changePassword');
    }

    public function changePassword(Request $request){
        if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {
            // The passwords matches
            return redirect()->back()->with("error","Pateiktas netinkamas dabartinis slaptažodis");
        }
        if(strcmp($request->get('current-password'), $request->get('new-password')) == 0){
            //Current password and new password are same
            return redirect()->back()->with("error","Naujas slaptažodis negali būti toks pats kaip dabartinis");
        }
        $validatedData = $request->validate([
            'current-password' => 'required',
            'new-password' => 'required|string|min:8|confirmed',
        ]);
        //Change Password
        $user = Auth::user();
        $user->password = bcrypt($request->get('new-password'));
        $user->save();
        return redirect()->back()->with("success","Slaptažodis pakeistas sėkmingai");
    }
}
