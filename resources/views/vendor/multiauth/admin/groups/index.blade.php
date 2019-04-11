@extends('multiauth::layouts.app') 
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        Grupės
                        <span class="float-right">
                            <a href="{{route('admin.groups.new')}}" class="btn btn-sm btn-success">Nauja grupė</a>
                        </span>
                    </div>
                    <div class="card-body">
                        @if(!isset($id->id))
                            <p>Nėra pridėta jokių grupių</p>
                        @else
                        @include('multiauth::message')
                        @foreach($groups_ft as $ft)
                            @if(isset($ft->studies_form))
                                <div class="list-group">
                                    <a href="{{route('admin.students.group', $ft->group_name)}}" class="list-group-item list-group-item-action">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h5 class="mb-1">{{$ft->studies_program_name}}</h5>
                                            <small>{{$ft->studies_form}}</small>
                                        </div>
                                        <p class="mb-1">Grupė: {{$ft->group_name}} Studentai: {{$ft->students}}</p>
                                    </a>
                                </div>
                            @endif
                        @endforeach
                        
                        @foreach($groups_ex as $ex)
                            @if(isset($ex->studies_form))
                                <div class="list-group">
                                    <a href="{{route('admin.students.group', $ex->group_name)}}" class="list-group-item list-group-item-action">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h5 class="mb-1">{{$ex->studies_program_name}}</h5>
                                            <small>{{$ex->studies_form}}</small>
                                        </div>
                                        <p class="mb-1">Grupė: {{$ex->group_name}} Studentai: {{$ex->students}}</p>
                                    </a>
                                </div>
                            @endif
                        @endforeach
                        {{-- NEEDS PAGINATE --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif             
@endsection