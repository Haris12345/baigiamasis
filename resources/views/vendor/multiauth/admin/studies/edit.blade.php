@extends('multiauth::layouts.app') 
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        Studijų plano redagavimas
                        <span class="float-right">
                                <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#delete">Trinti planą</button>
                                <a href="{{route('admin.studies.show', [$id, $studies_form])}}" class="btn btn-sm btn-secondary">Atgal</a>                      
                        </span>
                    </div>
                    <div class="card-body">
                        @include('multiauth::message')
                        <span class="float-right">
                            <form method="get" action="{{route('admin.studies.edit.search', [$id, $studies_form])}}">
                                <div class="input-group">
                                    <button href="{{route('admin.teachers')}}" class="btn btn-sm btn-secondary input-group-prepend">Atstatyti</button>
                                    <input name="search" type="text" >
                                    <button type="submit" class="input-group-prepend"><i class="fas fa-search"></i></button>
                                </div>     
                            </form>             
                        </span>
                          
                        <form method="post" action="{{route('admin.studies.update')}}">
                            @csrf
                            <button type="submit" class="btn btn-primary">Išsaugoti pakeitimus</button>
                            <br></br>
                            @if($studies_form == 'Nuolatinė')
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
                                                <input type="hidden" name="studies_program_code" value="{{$study_plan->studies_program_code}}">
                                                <input type="hidden" name="studies_form" value="{{$study_plan->studies_form}}">
                                                <input type="hidden" name="subject_code[]" value="{{$study_plan->subject_code}}">
                                                <input type="hidden" name="subject[]" value="{{$study_plan->subject_name}}">
                                                <td>{{$study_plan->subject_name}}</td>
                                                <td><input style="width: 40px" type="number" name="credits[0][]" value="{{$study_plan->credits_sem1}}"></td>
                                                <td><input size="5" type="text" name="evaluation[0][]" value="{{$study_plan->evaluation_type_sem1}}"></td>
                                                <td><input style="width: 40px" type="number" name="credits[1][]" value="{{$study_plan->credits_sem2}}"></td>
                                                <td><input size="5" type="text" name="evaluation[1][]" value="{{$study_plan->evaluation_type_sem2}}"></td>
                                                <td><input style="width: 40px" type="number" name="credits[2][]" value="{{$study_plan->credits_sem3}}"></td>
                                                <td><input size="5" type="text" name="evaluation[2][]" value="{{$study_plan->evaluation_type_sem3}}"></td>
                                                <td><input style="width: 40px" type="number" name="credits[3][]" value="{{$study_plan->credits_sem4}}"></td>
                                                <td><input size="5" type="text" name="evaluation[3][]" value="{{$study_plan->evaluation_type_sem4}}"></td>
                                                <td><input style="width: 40px" type="number" name="credits[4][]" value="{{$study_plan->credits_sem5}}"></td>
                                                <td><input size="5" type="text" name="evaluation[4][]" value="{{$study_plan->evaluation_type_sem5}}"></td>
                                                <td><input style="width: 40px" type="number" name="credits[5][]" value="{{$study_plan->credits_sem6}}"></td>
                                                <td><input size="5" type="text" name="evaluation[5][]" value="{{$study_plan->evaluation_type_sem6}}"></td>
                                                <td>{{$study_plan->ECTS_credits}}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif
                            
                            @if($studies_form == 'Ištestinė')
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
                                                <input type="hidden" name="studies_program_code" value="{{$study_plan->studies_program_code}}">
                                                <input type="hidden" name="studies_form" value="{{$study_plan->studies_form}}">
                                                <input type="hidden" name="subject_code[]" value="{{$study_plan->subject_code}}">
                                                <input type="hidden" name="subject[]" value="{{$study_plan->subject_name}}">
                                                <td>{{$study_plan->subject_name}}</td>
                                                <td><input style="width: 40px" type="number" name="credits[0]" value="{{$study_plan->credits_sem1}}"></td>
                                                <td><input size="4" type="text" name="evaluation[0]" value="{{$study_plan->evaluation_type_sem1}}"></td>
                                                <td><input style="width: 40px" type="number" name="credits[1]" value="{{$study_plan->credits_sem2}}"></td>
                                                <td><input size="4" type="text" name="evaluation[1]" value="{{$study_plan->evaluation_type_sem2}}"></td>
                                                <td><input style="width: 40px" type="number" name="credits[2]" value="{{$study_plan->credits_sem3}}"></td>
                                                <td><input size="4" type="text" name="evaluation[2]" value="{{$study_plan->evaluation_type_sem3}}"></td>
                                                <td><input style="width: 40px" type="number" name="credits[3]" value="{{$study_plan->credits_sem4}}"></td>
                                                <td><input size="4" type="text" name="evaluation[3]" value="{{$study_plan->evaluation_type_sem4}}"></td>
                                                <td><input style="width: 40px" type="number" name="credits[4]" value="{{$study_plan->credits_sem5}}"></td>
                                                <td><input size="4" type="text" name="evaluation[4]" value="{{$study_plan->evaluation_type_sem5}}"></td>
                                                <td><input style="width: 40px" type="number" name="credits[5]" value="{{$study_plan->credits_sem6}}"></td>
                                                <td><input size="4" type="text" name="evaluation[5]" value="{{$study_plan->evaluation_type_sem6}}"></td>
                                                <td><input style="width: 40px" type="number" name="credits[6]" value="{{$study_plan->credits_sem7}}"></td>
                                                <td><input size="4" type="text" name="evaluation[6]" value="{{$study_plan->evaluation_type_sem7}}"></td>
                                                <td><input style="width: 40px" type="number" name="credits[7]" value="{{$study_plan->credits_sem8}}"></td>
                                                <td><input size="4" type="text" name="evaluation[7]" value="{{$study_plan->evaluation_type_sem8}}"></td>
                                                <td>{{$study_plan->ECTS_credits}}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif
                        </form>     
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="delete" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4>Trinti planą</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>   
                </div>
                <div class="modal-body">
                    <p>Studijų planas: {{$study_plans[0]->studies_program_name}}</p> 
                </div>
                <div class="modal-footer">
                    <form method="post" action="{{route('admin.studies.delete', [$id, $studies_form])}}">
                        @csrf
                            <button type="submit" class="btn btn-danger">Trinti</button>
                    </form>
                
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Uždaryti</button>
                </div>
            </div>
        </div>
    </div>
@endsection