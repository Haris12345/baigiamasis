@extends('multiauth::layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        Studento paskyra
                        <span class="float-right">
                            <a href="" class="btn btn-sm btn-secondary">Atgal</a>
                        </span>
                    </div>
                    <div class="card-body">
                        @include('multiauth::message')
                        @if($student == 'SET')
                        <h3>Šio studento paskyra jau paruošta galite gryžti prie kitų studentų</h3>
                        @else
                            <h3>Studentas: {{$student->name}} {{$student->last_name}}</h3>
                            <p>El. paštas: {{$student->email}}</p>
                            <form method="POST" action="{{ route('admin.students.account.new', $student->id) }}">
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
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection