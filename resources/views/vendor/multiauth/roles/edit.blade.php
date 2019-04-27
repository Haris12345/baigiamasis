{{-- @extends('multiauth::layouts.app') 
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Redaguoti rolę</div>

                <div class="card-body">
                    <form action="{{ route('admin.role.update', $role->id) }}" method="post">
                        @csrf @method('patch')
                        <div class="form-group">
                            <label for="role">Rolės pavadinimas</label>
                            <input type="text" value="{{ $role->name }}" name="name" class="form-control" id="role">
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm">Keisti</button>
                        <a href="{{ route('admin.roles') }}" class="btn btn-secondary btn-sm float-right">Atgal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection --}}