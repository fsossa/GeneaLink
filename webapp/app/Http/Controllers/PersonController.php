<?php

namespace App\Http\Controllers;

use App\Models\Person;
use Illuminate\Http\Request;

class PersonController extends Controller
{

    public function __construct() {
        $this->middleware('auth')->only(['create', 'store']);
    }
    
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
        $validated = $request->validate([
            'first_name'   => 'required|string|max:255',
            'middle_names' => 'nullable|string|max:255',
            'last_name'    => 'required|string|max:255',
            'birth_name'   => 'nullable|string|max:255',
            'date_of_birth'=> 'nullable|date',
        ]);
    
        // Formatage des données :
        $validated['first_name'] = ucfirst(strtolower($validated['first_name']));
        
        if ($validated['middle_names']) {
            $validated['middle_names'] = collect(explode(',', $validated['middle_names']))
                                            ->map(fn($name) => ucfirst(strtolower(trim($name))))
                                            ->implode(', ');
        }
    
        $validated['last_name'] = strtoupper($validated['last_name']);
        $validated['birth_name'] = $validated['birth_name'] ? strtoupper($validated['birth_name']) : $validated['last_name'];
    
        $validated['created_by'] = auth()->id();
    
        // Enregistrement en base de données :
        Person::create($validated);

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
