<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DebtsController extends Controller
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

            $debts = DB::table('exams')
            ->leftJoin('group_subjects', function($join){
                $join->on('exams.subject_code', '=', 'group_subjects.subject_code');
                $join->on('exams.group', '=', 'group_subjects.group');
                $join->on('exams.semester', '=', 'group_subjects.semester');
            })
            ->where('exams.group', '=', $student->group)
            ->where('exams.student_id', '=', $id)
            ->where('exams.comments', '=', 'Skola')
            ->get();

            return view('debts.index', compact('debts'));
        }
    }
}
