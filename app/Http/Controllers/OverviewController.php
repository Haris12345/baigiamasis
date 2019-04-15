<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class OverviewController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth:student');
    // }

    public function index(){
        $id = Auth::id();
        $student = DB::table('students')
        ->where('id', '=', $id)
        ->first();

        $subjects = DB::table('group_subjects')
        ->where('group', '=', $student->group)
        ->get();

        $exams = DB::table('exams')
        ->where('student_id', '=', $id)
        ->get();

        return view('overview.index', compact('id', 'student', 'subjects', 'exams'));
    }
}
