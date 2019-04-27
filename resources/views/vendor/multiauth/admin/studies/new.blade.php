@extends('multiauth::layouts.app') 
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        Rankinis studijų planų pridėjimas
                        <span class="float-right">
                            <a href="{{route('admin.studies')}}" class="btn btn-sm btn-secondary">Atgal</a>
                        </span>
                    </div>
                    <div class="card-body">
                        @include('multiauth::message')
                        <div id="app">
                            <form method="post" action="{{route('admin.studies.create')}}">
                                @csrf
                                <study-plans></study-plans>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection