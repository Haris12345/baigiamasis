@extends('multiauth::layouts.app') 
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Administratorių Sąrašas
                    <span class="float-right">
                        <a href="{{route('admin.register')}}" class="btn btn-sm btn-success">Naujas administratorius</a>
                    </span>
                </div>
                <div class="card-body">
    @include('multiauth::message')
                    <ul class="list-group">
                        @foreach ($admins as $admin)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ $admin->name }}
                            <span class="badge">
                                    @foreach ($admin->roles as $role)
                                        <span class="badge-warning badge-pill ml-2">
                                            {{ $role->name }}
                                        </span> @endforeach
                            </span>
                            {{ $admin->active? 'Aktyvus' : 'Neaktyvus' }}
                            <div class="float-right">
                                <a href="#" class="btn btn-sm btn-danger mr-3" onclick="event.preventDefault(); document.getElementById('delete-form-{{ $admin->id }}').submit();">Trinti</a>
                                <form id="delete-form-{{ $admin->id }}" action="{{ route('admin.delete',[$admin->id]) }}" method="POST" style="display: none;">
                                    @csrf @method('delete')
                                </form>

                                <a href="{{route('admin.edit',[$admin->id])}}" class="btn btn-sm btn-primary mr-3">Keisti</a>
                            </div>
                        </li>
                        @endforeach @if($admins->count()==0)
                        <p>Nei vieno {{ config('multiauth.prefix') }} nesukurta dar. Tik super {{ config('multiauth.prefix') }} prieinamas.</p>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection