@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Liste des personnes</h1>
        <a href="{{ route('people.create') }}" class="btn btn-primary">Ajouter une personne</a>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table mt-3">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Créé par</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($people as $person)
                    <tr>
                        <td>{{ $person->first_name }} {{ $person->last_name }}</td>
                        <td>{{ $person->creator->name ?? 'Inconnu' }}</td>
                        <td>
                            <a href="{{ route('people.show', $person->id) }}" class="btn btn-info">Voir</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
