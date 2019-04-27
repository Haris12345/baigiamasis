@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Studento pagrindinis puslapis</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif                    
                    <div class="row">
                        <div class="col">
                            <div class="card">
                                <div calss="card-body">
                                    <div class="container">
                                        <center><h4 style="margin-top: 20px">Paskutiniai atsiskaitymai</h4></center>
                                        <div class="list-group"> 
                                            @if($exams != NULL)
                                                @foreach($exams as $exam)
                                                    <div class="d-flex w-100 justify-content-between">
                                                        <h5>{{$exam->subject_name}}</h5>
                                                        <h5>{{$exam->mark}}</h5>
                                                    </div>
                                                @endforeach
                                            @else
                                                <center><p>Kolkas nelaikytas nei vienas egzaminas</p></center>
                                            @endif
                                        </div>
                                            
                                        </il>
                                        <center><a class="btn btn-primary" href="{{ route('overview') }}">Peržiūrėti visus atsiskaitymus</a></center>
                                        <br/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card">
                                <div calss="card-body">
                                    <div class="container">
                                        <center><h4 style="margin-top: 20px">Skolų skaičius: {{$debts}}</h4></center>
                                        <center><a class="btn btn-primary" href="{{route('debts')}}">Visos skolos</a></center>
                                        <br/>
                                    </div>
                                </div>
                            </div>
                            <br/>
                            <div class="card">
                                <div calss="card-body">
                                    <div class="container">
                                        <center><h4 style="margin-top: 20px">Bendras vidurkis: </h4></center>
                                        <center><a class="btn btn-primary" href="">Plačiau</a></center>
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
