@extends('layouts.app')

@section('content')
    @if(Session::has('success'))
    <div  class="alert alert-success" role="alert" >
        <strong>{{Session::get('success')}}</strong>
    </div>
    @endif

    @if(Session::has('error'))
    <div  class="alert alert-danger" role="alert" >
        <strong>{{Session::get('error')}}</strong>
    </div>
    @endif

    <div class="d-flex justify-content-end">
        <a href="#misenrelation" class="mr-3" >Mises en relation</a>
        <a href="#invitation" >Les invitations</a>
    </div>

    <div class="row" id="misenrelation" >
        <div class="col-lg-12">
            <h3 class="text-primary" >Les mises en relation</h3>
        </div>

        <div class="col-md-12">
            <div class="table-responsive">
                <table  class="table" id="myTable" >
                    <thead>
                        <tr>
                            <th scope="col">Type</th>
                            <th scope="col"></th>
                            <th scope="col">Relation</th>
                            <th></th>
                            <th scope="col">Confirmer</th>
                            <th scope="col">Rejecter</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($contibutions as $contribution)
                        <tr class="">
                            <td>
                                @if($contribution->action == "new")
                                <span>Nouveau</span>
                                @else
                                <span>Modification</span>
                                @endif
                            </td>
                            <td scope="row"> <b>{{$contribution->parent->first_name}} {{$contribution->parent->last_name}}</b> </td>
                            <td>
                                @if($contribution->parent->id == $contribution->parent_id )
                                Est un des parents de
                                @else
                                un des enfants de
                                @endif
                            </td>
                            <td> <b>{{$contribution->child->first_name}} {{$contribution->child->first_name}}</b> </td>
                            <td class="text-center" >
                                {{count($contribution->getAcceptedUsers())}}
                            </td>
                            <td class="text-center" >
                                {{count($contribution->getRejectedUsers())}}
                            </td>
                            <td>
                                @if(empty($contribution->confirm_relation) and empty($contribution->reject_relation))
                                @if(!in_array(Auth::user()->id , $contribution->getRejectedUsers()) and !in_array(Auth::user()->id , $contribution->getAcceptedUsers()) )
                                <div class="btn-group">
                                    <a href="{{route('make_action_invitation',[$contribution->id, "confirm"])}}" class="btn btn-sm btn-success">Confirm</a>
                                    <a href="{{route('make_action_invitation',[$contribution->id, "reject"])}}" class="btn btn-sm btn-danger">Reject</a>
                                </div>
                                @else
                                <span class="text-primary">Deja réagit</span>
                                @endif
                                @endif

                                @if($contribution->reject_relation)
                                <span class="text-danger">Definitivement Rejeté</span>
                                @endif

                                @if($contribution->confirm_relation)
                                <span class="text-success">Definitivement Accepté</span>
                                @endif

                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>


    <div class="row mt-4" id="invitation" >
        <div class="col-lg-12">
            <h3  class="text-primary">Mes invitations en attente</h3>
        </div>

        <div class="col-md-12 mt-2">
            <div class="table-responsive">
                <table  class="table" id="myTable2">
                    <thead>
                        <tr>
                            <th scope="col">Personne</th>
                            <th scope="col">Date</th>
                            <th scope="col">Code d'inscription</th>
                            <th>Statut</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach (Auth::user()->invitations as $people)
                        <tr>
                            <td>{{$people->person->first_name}} {{$people->person->last_name}}</td>
                            <td>{{$people->created_at}}</td>
                            <td> <b>{{$people->code}}</b> </td>
                            <td>
                                @if($people->validated_at)
                                <span class="text-success">Invitation acceptée</span>
                                @else
                                <span class="text-warning">Invitation attente</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>

        </div>
    </div>


    @push('scripts')
    <script>
        $(document).ready(function () {
            $('#myTable').DataTable();
            $('#myTable2').DataTable();
        });
    </script>
    @endpush
@endsection