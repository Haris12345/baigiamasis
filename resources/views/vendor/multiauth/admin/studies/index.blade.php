@extends('multiauth::layouts.app') 
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        Studiju planai
                        <span class="float-right">
                            <a href="{{route('admin.studies.upload')}}" class="btn btn-sm btn-success">Importuoti studijų planus</a>
                        </span>
                    </div>
                    <div class="card-body">
                        @if(!isset($id_ft->id) && !isset($id_ex->id))
                            <p>Nėra pridėta jokių studijų planų</p>
                        @else
                            @include('multiauth::message')
                            @if(isset($id_ft->id))
                                @foreach($full_time as $ft)
                                    <div class="list-group">
                                        <a href="{{route('admin.studies.show', [$ft->studies_program_code, $ft->studies_form])}}" class="list-group-item list-group-item-action">
                                            <div class="d-flex w-100 justify-content-between">
                                                <h5 class="mb-1">{{$ft->studies_program_name}}</h5>
                                                <small>{{$ft->studies_form}}</small>
                                            </div>
                                            <p class="mb-1">{{$ft->studies_program_code}}</p>
                                        </a>
                                    </div>
                                @endforeach
                            @endif

                            @if(isset($id_ex->id))
                                @foreach($extended as $ex)
                                    <div class="list-group">
                                        <a href="{{route('admin.studies.show', [$ex->studies_program_code, $ex->studies_form])}}" class="list-group-item list-group-item-action">
                                            <div class="d-flex w-100 justify-content-between">
                                                <h5 class="mb-1">{{$ex->studies_program_name}}</h5>
                                                <small>{{$ex->studies_form}}</small>
                                            </div>
                                            <p class="mb-1">{{$ex->studies_program_code}}</p>
                                        </a>
                                    </div>
                                @endforeach
                            @endif
                        @endif
                        {{-- NEEDS PAGINATE --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection