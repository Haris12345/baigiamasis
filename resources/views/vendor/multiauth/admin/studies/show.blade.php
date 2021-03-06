@extends('multiauth::layouts.app') 
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        Studijų plano apžvalga
                        <span class="float-right">
                            <a href="{{route('admin.studies.edit', [$id, $studies_form])}}" class="btn btn-sm btn-primary">Redaguoti</a>
                            <a href="{{route('admin.studies')}}" class="btn btn-sm btn-secondary">Atgal</a>
                        </span>
                    </div>
                    <div class="card-body">
                        @include('multiauth::message')
                        @if($studies_form == 'Nuolatinė')
                            <span class="float-right">  
                                <form method="get" action="{{route('admin.studies.search', [$id, $studies_form])}}">
                                    <div class="input-group">
                                        <button href="{{route('admin.studies.show',  [$id, $studies_form])}}" class="btn btn-sm btn-secondary input-group-prepend">Atstatyti</button>
                                        <input name="search" type="text" >
                                        <button type="submit" class="input-group-prepend"><i class="fas fa-search"></i></button>
                                    </div>     
                                </form>                                        
                            </span>
                            <br></br>
                            <table class="table table-sm table-bordered">
                                <thead>
                                <tr>
                                    <th scope="col">Dalyko pavadinimas</th>
                                    <th colspan="2">1 Semestras</th>
                                    <th colspan="2">2 Semestras</th>
                                    <th colspan="2">3 Semestras</th>
                                    <th colspan="2">4 Semestras</th>
                                    <th colspan="2">5 Semestras</th>
                                    <th colspan="2">6 Semestras</th>
                                    <th scope="col">ECTS kreditai</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($study_plans as $study_plan)
                                        <tr>
                                            <td>{{$study_plan->subject_name}}</td>
                                            <td>{{$study_plan->credits_sem1}}</td>
                                            <td>{{$study_plan->evaluation_type_sem1}}</td>
                                            <td>{{$study_plan->credits_sem2}}</td>
                                            <td>{{$study_plan->evaluation_type_sem2}}</td>
                                            <td>{{$study_plan->credits_sem3}}</td>
                                            <td>{{$study_plan->evaluation_type_sem3}}</td>
                                            <td>{{$study_plan->credits_sem4}}</td>
                                            <td>{{$study_plan->evaluation_type_sem4}}</td>
                                            <td>{{$study_plan->credits_sem5}}</td>
                                            <td>{{$study_plan->evaluation_type_sem5}}</td>
                                            <td>{{$study_plan->credits_sem6}}</td>
                                            <td>{{$study_plan->evaluation_type_sem6}}</td>
                                            <td>{{$study_plan->ECTS_credits}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                        
                        @if($studies_form == 'Ištestinė')
                        <span class="float-right">  
                            <form method="get" action="{{route('admin.studies.search', [$id, $studies_form])}}">
                                <div class="input-group">
                                    <button href="{{route('admin.teachers')}}" class="btn btn-sm btn-secondary input-group-prepend">Atstatyti</button>
                                    <input name="search" type="text" >
                                    <button type="submit" class="input-group-prepend"><i class="fas fa-search"></i></button>
                                </div>     
                            </form>                                        
                        </span>
                        <br></br>
                        <table class="table table-sm table-bordered">
                                <thead>
                                <tr>
                                    <th scope="col">Dalyko pavadinimas</th>
                                    <th colspan="2">1 Semestras</th>
                                    <th colspan="2">2 Semestras</th>
                                    <th colspan="2">3 Semestras</th>
                                    <th colspan="2">4 Semestras</th>
                                    <th colspan="2">5 Semestras</th>
                                    <th colspan="2">6 Semestras</th>
                                    <th colspan="2">7 Semestras</th>
                                    <th colspan="2">8 Semestras</th>
                                    <th scope="col">ECTS kreditai</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($study_plans as $study_plan)
                                        <tr>
                                            <td>{{$study_plan->subject_name}}</td>
                                            <td>{{$study_plan->credits_sem1}}</td>
                                            <td>{{$study_plan->evaluation_type_sem1}}</td>
                                            <td>{{$study_plan->credits_sem2}}</td>
                                            <td>{{$study_plan->evaluation_type_sem2}}</td>
                                            <td>{{$study_plan->credits_sem3}}</td>
                                            <td>{{$study_plan->evaluation_type_sem3}}</td>
                                            <td>{{$study_plan->credits_sem4}}</td>
                                            <td>{{$study_plan->evaluation_type_sem4}}</td>
                                            <td>{{$study_plan->credits_sem5}}</td>
                                            <td>{{$study_plan->evaluation_type_sem5}}</td>
                                            <td>{{$study_plan->credits_sem6}}</td>
                                            <td>{{$study_plan->evaluation_type_sem6}}</td>
                                            <td>{{$study_plan->credits_sem7}}</td>
                                            <td>{{$study_plan->evaluation_type_sem7}}</td>
                                            <td>{{$study_plan->credits_sem8}}</td>
                                            <td>{{$study_plan->evaluation_type_sem8}}</td>
                                            <td>{{$study_plan->ECTS_credits}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection