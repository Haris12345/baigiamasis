@extends('multiauth::layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        {{$group}} grupės atsiskaitymai
                        <span class="float-right">
                            <a href="{{route('admin.students.group', $group)}}" class="btn btn-sm btn-secondary">Atgal</a>
                        </span>
                    </div>

                    <div class="card-body">
                        @include('multiauth::message')
                        <div id="app">
                            <table class="table table-responsive(xl)">
                                <tr>
                                    <th>Dalykas</th>
                                    <th>Semestras</th>
                                    <th>Kreditai</th>
                                    <th>Atsiskaitymo forma</th>
                                    <th>Dėstytojas</th>
                                    <th>Studentų pažangumas</th>
                                </tr>
                                @foreach($subjects as $subject)
                                    <tr>
                                        <td>{{$subject->subject_name}}</td>
                                        <td>{{$subject->semester}}</td>
                                        <td>{{$subject->credits}}</td>
                                        <td>{{$subject->evaluation_type}}</td>
                                        <td>
                                            <div class="row">
                                                <form action="{{route('admin.settlements.assignTeacher', [$subject->subject_code])}}" method="post">
                                                    @csrf
                                                    <select name="teacher_id">
                                                        @if(!isset($subject->teacher_id))
                                                            <option>Nepriskirtas</option>
                                                            @foreach($teachers as $teacher)
                                                                <option value="{{$teacher->id}}">{{$teacher->name}} {{$teacher->last_name}}</option>
                                                            @endforeach
                                                        @else
                                                            @foreach($teachers as $teacher)
                                                                @if($subject->teacher_id == $teacher->id)
                                                                    <option selected value="{{$teacher->id}}">{{$teacher->name}} {{$teacher->last_name}}</option>
                                                                @endif
                                                                @if($subject->teacher_id != $teacher->id)
                                                                    <option value="{{$teacher->id}}">{{$teacher->name}} {{$teacher->last_name}}</option>
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                    <button type="submit" class="btn btn-sm btn-success">Priskirti</button>
                                                </form>
                                            </div>
                                        </td>
                                        <td>
                                            <form action="{{route('admin.settlements.show', [$group, $subject->subject_code])}}" method="get">
                                                <input type="hidden" name="semester" value="{{$subject->semester}}">
                                                <input type="hidden" name="credits" value="{{$subject->credits}}">
                                                <input type="hidden" name="evaluation_type" value="{{$subject->evaluation_type}}">
                                                <input type="hidden" name="teacher_id" value="{{$subject->teacher_id}}">
                                                <button type="submit" class="btn btn-sm btn-primary">Vertinimai</button>
                                            </form>
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