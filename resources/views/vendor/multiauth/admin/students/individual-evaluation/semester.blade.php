@extends('multiauth::layouts.app') 
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        {{$semester}}-o semestro atsiskaitymai
                        <span class="float-right">
                            <a href="{{route('admin.students.individual-evaluation', [$group, $id])}}" class="btn btn-sm btn-secondary">Atgal</a>
                        </span>
                    </div>

                    <div class="card-body">
                        @include('multiauth::message')
                        <h2>Studento {{$student->name}} {{$student->last_name}} atsiskaitymai</h2>

                        <table class="table table-responsive(xl)">
                            <tr>
                                <th>Dalykas</th>
                                <th>Kreditai</th>
                                <th>Atsiskaitymo forma</th>
                                <th>Dėstytojas</th>
                                <th>Data</th>
                                <th>įvertinimas</th>
                                <th>Pastabos</th>
                                <th>Veiksmai</th>
                            </tr>
                            @foreach($subjects as $subject)
                                <tr>
                                    <td>
                                        @if($subject->evaluation_type == 'prj.')
                                            {{$subject->subject_name}} (praktika)
                                        @else
                                            {{$subject->subject_name}}
                                        @endif        
                                    </td>
                                    <td>{{$subject->credits}}</td>
                                    <td>{{$subject->evaluation_type}}</td>
                                    <td>{{$subject->teacher_name}} {{$subject->teacher_last_name}}</td>
                                    <td>{{$subject->date}}</td>
                                    <td>
                                        @if(substr($subject->mark, 0, 2) == "Ne")
                                            {{$subject->mark}}
                                        @else
                                            {{substr($subject->mark, 0, 2)}}</td>
                                        @endif
                                    <td>{{$subject->comments}}</td>
                                    <td>
                                        <span style="white-space: nowrap">
                                        <a href="{{route('admin.students.individual-evaluation.edit', [$group, $id, $semester, $subject->subject_code])}}" class="btn btn-sm btn-primary">Keisti</a>
                                        @if($subject->comments == 'skola' || $subject->comments == 'Skola')
                                            <a href="{{route('admin.students.individual-evaluation.debt', [$group, $id, $semester, $subject->subject_code])}}" class="btn btn-sm btn-primary">Skola</a>
                                        @endif
                                        </span>
                                    </td>
                                </tr>                                      
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection    