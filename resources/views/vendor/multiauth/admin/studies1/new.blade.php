@extends('multiauth::layouts.app') 
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Pridėti studijų programą
                    <span class="float-right">
                        <a href="{{route('admin.studies')}}" class="btn btn-sm btn-secondary">Atgal</a>
                    </span>
                </div>
                
                <div class="card-body">
                    @include('multiauth::message')
                    <form method="POST" action="{{ route('admin.studies.create') }}">
                            @csrf
    
                            <div class="form-group row">
                                <label for="study_program" class="col-md-4 col-form-label text-md-right">{{ __('Pilnas pavadinimas') }}</label>
    
                                <div class="col-md-6">
                                    <input id="study_program" type="text" class="form-control{{ $errors->has('nstudy_programame') ? ' is-invalid' : '' }}" name="study_program" value="{{ old('study_program') }}" required autofocus>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="study_form" class="col-md-4 col-form-label text-md-right">{{ __('Studijų forma') }}</label>
    
                                <div class="col-md-6">
                                    <input id="study_form" type="text" class="form-control{{ $errors->has('study_form') ? ' is-invalid' : '' }}" name="study_form" value="{{ old('study_form') }}" required autofocus>
                                </div>
                            </div>
    
                            <div class="form-group row">
                                <label for="study_program_abrv" class="col-md-4 col-form-label text-md-right">{{ __('Sutrumpintas pavadinimas') }}</label>
    
                                <div class="col-md-6">
                                    <input id="study_program_abrv" type="text" class="form-control{{ $errors->has('study_program_abrv') ? ' is-invalid' : '' }}" name="study_program_abrv" value="{{ old('study_program_abrv') }}" required autofocus>
                                </div>
                            </div> 

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Pridėti') }}
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