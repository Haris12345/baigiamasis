@extends('multiauth::layouts.print')
@section('print_sheet')
    <p>
        <center>ALYTAUS KOLEGIJA</center>
        <center>INFORMACIJOS IR RYŠIŲ TECHNOLOGIJŲ FAKULTETAS</center>
    </p>
    <p><center>PAŽANGUMO ŽINIARAŠTIS</center></p>
    
    <table>
        <tr>
            <td style="width: 10%">Grupė</td>
            <td style="width: 25%">{{$course}} {{$group}}</td>
        </tr>
        <tr>
            <td>Semestras</td>
            <td>{{$semester}}</td>
        </tr>
        <tr>
            <td>Dalyko pavadinimas</td>
            <td>{{$subject_name}}</td>
        </tr>
        <tr>
            <td>Dėstytojo vardas, pavardė</td>
            <td>{{$teacher->role}} {{$teacher->name}} {{$teacher->last_name}}</td>
        </tr>
        <tr>
            <td>Vertinimo forma</td>
            <td>{{$evaluation}}</td>
        </tr>
        <tr>
            <td>Atsiskaitymo data</td>
            <td>{{$date}}</td>
        </tr>
    </table>

    <br/>
    <br/>

    <table>
        <tr>
            <td style="width: 2%">Eil Nr.</td>
            <td style="width: 25%"><center>Studento vardas, pavardė</center></td>
            <td style="width: 20%"><center>Įvertinimas</center></td>
            <td><center>Pastabos</center></td>
        </tr>
        <?php $i=1; ?>
        @foreach($students as $student)
            <tr>
                <td>{{$i}}</td>
                <td>{{$student->name}} {{$student->last_name}}</td>
                <td></td>
                <td></td>
                <?php $i++; ?>
            </tr>
        @endforeach
    </table>
    <br/>
    <p style="float: left">{{$year}} m. ............................d.</p>
    <p style="float: right">Parašas ...............................</p>
    <br/>
    <br/>
    <br/>
    <p>
        <div>Grąžinta .......................................</div>
        <div class="date">(Data)</div>
    </p>
    <p>Studijų centras</p>
    <p>{{ auth('admin')->user()->name }}</p>
    <br/>
    .............................................................
    <p style="margin-left: 90px">Parašas</p>
@endsection

