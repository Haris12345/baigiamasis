@extends('multiauth::layouts.app') @section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Keisti {{$admin->name}}</div>

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

                        <div class="form-group row">
                            <label for="role_id" class="col-md-4 col-form-label text-md-right">Priskirti Rolę</label>

                            <select name="role_id[]" id="role_id" class="form-control col-md-6 {{ $errors->has('role_id') ? ' is-invalid' : '' }}" multiple>
                                <option selected disabled>Pasirinkti rolę</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}" 
                                        @if (in_array($role->id,$admin->roles->pluck('id')->toArray())) 
                                            selected 
                                        @endif >{{ $role->name }}
                                    </option>
                                @endforeach
                            </select> 

                            @if ($errors->has('role_id'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('role_id') }}</strong>
                                </span> 
                            @endif
                        </div>

                        <div class="form-group row">
                            <label for="active" class="col-md-4 col-form-label text-md-right">Paskyra aktyvi</label>
                            <input type="checkbox" value="1" {{ $admin->active ? 'checked':'' }} name="activation" class="form-control col-md-6" id="active">
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-sm btn-primary">
                                    Pakeisti
                                </button>
                                <a href="{{ route('admin.show') }}" class="btn btn-secondary btn-sm float-right">Atgal</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
