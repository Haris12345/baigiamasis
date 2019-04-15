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
                    @if(!isset($teachers[0]->id))
                        <p>Nepridėtas nei vienas dėstytojas</p>
                    @else
                        <table class="table table-responsive(xl)">
                            <tr>
                                <th>Asmens kodas</th>
                                <th>Pareigos</th>
                                <th>Vardas</th>
                                <th>Pavardė</th>
                            </tr>
                            @foreach($teachers as $teacher)
                                <tr>
                                    <td>{{$teacher->identity_code}}</td>
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