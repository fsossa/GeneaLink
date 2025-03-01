@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Ajouter une personne</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{route('store')}}" method="POST">
            @csrf
            <div class="row">

                <div class="form-group col-lg-4">
                    <label for="my-input">Nom</label>
                    <input id="my-input" class="form-control" type="text" name="first_name" value="{{old('first_name')}}" >
                    @error('first_name')
                    <span class="text-danger">{{$message}}</span>
                @enderror
                </div>

                <div class="form-group  col-lg-4">
                    <label for="my-input">Prénoms</label>
                    <input id="my-input" class="form-control" type="text" name="last_name" value="{{old('last_name')}}" >
                    @error('last_name')
                    <span class="text-danger">{{$message}}</span>
                @enderror
                </div>


                <div class="form-group  col-lg-4">
                    <label for="my-input">Nom d'anniversaire</label>
                    <input id="my-input" class="form-control" type="text" name="birth_name" value="{{old('birth_name')}}" >
                    @error('birth_name')
                    <span class="text-danger">{{$message}}</span>
                @enderror
                </div>



                <div class="form-group  col-lg-4">
                    <label for="my-input">Nom du millieu</label>
                    <input id="my-input" class="form-control" type="text" name="middle_names" value="{{old('middle_names')}}" >
                    @error('middle_names')
                    <span class="text-danger">{{$message}}</span>
                @enderror

                </div>

                <div class="form-group  col-lg-4">
                    <label for="my-input">Date d'anniversaire</label>
                    <input id="my-input" class="form-control" type="date" max="{{date('Y-m-d',strtotime('-1 days'))}}" name="date_of_birth" value="{{old('date_of_birth')}}" >
                    @error('date_of_birth')
                        <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>

                <div class="form-group  col-lg-4">
                    <label for="my-input">Relation</label>
                    <select name="relation" id="" class="form-control">
                        <option value="">Quelle relation avez vous</option>
                        <option @if(old('relation') == "child" ) selected @endif value="child">Mon Enfant</option>
                        <option @if(old('relation') == "parent" ) selected @endif value="parent">Un de mes parents</option>
                    </select>
                    @error('relation')
                        <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>

                <div class="col-12">
                    <input type="checkbox" name="invitation" id=""> Envoyer une invitation
                </div>
                <div class="col-12 mt-3">
                    <button type="submit" class="btn btn-success">Créer l'utilisateur</button>
                </div>

            </div>
        </form>
    </div>
@endsection
