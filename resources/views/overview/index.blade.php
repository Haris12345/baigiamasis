@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Studijų apžvalga</div>

                <div class="card-body">
                    {{-- @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif --}}
                    <div id="app">
                        <table class="table table-responsive(xl)">
                            <tr>
                                <th>Dalykas</th>
                                <th>Semestras</th>
                                <th>Kreditai</th>
                                <th>Atsiskaitymo forma</th>
                                <th>Dėstytojas</th>
                                <th>Atsiskaitymo data</th>
                                <th>Įvertinimas</th>
                            </tr>

                            @foreach ($subjects as $subject)
                                <tr>
                                    <td>{{$subject->subject_name}}</td>
                                    <td>{{$subject->semester}}</td>
                                    <td>{{$subject->credits}}</td>
                                    <td>{{$subject->evaluation_type}}</td>
                                    <td>{{$subject->teacher_name}} {{$subject->teacher_last_name}}</td>
                                    <td>
                                        @foreach ($exams as $exam)
                                            @if($subject->subject_code == $exam->subject_code)
                                                {{$exam->date}}
                                            @else
                                                Neįvyko
                                            @endif
                                        @endforeach
                                        
                                    </td>
                                    <td>
                                        @foreach ($exams as $exam)
                                            @if($subject->subject_code == $exam->subject_code)
                                                {{$exam->mark}}
                                            @else
                                                Nevertinta
                                            @endif
                                        @endforeach
                                        
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
