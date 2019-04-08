@extends('multiauth::layouts.app') 
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Studentų sąrašas
                    <span class="float-right">
                        <a href="{{route('admin.students.new')}}" class="btn btn-sm btn-success">Naujas studentas</a>
                    </span>
                </div>
                <div class="card-body">
                    @if(!isset($id->id))
                        <p>Nepridėtas nei vienas studentas</p>
                    @else
                    @include('multiauth::message')
                    <table class="table table-responsive(xl)">
                        <th>Vardas</th>
                        <th>Pavardė</th>
                        <th>Studijų programa</th>
                        <th>Veiksmai</th>
                        @foreach($students as $student)
                        <tr>
                            <td>{{$student->name}}</td>
                            <td>{{$student->last_name}}</td>
                            <td>{{$student->study_program_abrv}}</td>
                            <td>
                                <form method="POST" action="{{route('admin.students.delete', $student->id)}}">
                                    @csrf
                                    @method('DELETE')
                                    <a href="{{route('admin.students.account', $student->id)}}" class="btn btn-sm btn-primary">Paskyra</a>
                                    <a href="{{route('admin.students.show', $student->id)}}" class="btn btn-sm btn-primary">Peržiūrėti</a>
                                    <button type="submit" class="btn btn-sm btn-danger">Ištrinti</button>
                                </form>
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