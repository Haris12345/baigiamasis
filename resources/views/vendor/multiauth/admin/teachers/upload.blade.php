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
                        <h3>Dėstytojų įkėlimas iš Excel failo</h3>
                        <form method="post" action="{{route('admin.teachers.import')}}" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group row">
                                <label for="import" class="col-md-4 col-form-label text-md-right">{{ __('Dėstytojai') }}</label>
    
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