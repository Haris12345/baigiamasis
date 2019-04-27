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
            ->leftJoin('group_subjects', 'exams.subject_code', 'group_subjects.subject_code')
            ->where('group_subjects.group', '=', $student->group)
            ->where('exams.student_id', '=', $id)
            ->where('exams.comments', '=', 'Skola')
            ->get();

            return view('debts.index', compact('debts'));
        }
    }
}
