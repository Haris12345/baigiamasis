@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Skolos</div>

                <div class="card-body">
                    <div id="app">
                        @if(count($debts) == 0)
                            <h5><center>Skolų nėra</center></h5>
                        @else
                            <table class="table table-responsive(xl)">
                                <tr>
                                    <th>Dalykas</th>
                                    <th>Semestras</th>
                                    <th>Kreditai</th>
                                    <th>Atsiskaitymo forma</th>
                                    <th>Skolos kaina</th>
                                    <th>Ar apmokėta skola</th>
                                </tr>

                                @foreach ($debts as $debt)
                                    <tr>
                                        <td>{{$debt->subject_name}}</td>
                                        <td>{{$debt->semester}}</td>
                                        <td>{{$debt->credits}}</td>
                                        <td>{{$debt->evaluation_type}}</td>
                                        <td>
                                            @if($debt->debt_price == NULL)
                                                Nepaskirta
                                            @else
                                                {{$debt->debt_price}}
                                            @endif
                                        </td>
                                        <td>
                                            @if($debt->debt_paid == 0)
                                                Neapmokėta
                                            @endif
                                            @if($debt->debt_paid == 1)
                                                Apmokėta
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
