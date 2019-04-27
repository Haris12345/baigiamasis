@extends('multiauth::layouts.app') @section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Koreguoti {{$admin->name}} paskyrą
                    <a href="{{ route('admin.show') }}" class="btn btn-secondary btn-sm float-right">Atgal</a>
                </div>
                
                <div class="card-body">
                    @include('multiauth::message')
                    <form action="{{route('admin.update',[$admin->id])}}" method="post">
                        @csrf @method('patch')
                        <div class="form-group row">
                            <label for="role" class="col-md-4 col-form-label text-md-right">Vardas ir pavardė</label>
                            <input type="text" value="{{ $admin->name }}" name="name" class="form-control col-md-6" id="role">
                        </div>

                        <div class="form-group row">
                            <label for="role" class="col-md-4 col-form-label text-md-right">El. Paštas</label>
                            <input type="text" value="{{ $admin->email }}" name="email" class="form-control col-md-6" id="role">
                        </div>

                        <input type="hidden" name="role_id[]" id="role_id" value=1>

                        <div class="form-group row">
                            <label for="active" class="col-md-4 col-form-label text-md-right">Paskyra aktyvi</label>
                            <input type="checkbox" value="1" {{ $admin->active ? 'checked':'' }} name="activation" class="form-control col-md-6" id="active">
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Pakeisti
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
