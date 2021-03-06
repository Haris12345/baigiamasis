@extends('multiauth::layouts.app') 
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Pridėti grupę
                    <span class="float-right">
                        <a href="{{route('admin.groups')}}" class="btn btn-sm btn-secondary">Atgal</a>
                    </span>
                </div>
                
                <div class="card-body">
                    @include('multiauth::message')
                    <form method="POST" action="{{ route('admin.groups.create') }}">
                            @csrf
                            
                            <div class="form-group row">
                                <label for="studies_form" class="col-md-4 col-form-label text-md-right">{{ __('Studijų planas') }}</label>
    
                                <div class="col-md-6">
                                    <select class="form-control" name="studies_plan">
                                        <option>Pasirinkite studijų planą</option>
                                        @foreach ($studies_program_ft as $ft)
                                            <option value="{{$ft->studies_program_code}}nl"> {{$ft->studies_program_name}} {{$ft->studies_form}}</option> 
                                        @endforeach
                                        @foreach ($studies_program_ex as $ex)
                                            <option value="{{$ex->studies_program_code}}i"> {{$ex->studies_program_name}} Ištęstinė</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div> 
    

                            <div class="form-group row">
                                <label for="group_name" class="col-md-4 col-form-label text-md-right">{{ __('Grupės pavadinimas') }}</label>
    
                                <div class="col-md-6">
                                    <input id="group_name" type="text" class="form-control{{ $errors->has('group_name') ? ' is-invalid' : '' }}" name="group_name" value="{{ old('group_name') }}" required autofocus>
                                </div>
                            </div>
    
                            <div class="form-group row">
                                <label for="studies_form" class="col-md-4 col-form-label text-md-right">{{ __('Studijų forma') }}</label>

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