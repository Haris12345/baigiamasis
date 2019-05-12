<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class OverviewController extends Controller
{
     public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        if (Auth::user()->updated_at == null) {
            return redirect(route('password'));
        }
        else{

            $id = Auth::id();
            $student = DB::table('students')
            ->where('id', '=', $id)
            ->first();

            $subjects = DB::table('exams')
            ->where('student_id', '=', $id)
            ->where('group', '=', $student->group)
            ->orderBy('semester')
            ->get();

            $evaluation = DB::table('group_subjects')
            ->where('group', '=', $student->group)
            ->orderBy('semester')
            ->get();

            return view('overview.index', compact('id', 'student', 'subjects', 'evaluation'));
        }
    }
}
