@extends('multiauth::layouts.app') 
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    Skolos tvarkymas studentui
                    <span class="float-right">
                        <a href="{{ route('admin.settlements', $group) }}" class="btn btn-sm btn-secondary">Atgal</a>
                    </span>
                </div>
                
                <div class="card-body">
                    @include('multiauth::message')
                    <h3>Grupės {{$group}} pasirenkamieji dalykai </h3>
                    @foreach($subjects as $subject) 
                        <div class="card mb-3">
                            <div class="card-body">
                                <p>Priskirti naują dalyką</p>
                                <p>Semestras: {{$subject->semester}}</p>
                                <form method="POST" action="{{ route('admin.settlements.assignSubject.update') }}">
                                    @csrf
                                    <input type="hidden" name="group" value="{{$group}}">   
                                    <div class="form-group row">
                                        <label for="subject" class="col-md-4 col-form-label text-md-right">{{$subject->subject_name}} ({{$subject->credits}} kred.)</label>
                                        <div class="col-md-6">
                                            <input type="hidden" name="studies_program_code" value="{{$subject->studies_program_code}}">
                                            <input type="hidden" name="old_subject" value="{{$subject->subject_name}}">
                                            <input type="text" class="form-control" name="subject">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="evaluation" class="col-md-4 col-form-label text-md-right">Atsiskaitymo tipas</label>
                                        <div class="col-md-6">
                                            <select class="form-control" name="evaluation">
                                                <option>egz.</option>
                                                <option>prj.</option>
                                                <option>įsk.</option>
                                            </select>
                                        </div>                   
                                    </div>
                                    <br/>
                                    <div class="form-group row mb-0">
                                        <div class="col-md-6 offset-md-4">
                                            <button type="submit" class="btn btn-primary">Atnaujinti</button>    
                                        </div>
                                    </div>   
                                </form>
                            </div>
                        </div>    
                    @endforeach
                    @foreach($assigned_subjects as $assigned)
                        <div class="card mb-3">
                            <div class="card-body">
                                <p>Koreguoti priskirtą dalyką</p>
                                <form method="POST" action="{{ route('admin.settlements.assignSubject.update') }}">
                                    @csrf
                                    <input type="hidden" name="group" value="{{$group}}">   
                                    <input type="hidden" name="subject_code" value="{{$assigned->subject_code}}">   
                                    <div class="form-group row">
                                        <label for="subject" class="col-md-4 col-form-label text-md-right">Dalykas</label>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" name="subject" value="{{$assigned->subject_name}}">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="credits" class="col-md-4 col-form-label text-md-right">Kreditai</label>
                                        <div class="col-md-6">
                                            <input type="number" class="form-control" name="credits" value="{{$assigned->credits}}">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="semester" class="col-md-4 col-form-label text-md-right">Semestras</label>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" name="semester" value="{{$assigned->semester}}">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="evaluation" class="col-md-4 col-form-label text-md-right">Atsiskaitymo tipas</label>
                                        <div class="col-md-6">
                                            <select class="form-control" name="evaluation">
                                                <option selected>{{$assigned->evaluation_type}}</option>
                                                <option>egz.</option>
                                                <option>prj.</option>
                                            </select>
                                        </div>                   
                                    </div>
                                    <br/>
                                    <div class="form-group row mb-0">
                                        <div class="col-md-6 offset-md-4">
                                            <button type="submit" class="btn btn-primary">Atnaujinti</button>    
                                        </div>
                                    </div>   
                                </form>
                            </div>
                        </div>    
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection