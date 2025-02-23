@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ $person->first_name }} {{ $person->last_name }}</h1>
        <p>Nom de naissance : {{ $person->birth_name ?? 'N/A' }}</p>
        <p>Noms intermédiaires : {{ $person->middle_names ?? 'N/A' }}</p>
        <p>Date de naissance : {{ $person->date_of_birth ?? 'N/A' }}</p>

        <h3>Parents :</h3>
        <ul>
            @forelse($person->parents as $parent)
                <li>{{ $parent->first_name }} {{ $parent->last_name }}</li>
            @empty
                <li>Aucun parent enregistré</li>
            @endforelse
        </ul>

        <h3>Enfants :</h3>
        <ul>
            @forelse($person->children as $child)
                <li>{{ $child->first_name }} {{ $child->last_name }}</li>
            @empty
                <li>Aucun enfant enregistré</li>
            @endforelse
        </ul>

        <a href="{{ route('people.index') }}" class="btn btn-secondary">Retour</a>
    </div>
@endsection
