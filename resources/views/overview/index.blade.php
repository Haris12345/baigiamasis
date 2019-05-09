@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Studijų apžvalga</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
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
                                <th>Įvertino</th>
                            </tr>

                            @foreach ($subjects as $subject)
                                <tr>
                                    <td>
                                        @if($subject->settlement_type == 'prj.')
                                            {{$subject->subject_name}} (praktika)
                                        @else
                                            {{$subject->subject_name}}
                                        @endif
                                    </td>
                                    <td>{{$subject->semester}}</td>
                                    <td>{{$subject->credits}}</td>
                                    <td>{{$subject->settlement_type}}</td>
                                    <td>{{$subject->teacher_name}} {{$subject->teacher_last_name}}</td>
                                    <td>{{$subject->date}}</td>
                                    <td>{{$subject->mark}}</td>
                                    <td>{{$subject->evaluated_by}}</td>
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
