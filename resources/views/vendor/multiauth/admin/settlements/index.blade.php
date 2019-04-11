@extends('multiauth::layouts.app') 
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        Studentų sąrašas
                        <span class="float-right">
                            <a href="{{route('admin.students.new', $group)}}" class="btn btn-sm btn-success">Naujas studentas</a>
                        </span>
                    </div>

                    <div class="card-body">
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection