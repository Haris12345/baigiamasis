@extends('multiauth::layouts.app') 
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Administracinis skydelis</div>

                <div class="card-body">
                    @include('multiauth::message')
                    <div class="row">
                        <div class="col">
                            <div class="card">
                                <div calss="card-body">
                                    <div class="container">
                                        <center><h4 style="margin-top: 20px">Dėstytojų skaičius: {{$teachers}}</h4></center>
                                        <center><a class="btn btn-primary" href="{{ route('admin.teachers') }}">Dėstytojų sąrašas</a></center>
                                        <br/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card">
                                <div calss="card-body">
                                    <div class="container">
                                        <center><h4 style="margin-top: 20px">Studentų skaičius: {{$students}}</h4></center>
                                        <center><a class="btn btn-primary" href="{{ route('admin.students') }}">Studentų sąrašas</a></center>
                                        <br/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br/>
                    <div class="row">
                        <div class="col">
                            <div class="card">
                                <div calss="card-body">
                                    <div class="container">
                                        <center><h4 style="margin-top: 20px">Studijų planai: {{$study_plans}}</h4></center>
                                        <center><a class="btn btn-primary" href="{{ route('admin.studies') }}">Studijų planai</a></center>
                                        <br/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card">
                                <div calss="card-body">
                                    <div class="container">
                                        <center><h4 style="margin-top: 20px"> Grupės: {{$groups}}</h4></center>
                                        <center><a class="btn btn-primary" href="{{ route('admin.groups') }}">Grupės</a></center>
                                        <br/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>       
                </div>
            </div>
        </div>
    </div>
</div>
@endsection