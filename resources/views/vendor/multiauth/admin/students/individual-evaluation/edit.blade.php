@extends('multiauth::layouts.app') 
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Koreguoti egzaminą studentui
                    <span class="float-right">
                        <a href="{{route('admin.students.individual-evaluation.semester', [$group, $id, $semester, $subject_code])}}" class="btn btn-sm btn-secondary">Atgal</a>
                    </span>
                </div>
                
                <div class="card-body">
                    <h3>Egzamino koregavimas studentui: {{$student->name}} {{$student->last_name}}</h3>
                    <p>Dalykas: {{$exam->subject_name}}</p>
                    <form method="POST" action="{{ route('admin.students.individual-evaluation.update', [$group, $id, $semester, $subject_code]) }}">
                        @csrf

                        <div class="form-group row">
                            <label for="studies_form" class="col-md-4 col-form-label text-md-right">{{ __('Dėstytojas') }}</label>
        
                            <div class="col-md-6">
                                <select class="form-control" name="teacher_id">
                                    @foreach($teachers as $teacher)
                                        <option value="{{$teacher->id}}">{{$teacher->name}} {{$teacher->last_name}}</option>
                                    @endforeach
                                    @foreach($teachers as $teacher)
                                        @if($exam->teacher_id == $teacher->id)
                                            <option selected value="{{$teacher->id}}">{{$teacher->name}} {{$teacher->last_name}}</option>
                                        @endif
                                        @if($exam->teacher_id != $teacher->id)
                                            <option value="{{$teacher->id}}">{{$teacher->name}} {{$teacher->last_name}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="date" class="col-md-4 col-form-label text-md-right">{{ __('Egzamino data') }}</label>

                            <div class="col-md-6">                                    
                                <input value="{{$exam->date}}" class="form-control" type="text" name="date" placeholder="mmmm-mm-dd" required 
                                    pattern="(?:19|20)[0-9]{2}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-9])|(?:(?!02)(?:0[1-9]|1[0-2])-(?:30))|(?:(?:0[13578]|1[02])-31))" 
                                    title="Įveskite datą šiuo formatu: mmmm-mm-dd"/>
                            </div>
                        </div>

                        <div class="form-group row">
                            <input type="hidden" name="student_id" value="{{$id}}">
                            <label for="mark" class="col-md-4 col-form-label text-md-right">Pažymys</label>

                            <div class="col-md-6">
                                <select class="form-control" name="mark">
                                    <option selected value={{$exam->mark}}>{{$exam->mark}}</option>
                                    <option value="Neatestuotas">Neatestuotas</option>
                                    <option value="Neatvyko">Neatvyko</option>
                                    @for($i=1; $i<11; $i++)
                                        <option value={{$i}}>{{$i}}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">

                            <label for="comments" class="col-md-4 col-form-label text-md-right">Pastabos</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" value="{{$exam->comments}}" name="comments">
                            </div>
                        </div>     
                            
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
@endsection