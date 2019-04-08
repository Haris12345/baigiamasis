@extends('multiauth::layouts.app') 
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        Grupės
                        <span class="float-right">
                            <a href="{{route('admin.groups.new')}}" class="btn btn-sm btn-success">Nauja grupė</a>
                        </span>
                    </div>
                    <div class="card-body">
                        @if(!isset($id->id))
                            <p>Nėra pridėta jokių grupių</p>
                        @else
                        @include('multiauth::message')
                        <table class="table table-responsive(xl)">
                            <tr>
                                <th>Grupės trumpinimas</th>
                                <th>Studijų programa</th>
                                <th>Studijų forma</th>
                                <th>Studentų kiekis</th>
                                <th>Veiksmai</th>
                            </tr>
                            @foreach($groups as $group)
                            <tr>
                                <td>{{$group->group_name}}</td>
                                <td>{{$group->studies_program}}</td>
                                <td>{{$group->studies_form}}</td>
                                <td>{{$group->students}}</td>
                                <td>
                                <!--<button type="submit" class="btn btn-sm btn-danger" onCLick="perspejimas()">Ištrinti</button>-->
                                <a href="{{route('admin.students', $group->id)}}" class="btn btn-sm btn-primary">Peržiūrėti</a>
                                </td>
                            </tr>
                            @endforeach
                        </table>
                        {{$groups->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- <script>
        function perspejimas(){
            $('#modal').modal('show');
        }
    </script>
   
   <div id="modal" class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">ĮSPĖJIMAS!</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                    Trinant šią studijų programą bus panaikinti visi su ja susieti studentai. Ar tikrai norite trinti?
            </div>
            <div class="modal-footer">
            <form method="POST" action="{{route('admin.studies.delete', $stud->id)}}">
                @csrf
                @method('DELETE')
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Atšaukti</button>
                <button type="submit" class="btn btn-danger">Vistiek trinti</button>
            </form> --}}
            @endif   
            </div>
          </div>
        </div>
      </div>

@endsection