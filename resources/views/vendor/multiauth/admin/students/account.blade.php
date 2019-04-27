@extends('multiauth::layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        Studento paskyra
                        <span class="float-right">
                                <a href="{{route('admin.students')}}" class="btn btn-sm btn-secondary">Visi studentai</a>
                                <a href="{{route('admin.students.group', $student->group)}}" class="btn btn-sm btn-secondary">Grupės studentai</a>
                        </span>
                    </div>
                    <div class="card-body">
                        @include('multiauth::message')
                        @if(isset($account))
                            <h3>Šio studento paskyra paruošta</h3>
                            <p>El. paštas: {{$student->email}}</p>
                            @if($account->active == 1)
                                <p>Paskyros statusas: aktyvuota</p>
                                <form method="POST" action="{{ route('admin.students.account.update') }}">
                                    @csrf

                                    <div class="form-group row">
                                        <label for="active" class="col-md-4 col-form-label text-md-right">Paskyra aktyvi</label>
                                        <div class="col-md-6">
                                            <input type="hidden" name="student" value="{{$student->id}}">
                                            <input checked type="checkbox" class="form-control" name="active" value=1>
                                        </div>                   
                                    </div>
                                    <span class="float-right">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="far fa-edit"></i> {{ __('Keisti') }}
                                        </button>
                                    </span>
                                </form>
                            @endif
                            @if($account->active == 0)
                                <p>Paskyros statusas: neaktyvuota</p>
                                <form method="POST" action="{{ route('admin.students.account.update') }}">
                                    @csrf

                                    <div class="form-group row">
                                        <label for="active" class="col-md-4 col-form-label text-md-right">Paskyra aktyvi</label>
                                        <div class="col-md-6">
                                            <input type="hidden" name="student" value="{{$student->id}}">
                                            <input type="checkbox" class="form-control" name="active" value=1>
                                        </div>                   
                                    </div>
                                    <span class="float-right">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="far fa-edit"></i> {{ __('Keisti') }}
                                        </button>
                                    </span>
                                </form>
                            @endif
                            <span class="float-left">
                                <form method="post" action="{{route('admin.students.account.delete')}}">
                                    @csrf
                                    <input type="hidden" name="student" value="{{$student->id}}">
                                    <button type="submit"class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i> Trinti</button>
                                </form>
                            </span>
                        @else
                            <h3>Studentas: {{$student->name}} {{$student->last_name}}</h3>
                            <p>El. paštas: {{$student->email}}</p>
                            <p>Paskyros statusas: neparuošta</p>
                            <form method="get" action="{{ route('admin.students.account.new', $student->id) }}">
                                @csrf
                                <div class="form-group row">
                                    <generate-password></generate-password>
                                </div>
                            
                                <div class="form-group row mb-0">
                                    <div class="col-md-6 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('Sukurti') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection