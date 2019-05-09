@extends('multiauth::layouts.app') 
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Dėstytojų sąrašas
                    <span class="float-right">
                        <a href="{{route('admin.teachers.upload')}}" class="btn btn-sm btn-primary">Importuoti iš failo</a>
                        <a href="{{route('admin.teachers.new')}}" class="btn btn-sm btn-success">Naujas dėstytojas</a>
                    </span>
                </div>
                <div class="card-body">
                    @include('multiauth::message')
                    <span class="float-right">  
                        <form method="get" action="{{route('admin.teachers.search')}}">
                            <div class="input-group">
                                <button href="{{route('admin.teachers')}}" class="btn btn-sm btn-secondary input-group-prepend">Atstatyti</button>
                                <input name="search" type="text" >
                                <button type="submit" class="input-group-prepend"><i class="fas fa-search"></i></button>
                            </div>     
                        </form>                                        
                    </span>
                    <br></br>
                    @if(!isset($teachers[0]->id))
                        <p>Dėstytojų nerasta</p>
                    @else
                        <table class="table table-responsive(xl)">
                            <tr>
                                <th>Gimimo data</th>
                                <th>Pareigos</th>
                                <th>Vardas</th>
                                <th>Pavardė</th>
                            </tr>
                            @foreach($teachers as $teacher)
                                <tr>
                                    <td>{{$teacher->birth_date}}</td>
                                    <td>{{$teacher->role}}</td>
                                    <td>{{$teacher->name}}</td>
                                    <td>{{$teacher->last_name}}</td>
                                </tr>
                            @endforeach
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection