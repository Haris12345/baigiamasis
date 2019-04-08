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
                        @foreach($full_time as $ft)
                        <div class="list-group">
                            <a href="{{route('admin.studies.show', $ft->studies_program_code)}}" class="list-group-item list-group-item-action">
                                <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-1">{{$ft->studies_program_name}}</h5>
                                    <small>{{$ft->studies_form}}</small>
                                </div>
                                <p class="mb-1">{{$ft->studies_program_code}}</p>
                            </a>
                        </div>

                        @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection