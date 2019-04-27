@extends('multiauth::layouts.app') 
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        Ikėlimas iš Excel failo
                        <span class="float-right">
                            <a href="{{route('admin.studies')}}" class="btn btn-sm btn-secondary">Atgal</a>
                        </span>
                    </div>
                    <div class="card-body">
                        @include('multiauth::message')
                        <a href="{{route('admin.studies.downloadFt')}}" class="btn btn-primary">Nuolatinių studijų šablonas</a>
                        <a href="{{route('admin.studies.downloadEx')}}" class="btn btn-primary">Ištestinių studijų šablonas</a>
                        <br></br>
                        <form method="post" action="{{route('admin.studies.import')}}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group row">
                                <label for="studies_program" class="col-md-4 col-form-label text-md-right">{{ __('Studijų programa') }}</label>
    
                                <div class="col-md-6">
                                    <input id="studies_program" type="text" class="form-control{{ $errors->has('studies_program') ? ' is-invalid' : '' }}" name="studies_program" value="{{ old('studies_program') }}" required autofocus>
                                </div>
                            </div>

                            <div class="form-group row">
                                    <label for="studies_program_code" class="col-md-4 col-form-label text-md-right">{{ __('Studijų programos kodas') }}</label>
        
                                    <div class="col-md-6">
                                        <input id="studies_program_code" type="text" class="form-control{{ $errors->has('studies_program_code') ? ' is-invalid' : '' }}" name="studies_program_code" value="{{ old('studies_program_code') }}" required autofocus>
                                    </div>
                                </div>

                            <div class="form-group row">
                                <label for="studies_form" class="col-md-4 col-form-label text-md-right">{{ __('Studijų forma') }}</label>
    
                                <div class="col-md-6">
                                    <select class="form-control" name="studies_form">
                                        <option>-- Pasirinkite studijų formą --</option>
                                        <option>Nuolatinė</option>
                                        <option>Ištestinė</option>
                                    </select>
                                </div>
                            </div> 

                            <div class="form-group row">
                                <label for="import" class="col-md-4 col-form-label text-md-right">{{ __('Studijų planas') }}</label>
    
                                <div class="col-md-6">
                                    <input id="import" type="file" class="form-control{{ $errors->has('import') ? ' is-invalid' : '' }}" name="import" value="{{ old('import') }}" required autofocus>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-success">
                                        {{ __('Įkelti') }}
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