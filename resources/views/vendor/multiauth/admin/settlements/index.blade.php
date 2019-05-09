@extends('multiauth::layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        {{$group}} grupės atsiskaitymai
                        <span class="float-right">
                            <a href="{{route('admin.settlements.assignSubject', $group)}}" class="btn btn-sm btn-success">Pasirenkamieji dalykai</a>
                            <a href="{{route('admin.students.group', $group)}}" class="btn btn-sm btn-secondary">Atgal</a>
                        </span>
                    </div>

                    <div class="card-body">
                        @include('multiauth::message')
                            <form method="post" action="{{route('admin.settlements.download', $group)}}">
                                @csrf
                                <button type="submit" class="btn btn-primary">Atsiųsti pažangumo suvestinę</button>
                            </form>
                            <br/>
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
                                        <td style="max-width: 330px">
                                            @if($subject->evaluation_type == 'prj.')
                                                {{$subject->subject_name}} (praktika)
                                            @else
                                                {{$subject->subject_name}}
                                            @endif    
                                        </td>
                                        <td>{{$subject->semester}}</td>
                                        <td>{{$subject->credits}}</td>
                                        <td>{{$subject->evaluation_type}}</td>
                                        <td>
                                            <div class="row">
                                                <form action="{{route('admin.settlements.assignTeacher', [$subject->subject_code, $subject->semester])}}" method="post">
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
                                            @if(isset($subject->teacher_id))
                                                <?php $exam_occured = false; ?>
                                                @foreach($exams as $exam)
                                                    @if($exam->subject_code == $subject->subject_code && $subject->semester == $exam->semester)
                                                        <form action="{{route('admin.settlements.showRetention', [$group, $subject->subject_code])}}" method="get">
                                                            <input type="hidden" name="semester" value="{{$subject->semester}}">
                                                            <input type="hidden" name="credits" value="{{$subject->credits}}">
                                                            <input type="hidden" name="evaluation_type" value="{{$subject->evaluation_type}}">
                                                            <input type="hidden" name="teacher_id" value="{{$subject->teacher_id}}">                                                  
                                                            <button class="btn btn-sm btn-light">Perlaikymai</button>
                                                            <?php $exam_occured = true; ?>
                                                        </form>
                                                        @break
                                                    @endif
                                                @endforeach  
                                                @if($exam_occured == false)
                                                    <form action="{{route('admin.settlements.show', [$group, $subject->subject_code])}}" method="get">
                                                        <input type="hidden" name="status" value="{{$subject->subject_status}}">
                                                        <input type="hidden" name="semester" value="{{$subject->semester}}">
                                                        <input type="hidden" name="credits" value="{{$subject->credits}}">
                                                        <input type="hidden" name="evaluation_type" value="{{$subject->evaluation_type}}">
                                                        <input type="hidden" name="teacher_id" value="{{$subject->teacher_id}}">
                                                        <button type="submit" class="btn btn-sm btn-primary">Vertinimai</button>
                                                    </form>
                                                @endif
                                            @endif                 
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