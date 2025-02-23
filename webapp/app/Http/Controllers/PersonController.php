<?php

namespace App\Http\Controllers;

use App\Models\Person;
use Illuminate\Http\Request;

class PersonController extends Controller
{
    /**
     * Afficher la liste des personnes avec le créateur
     */
    public function index()
    {
        $people = Person::with('creator')->get();
        return view('people.index', compact('people'));
    }

    /**
     * Afficher le formulaire de création
     */
    public function create()
    {
        return view('people.create');
    }

    /**
     * Valider et insérer une nouvelle personne
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'birth_name' => 'nullable|string|max:255',
            'middle_names' => 'nullable|string|max:255',
            'date_of_birth' => 'nullable|date',
        ]);

        $person = Person::create([
            'created_by' => auth()->id(), // L'utilisateur connecté est le créateur
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'birth_name' => $request->birth_name,
            'middle_names' => $request->middle_names,
            'date_of_birth' => $request->date_of_birth,
        ]);

        return redirect()->route('people.index')->with('success', 'Personne ajoutée avec succès !');
    }

    /**
     * Afficher une personne spécifique avec ses parents et enfants
     */
    public function show(string $id)
    {
        $person = Person::with(['parents', 'children'])->findOrFail($id);
        return view('people.show', compact('person'));
    }

}
