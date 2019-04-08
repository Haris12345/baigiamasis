@extends('multiauth::layouts.app') 
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Administracinis skydelis</div>

                <div class="card-body">
                @include('multiauth::message')
                     Jūs prisijungėte prie administracinės aplinkos!
                </div>
            </div>
        </div>
    </div>
</div>
@endsection