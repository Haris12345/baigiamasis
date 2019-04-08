@extends('multiauth::layouts.app') 
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        Studijų programų sąrašas
                        <span class="float-right">
                            <a href="{{route('admin.studies.new')}}" class="btn btn-sm btn-success">Nauja studijų programa</a>
                        </span>
                    </div>
                    <div class="card-body">
                        @if(!isset($id->id))
                            <p>Nėra pridėta jokių studijų programų</p>
                        @else
                        @include('multiauth::message')
                        <table class="table table-responsive(xl)">
                            <tr>
                                <th>ID</th>
                                <th>Studijų programos trumpinimas</th>
                                <th>Studijų prgrama</th>
                                <th>Studijų forma</th>
                                <th>Veiksmai</th>
                            </tr>
                            @foreach($studies as $stud)
                            <tr>
                                <td>{{$stud->id}}</td>
                                <td>{{$stud->study_program_abrv}}</td>
                                <td>{{$stud->study_program}}</td>
                                <td>{{$stud->study_form}}</td>
                                <td>
                                    <!--<button type="submit" class="btn btn-sm btn-danger" onCLick="perspejimas()">Ištrinti</button>-->
                                    <form method="POST" action="{{route('admin.studies.delete', $stud->id)}}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Ištrinti</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </table>
                        {{$studies->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
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
            </form>
            @endif   
            </div>
          </div>
        </div>
      </div>

@endsection