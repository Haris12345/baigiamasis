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
                    <h3>Studentas: {{$student->name}} {{$student->last_name}}</h3>
                    <p>Asmens kodas: {{$student->identity_code}}</p>
                    <p>Grupė: {{$student->group}}</p>
                    <p>Studiju forma {{$student->studies_form}}</p>
                    <p>Semestras: {{$student->semester}}</p>
                    <p>Kursas: {{$student->course}}</p>
                    <p>El. paštas: {{$student->email}}</p>
                    <p>Statusas: {{$student->status}}</p>
                    <p>Grupės sukūrimo metai: {{$student->year}}</p>
                    <a href="{{route('admin.students.group', $student->group)}}" class="btn btn-secondary">Atgal</a>
                    <span class="float-right"><a href="{{route('admin.students.edit', $student->id)}}" class="btn btn-success">Keisti</a></span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection