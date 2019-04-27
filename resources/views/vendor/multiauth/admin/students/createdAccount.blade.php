@extends('multiauth::layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        Studento paskyra
                        <span class="float-right">
                                <a href="{{route('admin.students')}}" class="btn btn-sm btn-secondary">Visi studentai</a>
                                <a href="{{route('admin.students.group', $group)}}" class="btn btn-sm btn-secondary">Grupės studentai</a>
                        </span>
                    </div>
                    <div class="card-body">
                        <h3>Sugeneruota laikina nuoroda studentui: {{$name}} {{$last_name}}</h3>
                        <h5><b>SVARBU!</b> Toliau pateiktą informaciją turite nukopijuoti. Jei šį langą perkrausite po daugiau nei minutės, informacija bus neprieinama</h5>
                        <p><b>Studento El. paštas: {{$email}}</b></p>
                        <p><b>Studento slaptažodis: {{$password}}</b></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection