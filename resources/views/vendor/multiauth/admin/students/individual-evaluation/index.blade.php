@extends('multiauth::layouts.app') 
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        Individualus studento vertinimas
                        <span class="float-right">
                            <a href="" class="btn btn-sm btn-secondary">Atgal</a>
                        </span>
                    </div>

                    <div class="card-body">
                        @if($semesters[0]->studies_form == 'Nuolatinė')
                            @for($semester=1; $semester<7; $semester++)
                                <div class="list-group">
                                    <a href="{{route('admin.students.individual-evaluation.semester', [$id, $semester])}}" class="list-group-item list-group-item-action">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h5 class="mb-1">{{$semester}} semestras</h5>
                                            <small>...</small>
                                        </div>
                                        <p class="mb-1">Atsiskaitymų skaičius: ... Iš jų laikyti: ...</p>
                                    </a>
                                </div>
                            @endfor
                        @endif

                        @if($semesters[0]->studies_form == 'Ištestinė')
                            @for($semester=1; $semester<9; $semester++)
                                <div class="list-group">
                                    <a href="{{route('admin.students.individual-evaluation.semester', [$id, $semester])}}" class="list-group-item list-group-item-action">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h5 class="mb-1">{{$semester}} semestras</h5>
                                            <small>...</small>
                                        </div>
                                        <p class="mb-1">Atsiskaitymų skaičius: ... Iš jų laikyti: ...</p>
                                    </a>
                                </div>
                            @endfor
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection