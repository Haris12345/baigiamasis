@extends('multiauth::layouts.app') 
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                   Studento informacija
                    <span class="float-right">
                        <a href="{{route('admin.register')}}" class="btn btn-sm btn-danger">Ištrinti</a>
                    </span>
                </div>
                <div class="card-body">
                    @include('multiauth::message')
                    <h3>Studentas: {{$student[0]->name}} {{$student[0]->last_name}}</h3>
                    <p>Studiju programa: {{$student[0]->study_program}}</p>
                    <p>Studiju forma {{$student[0]->study_form}}</p>
                    <p>Kursas: {{$student[0]->course}}</p>
                    <p>El. paštas: {{$student[0]->email}}</p>
                    <a href="{{route('admin.students')}}" class="btn btn-secondary">Atgal</a>
                    <span class="float-right"><a href="{{route('admin.students.edit', $student[0]->id)}}" class="btn btn-success">Keisti</a></span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection