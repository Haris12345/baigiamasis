@extends('multiauth::layouts.app') 
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Pridėti studentą
                    <span class="float-right">
                        <a href="{{route('admin.students.show', $student->id)}}" class="btn btn-sm btn-secondary">Atgal</a>
                    </span>
                </div>
                
                <div class="card-body">
                    @include('multiauth::message')
                    <form method="POST" action="{{ route('admin.students.update', $student->id) }}">
                            @csrf
    
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Vardas') }}</label>
    
                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ $student->name }}" required autofocus>
                                </div>
                            </div>
    
                            <div class="form-group row">
                                <label for="last_name" class="col-md-4 col-form-label text-md-right">{{ __('Pavardė') }}</label>
    
                                <div class="col-md-6">
                                    <input id="last_name" type="text" class="form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}" name="last_name" value="{{ $student->last_name }}" required autofocus>
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('El. paštas') }}</label>
    
                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ $student->email }}" required autofocus>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="group" class="col-md-4 col-form-label text-md-right">{{ __('Grupė') }}</label>
    
                                <div class="col-md-6">
                                    <select  name="group" class="form-control" value="{{$student->group}}">
                                        @foreach($group as $grp)
                                            <option>{{$grp->group_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="group" class="col-md-4 col-form-label text-md-right">{{ __('Studijų būsena') }}</label>
                                <div class="col-md-6">
                                    <select name="status" class="form-control">
                                        <option value="{{$student->status}}">{{$student->status}}</option>
                                        <option value="Studijuoja" >Studijuoja</option>
                                        <option value="Nutrauktos studijos" >Nutrauktos studijos</option>
                                        <option value="Pertrauktos studijos" >Pertrauktos studijos</option>
                                        <option value="Užbaigtos studijos" >Užbaigtos studijos</option>
                                        <option value="Išvykęs į dalines studijas" >Išvykęs į dalines studijas</option>
                                        <option value="Atvykęs dalinėms studijoms" >Atvykęs dalinėms studijoms</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="semester" class="col-md-4 col-form-label text-md-right">{{ __('Semestras') }}</label>
    
                                <div class="col-md-6">
                                    <input id="semester" type="number" class="form-control{{ $errors->has('semester') ? ' is-invalid' : '' }}" name="semester" value="{{ $student->semester }}" required autofocus>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Pakeisti') }}
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