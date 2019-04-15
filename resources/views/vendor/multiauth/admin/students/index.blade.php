@extends('multiauth::layouts.app') 
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    {{$group}} Studentų sąrašas
                    <span class="float-right">
                        @if(isset($group))
                            <a href="{{route('admin.settlements', $group) }}" class="btn btn-sm btn-primary">Grupės atsiskaitymai</a>
                        @endif
                        <a href="{{route('admin.students.new', $group)}}" class="btn btn-sm btn-success">Naujas studentas</a>
                    </span>
                </div>
                <div class="card-body">
                    @if(!isset($id->id))
                        <p>Nepridėtas nei vienas studentas</p>
                    @else
                        @include('multiauth::message')

                        <table class="table table-responsive(xl)">
                            <th>Asmens kodas</th>
                            <th>Vardas</th>
                            <th>Pavardė</th>
                            <th>El. Paštas</th>
                            <th>Statusas</th>
                            <th>Veiksmai</th>

                            @foreach($students as $student)
                            <tr>
                                <td>{{$student->identity_code}}</td>
                                <td>{{$student->name}}</td>
                                <td>{{$student->last_name}}</td>
                                <td>{{$student->email}}</td>
                                <td>{{$student->status}}</td>
                                <td>
                                    <a href="{{route('admin.students.account', $student->id)}}" class="btn btn-sm btn-primary">Paskyra</a>
                                    <a href="{{route('admin.students.show', $student->id)}}" class="btn btn-sm btn-primary">Informacija</a>
                                    <a href="{{route('admin.students.individual-evaluation', [$group, $student->id])}}" class="btn btn-sm btn-primary">Pažangumas</a>
                                </td>
                            </tr>
                            @endforeach
                        </table>
                        {{$students->links()}}
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection