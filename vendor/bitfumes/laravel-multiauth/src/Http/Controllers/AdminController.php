<?php

namespace Bitfumes\Multiauth\Http\Controllers;

use Bitfumes\Multiauth\Model\Admin;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
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

    public function index()
    {
        $teachers = DB::table('teachers')->count();
        $students = DB::table('students')->count();
        $ft = DB::table('study_plans_full_time')->groupBy('studies_program_code')->get();
        $ex = DB::table('study_plans_extended')->groupBy('studies_program_code')->get();
        $groups = DB::table('groups')->count();
        $study_plans = count($ft) + count($ex);
        
        return view('multiauth::admin.home', compact('teachers', 'students', 'groups', 'study_plans'));
    }

    public function show()
    {
        $admins = Admin::where('id', '!=', auth()->id())->get();
        return view('multiauth::admin.show', compact('admins'));
    }

    public function showChangePasswordForm()
    {
        return view('multiauth::admin.passwords.change');
    }

    public function changePassword(Request $request)
    {
        $data = $request->validate([
            'oldPassword'   => 'required',
            'password'      => 'required|confirmed',
        ]);
        auth()->user()->update(['password' => bcrypt($data['password'])]);

        return redirect(route('admin.home'))->with('message', 'Jūsų slaptažodis pakeistas sėkmingai');
    }
}
