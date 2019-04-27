@extends('multiauth::layouts.app') 
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        Individualus studento vertinimas
                        <span class="float-right">
                                <a href="{{route('admin.students')}}" class="btn btn-sm btn-secondary">Visi studentai</a>
                                <a href="{{route('admin.students.group', $group)}}" class="btn btn-sm btn-secondary">Grupės studentai</a>
                        </span>
                    </div>

                    <div class="card-body">
                        @if($student->studies_form == 'Nuolatinė')
                            @for($semester=1; $semester<7; $semester++)
                                <div class="list-group">
                                    <a href="{{route('admin.students.individual-evaluation.semester', [$group, $id, $semester])}}" class="list-group-item list-group-item-action">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h5 class="mb-1">{{$semester}} semestras</h5>
                                            <small>Viso: {{$credits[$semester-1]}} ECTS.</small>
                                        </div>
                                        <p class="mb-1"> Skolų sk. {{$debts[$semester-1]}} ({{$debts_credits[$semester-1]}} ECTS kred.)</p>
                                    </a>
                                </div>
                            @endfor
                        @endif

                        @if($student->studies_form == 'Ištestinė')
                            @for($semester=1; $semester<9; $semester++)
                                <div class="list-group">
                                    <a href="{{route('admin.students.individual-evaluation.semester', [$group, $id, $semester])}}" class="list-group-item list-group-item-action">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h5 class="mb-1">{{$semester}} semestras</h5>
                                            <small>Viso: {{$credits[$semester-1]}} ECTS.</small>
                                        </div>
                                        <p class="mb-1">Viso: {{$credits[$semester-1]}} ECTS. Skolų sk. {{$debts[$semester-1]}} ({{$debts_credits[$semester-1]}} ECTS kred.)</p>
                                    </a>
                                </div>
                            @endfor
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection