@extends('multiauth::layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        Studento paskyra
                        <span class="float-right">
                            <a href="{{route('admin.students')}}" class="btn btn-sm btn-secondary">Atgal</a>
                        </span>
                    </div>
                    <div class="card-body">
                        @include('multiauth::message')
                        <h3>Studentas: {{$student[0]->name}} {{$student[0]->last_name}}</h3>
                        <p>El. paštas: {{$student[0]->email}}</p>
                        <form method="POST" action="{{ route('admin.students.account.new', $student[0]->id) }}">
                            @csrf
                            <div class="form-group row">
                                <generate-password></generate-password>
                            </div>
                           
                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Sukurti') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection