{{-- @extends('multiauth::layouts.app') 
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-info text-white">Pridėti naują rolę</div>

                <div class="card-body">
    @include('multiauth::message')
                    <form action="{{ route('admin.role.store') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="role">Rolės pavadinimas</label>
                            <input type="text" placeholder="Rolė" name="name" class="form-control" id="role" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm">Įrašyti</button>
                        <a href="{{ route('admin.roles') }}" class="btn btn-sm btn-secondary float-right">Atgal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection --}}