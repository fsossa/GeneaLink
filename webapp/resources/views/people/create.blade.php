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

        <form action="{{ route('people.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="first_name" class="form-label">Prénom</label>
                <input type="text" name="first_name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="last_name" class="form-label">Nom</label>
                <input type="text" name="last_name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="birth_name" class="form-label">Nom de naissance (optionnel)</label>
                <input type="text" name="birth_name" class="form-control">
            </div>

            <div class="mb-3">
                <label for="middle_names" class="form-label">Noms intermédiaires (optionnel)</label>
                <input type="text" name="middle_names" class="form-control">
            </div>

            <div class="mb-3">
                <label for="date_of_birth" class="form-label">Date de naissance</label>
                <input type="date" name="date_of_birth" class="form-control">
            </div>

            <button type="submit" class="btn btn-success">Ajouter</button>
            <a href="{{ route('people.index') }}" class="btn btn-secondary">Annuler</a>
        </form>
    </div>
@endsection
