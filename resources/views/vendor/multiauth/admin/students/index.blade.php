@extends('multiauth::layouts.app') 
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    @if(isset($group))
                        {{$group}} Studentų sąrašas
                        <span class="float-right">
                            <a href="{{route('admin.students.new', $group)}}" class="btn btn-sm btn-success">Naujas studentas</a>
                            <a href="{{route('admin.groups')}}" class="btn btn-sm btn-secondary">Atgal</a>
                        </span>
                    @else
                        Studentų sąrašas
                        <span class="float-right">
                            <a href="{{route('admin.students.upload')}}" class="btn btn-sm btn-success">Importuoti studentų sąrašą</a>
                        </span>
                    @endif
                </div>
                <div class="card-body">
                    @include('multiauth::message')
                    @if(isset($group))
                        <div class="card">
                            <div class="card-body">
                                <span class="float-right">
                                    <a href="{{route('admin.settlements', $group) }}" class="btn btn-primary">Grupės atsiskaitymai</a>
                                </span>
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal">Kurti grupės paskyras</button>
                                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#semester">Kelti grupę į kitą semestrą</button>                               
                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#disable-accounts">Išjungti grupės paskyras</button>                               
                            </div>                           
                        </div>
                    @endif
                    @if(!isset($group))                       
                        <div class="card">
                            <div class="card-body">
                                <span class="float-left">
                                    <form method="get" action="{{route('admin.students.filter')}}">
                                        <label for="semester">Semestras</label>
                                        <select name="semester">
                                            <option value="0">Rodyti viską</option>
                                            @if(isset($semester) && $semester != "0")
                                                <option selected>{{$semester}}</option>
                                            @endif
                                            @for($i=1; $i<9; $i++)
                                                <option value="{{$i}}">{{$i}}</option>
                                            @endfor
                                        </select>
                                
                                        <label for="studies_form">Studijų forma</label>
                                        <select name="studies_form">
                                            <option value="0">Rodyti viską</option>
                                            @if(isset($semester) && $studies_form != "0")
                                                <option selected>{{$studies_form}}</option>
                                            @endif
                                            <option value="Nuolatinė">Nuolatinė</option>
                                            <option value="Ištestinė">Ištestinė</option>
                                        </select>
                                        
                                        <label for="status">Studijų būsena</label>
                                        <select name="status">
                                            @if(isset($semester) && $status != "0")
                                                <option selected>{{$status}}</option>
                                            @endif
                                            <option value="0">Rodyti viską</option>
                                            <option value="Studijuoja" >Studijuoja</option>
                                            <option value="Nutrauktos studijos" >Nutrauktos studijos</option>
                                            <option value="Pertrauktos studijos" >Pertrauktos studijos</option>
                                            <option value="Užbaigtos studijos" >Užbaigtos studijos</option>
                                            <option value="Išvykęs į dalines studijas" >Išvykęs į dalines studijas</option>
                                            <option value="Atvykęs dalinėms studijoms" >Atvykęs dalinėms studijoms</option>
                                        </select>
    
                                        <button type="submit" class="btn btn-sm btn-success">Pritaikyti</button>
                                        <a href="{{route('admin.students')}}" class="btn btn-sm btn-secondary">Atstatyti</a>
                                    </form>
                                </span>
                                
                                <span class="float-right">
                                    <form method="get" action="{{route('admin.students.search')}}">
                                        <div class="input-group">
                                            <input name="search" type="text" >
                                            <button type="submit" class="input-group-prepend"><i class="fas fa-search"></i></button>
                                        </div>     
                                    </form>                                        
                                </span>
                            </div>
                        </div>
                    @endif
                    @if(!isset($id->id))
                        <p>Studentų nerasta</p>
                    @else

                        <table class="table table-responsive(xl)">
                            <th>Asmens kodas</th>
                            <th>Vardas</th>
                            <th>Pavardė</th>
                            <th>Semestras</th>
                            <th>Studijų forma</th>
                            <th>Statusas</th>
                            <th>Veiksmai</th>

                            @foreach($students as $student)
                            <tr>
                                <td>{{$student->identity_code}}</td>
                                <td>{{$student->name}}</td>
                                <td>{{$student->last_name}}</td>
                                <td>{{$student->semester}}</td>
                                <td>{{$student->studies_form}}</td>
                                <td>{{$student->status}}</td>
                                <td>
                                    <a href="{{route('admin.students.account', $student->id)}}" class="btn btn-sm btn-primary">Paskyra</a>
                                    <a href="{{route('admin.students.show', $student->id)}}" class="btn btn-sm btn-primary">Informacija</a>
                                    <a href="{{route('admin.students.individual-evaluation', [$student->group, $student->id])}}" class="btn btn-sm btn-primary">Pažangumas</a>
                                </td>
                            </tr>
                            @endforeach
                        </table>
                        {{$students->links()}}
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@if(isset($group))
    <div id="disable-accounts" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4>Išjungti paskyrų prieigą studentams</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>   
                </div>
                <div class="modal-body">
                    <p>Grupės {{$group}} studentų paskyros bus išjungtos</p> 
                    <ul>                  
                        @foreach($students as $student)
                            <li>{{$student->name}} {{$student->last_name}}</li>
                        @endforeach
                    </ul>
                </div>
                <div class="modal-footer">
                    <form method="post" action="{{route('admin.students.disableAcc', $group)}}">
                        @csrf
                        <button type="submit" class="btn btn-danger">Išjungti paskyras</button>
                    </form>
                
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Uždaryti</button>
                </div>
            </div>
        </div>
    </div>
    <div id="semester" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4>Keisti semestrus</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>   
                </div>
                <div class="modal-body">
                    <p>Grupės {{$group}} studentai bus perkeliami į kitą semestrą</p> 
                    <ul>                  
                        @foreach($students as $student)
                            <li>{{$student->name}} {{$student->last_name}}</li>
                        @endforeach
                    </ul>
                </div>
                <div class="modal-footer">
                    <form method="post" action="{{route('admin.students.changeSemester', $group)}}">
                        @csrf
                        <button type="submit" class="btn btn-success">Keisti semestrus</button>
                    </form>
                
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Uždaryti</button>
                </div>
            </div>
        </div>
    </div>
@endif
@if(isset($students_no_acc))
    <div id="modal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4>Kurti paskyras</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>   
                </div>
                <div class="modal-body">
                    <p>Paskyros bus sukurtos šiems studentams</p> 
                    <ul>                  
                        @foreach($students_no_acc as $student)
                            <li>{{$student->name}} {{$student->last_name}}</li>
                        @endforeach
                    </ul>
                </div>
                <div class="modal-footer">
                    <form method="post" action="{{route('admin.students.account.groupGenerate')}}">
                        @csrf
                        <input type="hidden" name="group" value="{{$group}}">
                        <input type="hidden" name="students[]" value="{{$students_no_acc}}">
                        <button type="submit" class="btn btn-success">Generuoti paskyras</button>
                    </form>
                
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Uždaryti</button>
                </div>
            </div>
        </div>
    </div>
@endif
@endsection