@extends('multiauth::layouts.app') 
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                   Studento informacija
                    <span class="float-right">
                            <a href="{{route('admin.students')}}" class="btn btn-sm btn-secondary">Visi studentai</a>
                            <a href="{{route('admin.students.group', $student->group)}}" class="btn btn-sm btn-secondary">Grupės studentai</a>
                    </span>
                </div>
                <div class="card-body">
                    @include('multiauth::message')
                    <h3>Studentas: {{$student->name}} {{$student->last_name}}</h3>
                    <p>Asmens kodas: {{$student->identity_code}}</p>
                    <p>Grupė: {{$student->group}}</p>
                    <p>Studiju forma 
                        @if($student->studies_form == "Ištestinė")
                            Ištęstinė
                        @else
                            {{$student->studies_form}}
                        @endif    
                    </p>
                    <p>Semestras: {{$student->semester}}</p>
                    <p>Kursas: {{$student->course}}</p>
                    <p>El. paštas: {{$student->email}}</p>
                    <p>Statusas: {{$student->status}}</p>
                    <p>Grupės sukūrimo metai: {{$student->year}}</p>
                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-5">
                            <a href="{{route('admin.students.edit', $student->id)}}" class="btn btn-success">Keisti</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection