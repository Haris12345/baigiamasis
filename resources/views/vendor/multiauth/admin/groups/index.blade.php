@extends('multiauth::layouts.app') 
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        Grupės
                        <span class="float-right">   
                            <form method="get" action="{{route('admin.groups.search')}}">
                                <div class="input-group">
                                    <button href="{{route('admin.groups')}}" class="btn btn-sm btn-secondary input-group-prepend">Atstatyti</button>
                                    <input name="search" type="text" >
                                    <button type="submit" class="input-group-prepend"><i class="fas fa-search"></i></button>
                                    <a style="margin-left: 10px" href="{{route('admin.groups.new')}}" class="btn btn-sm btn-success">Nauja grupė</a>   
                                </div> 
                            </form>
                        </span>
                    </div>
                    <div class="card-body">
                        @include('multiauth::message')
                        @if(!isset($id->id))
                            <p>Nėra pridėta jokių grupių</p>
                        @else
                            @foreach($groups as $group)
                                <div class="list-group">
                                    <a href="{{route('admin.students.group', $group->group_name)}}" class="list-group-item list-group-item-action">
                                        <div class="d-flex w-100 justify-content-between">
                                            @if($group->studies_form == 'Nuolatinė')
                                                <h5 class="mb-1">{{$group->program_name_ft}}</h5>
                                            @endif
                                            @if($group->studies_form == 'Ištestinė')
                                                <h5 class="mb-1">{{$group->program_name_ex}}</h5>
                                            @endif
                                            <small>{{$group->studies_form}}</small>
                                        </div>
                                        <p class="mb-1">Grupė: {{$group->group_name}} Studentai: {{$group->students}}</p>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif             
@endsection