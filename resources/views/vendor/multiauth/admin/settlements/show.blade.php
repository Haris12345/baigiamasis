@extends('multiauth::layouts.app') 
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        {{$group}} grupės vertinimai
                        <span class="float-right">
                            <a href="{{route('admin.settlements', $group)}}" class="btn btn-sm btn-secondary">Atgal</a>
                        </span>
                    </div>

                    <div class="card-body">
                        @include('multiauth::message')
                        
                        <span class="float-right">
                            <form method="post" action="{{route('admin.settlements.print.exam')}}" target="_blank">
                                @csrf
                                <label for="date" class="col-form-label text-md-right">{{ __('Egzamino data') }}</label>       
                                <input class="form-control" type="text" name="date" placeholder="mmmm-mm-dd" required 
                                    pattern="(?:19|20)[0-9]{2}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-9])|(?:(?!02)(?:0[1-9]|1[0-2])-(?:30))|(?:(?:0[13578]|1[02])-31))" 
                                    title="Įveskite datą šiuo formatu: mmmm-mm-dd"/>
                                <br>
                                <input type="hidden" name="semester" value="{{$semester}}">
                                <input type="hidden" name="subject_name" value="{{$subject->subject_name}}">
                                <input type="hidden" name="teacher_id" value="{{$teacher->teacher_id}}">
                                <input type="hidden" name="evaluation_type" value="{{$evaluation_type}}">
                                <input type="hidden" name="group" value="{{$group}}">
                                <input type="hidden" name="studies_form" value="{{$subject->studies_form}}">
                                @foreach( $students as $student )
                                    <input type="hidden" name="student_id[]" value="{{$student->id}}">
                                @endforeach
                                <button type="submit" class="btn btn-primary">Spausdinti žiniaraštį</button>
                            </form>
                        </span>
                        <h3>Dalykas: 
                            @if($subject->evaluation_type == 'prj.')
                                {{$subject->subject_name}} praktika
                            @else
                                {{$subject->subject_name}}
                            @endif    
                        </h3>
                        <p>Kreditai: {{$credits}}</p>
                        <p>Atsiskaitymo forma: {{$evaluation_type}}</p>
                        <p>Atsiskaitymo semestras: {{$semester}}</p>
                        <p>Dalyko dėstytojas: {{$teacher->teacher_name}} {{$teacher->teacher_last_name}}</p>
                        <p>Svarbu! Pastabų raktiniai žodžiai: Perlaikymas, Skola</p>
                        <form method="POST" action="{{route('admin.settlements.create')}}">
                            @csrf
                            <input type="hidden" name="semester" value="{{$semester}}">
                            <input type="hidden" name="studies_program_code" value="{{$subject->studies_program_code}}">
                            <input type="hidden" name="subject_code" value="{{$subject->subject_code}}">
                            <input type="hidden" name="subject_name" value="{{$subject->subject_name}}">
                            <input type="hidden" name="teacher_id" value="{{$teacher->teacher_id}}">
                            <input type="hidden" name="evaluation_type" value="{{$evaluation_type}}">
                            <input type="hidden" name="group" value="{{$group}}">
                            <input type="hidden" name="studies_form" value="{{$subject->studies_form}}">
                            <div class="form-group row">
                                <label for="date" class="col-md-4 col-form-label text-md-right">{{ __('Egzamino data') }}</label>

                                <div class="col-md-6">                                    
                                    <input class="form-control" type="text" name="date" placeholder="mmmm-mm-dd" required 
                                        pattern="(?:19|20)[0-9]{2}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-9])|(?:(?!02)(?:0[1-9]|1[0-2])-(?:30))|(?:(?:0[13578]|1[02])-31))" 
                                        title="Įveskite datą šiuo formatu: mmmm-mm-dd"/>
                                </div>
                            </div>
                            @foreach( $students as $student )
                                <div class="form-group row">
                                    <input type="hidden" name="student_id[]" value="{{$student->id}}">
                                    <label for="mark" class="col-md-4 col-form-label text-md-right">{{$student->name}} {{$student->last_name}}</label>
        
                                    <div class="col-md-6">
                                        <select class="form-control" name="mark[]">
                                            <option value=0>Įvertinimas</option>
                                            <option value="Neatvyko">Neatvyko</option>
                                            <option value="Neatestuotas">Neatestuotas</option>
                                            @for($i=1; $i<11; $i++)
                                                <option value={{$i}}>{{$i}}</option>
                                            @endfor
                                        </select>
                                    </div>

                                    <label for="comments" class="col-md-4 col-form-label text-md-right">Pastabos</label>

                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="comments[]">
                                    </div>
                                </div>     
                            @endforeach  
                            
                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Vertinti') }}
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