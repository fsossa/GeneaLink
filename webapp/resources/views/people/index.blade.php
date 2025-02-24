@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
    <div class="bg-white shadow-xl rounded-lg p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-semibold text-gray-800">Liste des Personnes</h2>
            <a href="{{ route('people.create') }}" class="bg-success-500 text-white px-4 py-2 rounded-md hover:bg-success-600 text-sm" style="background-color: cornflowerblue;">
                + Ajouter une personne
            </a>
        </div>

        <div class="overflow-x-auto">
            <table id="peopleTable" class="min-w-full border border-gray-300 shadow-sm rounded-lg">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="px-4 py-2 text-left">ID</th>
                        <th class="px-4 py-2 text-left">Prénom</th>
                        <th class="px-4 py-2 text-left">Nom</th>
                        <th class="px-4 py-2 text-left">Date de Naissance</th>
                        <th class="px-4 py-2 text-left">Créé par</th>
                        <th class="px-4 py-2 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($people as $person)
                        <tr class="hover:bg-gray-100">
                            <td class="px-4 py-2">{{ $person->id }}</td>
                            <td class="px-4 py-2">{{ ucfirst(strtolower($person->first_name)) }}</td>
                            <td class="px-4 py-2 font-bold">{{ strtoupper($person->last_name) }}</td>
                            <td class="px-4 py-2">{{ $person->date_of_birth ?? 'N/A' }}</td>
                            <td class="px-4 py-2">{{ $person->creator->name ?? 'Inconnu' }}</td>
                            <td class="px-4 py-2 flex justify-center space-x-2">
                                <a href="{{ route('people.show', $person->id) }}" class="bg-blue-500 text-black px-3 py-1 rounded-md hover:bg-blue-600 text-sm" style="background-color: cornflowerblue;">Voir</a>
                                {{-- <a href="{{ route('people.edit', $person->id) }}" class="bg-yellow-500 text-white px-3 py-1 rounded-md hover:bg-yellow-600 text-sm">Modifier</a> --}}
                                {{-- <form action="{{ route('people.destroy', $person->id) }}" method="POST" class="inline"> --}}
                                    {{-- @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded-md hover:bg-red-600 text-sm" onclick="return confirm('Supprimer cette personne ?')">Supprimer</button>
                                </form> --}}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- Pagination -->
        <div class="mt-4">
            {{ $people->links() }} 
        </div>
    </div>
</div>
@endsection

@section('scripts')
{{-- Import DataTables --}}
    {{-- <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css"> --}}
    {{-- <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script> --}}
    <!-- jQuery -->
    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>


    <script>
        document.addEventListener("DOMContentLoaded", function () {
            $('#peopleTable').DataTable({
                responsive: true,
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/French.json"
                }
            });
        });
    </script> --}}
@endsection
