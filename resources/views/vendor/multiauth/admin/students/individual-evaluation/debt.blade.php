@extends('multiauth::layouts.app') 
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Skolos tvarkymas studentui
                    <span class="float-right">
                        <a href="{{route('admin.students.individual-evaluation.semester', [$group, $id, $semester, $subject_code])}}" class="btn btn-sm btn-secondary">Atgal</a>
                    </span>
                </div>
                
                <div class="card-body">
                    @include('multiauth::message')
                    <h3>Studentas: {{$student->name}} {{$student->last_name}}</h3>
                    <p>Dalykas:
                        @if($exam->settlement_type == 'prj.')
                            {{$exam->subject_name}} praktika
                        @else
                            {{$exam->subject_name}}
                        @endif
                    </p>
                    @if($exam->debt_paid == 1)
                        <?php $exam->debt_paid = 'apmokėta' ?>
                    @else
                        <?php $exam->debt_paid = 'neapmokėta' ?>
                    @endif
                    <p>
                        šiuo metu skolos kaina: 
                        @if($exam->debt_price == NULL)
                            Nepaskirta
                        @else
                            {{$exam->debt_price}} Eur. {{$exam->debt_paid}}
                        @endif
                    </p>
                    <form method="POST" action="{{ route('admin.students.individual-evaluation.debtUpdate') }}">
                        @csrf
                        <div class="form-group row">
                            <label for="comments" class="col-md-4 col-form-label text-md-right">Skolos suma (Eurais)</label>
                            <div class="col-md-6">
                                <input type="number" class="form-control" name="sum">
                                <input type="hidden" class="form-control" name="semester" value="{{$semester}}">
                                <input type="hidden" class="form-control" name="group" value="{{$group}}">
                                <input type="hidden" class="form-control" name="subject_code" value="{{$subject_code}}">
                                <input type="hidden" class="form-control" name="student_id" value="{{$student->id}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="paid" class="col-md-4 col-form-label text-md-right">Skola apmokėta</label>
                            <div class="col-md-6">
                                <input type="checkbox" class="form-control" name="paid" value=1>
                            </div>                   
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">Atnaujinti</button>    
                            </div>
                        </div>   
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection