@extends('multiauth::layouts.app') 
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        {{$semester}}-o semestro atsiskaitymai
                        <span class="float-right">
                            <a href="" class="btn btn-sm btn-secondary">Atgal</a>
                        </span>
                    </div>

                    <div class="card-body">
                        <h2>Studento {{$student->name}} {{$student->last_name}} atsiskaitymai</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection    