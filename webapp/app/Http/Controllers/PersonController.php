<?php

namespace App\Http\Controllers;

use App\Models\Contribution;
use App\Models\Invitation;
use App\Models\Person;
use App\Models\Relationship;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PersonController extends Controller
{

    public function __construct() {
        $this->middleware('auth');//->only(['create', 'store']);
    }
    
    /**
     * Afficher la liste des personnes avec le créateur
     */
    public function index()
    {
        $people = Person::with('creator')->paginate(50);
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
        $newPerson = Person::create($validated);

        $data=[
            'relationship_id'=>null,
            'action'=>'new',
            'created_by'=> Auth::user()->id
        ];

        if($request['relation'] == "child"){
            $data +=[
                'parent_id'=> Auth::user()->person->id,
                'child_id'=> $newPerson->id,
            ];
        }elseif($request['relation'] == "parent"){
            $data=[
                'parent_id'=> $newPerson->id,
                'child_id'=> Auth::user()->person->id,
            ];
        }

        Contribution::create($data);

        if(!empty($request['invitation'])){
            Invitation::create([
                'person_id'=> $newPerson->id,
                'code'=> Str::random(4).$newPerson->id ,
                'created_by'=>Auth::user()->id,
            ]);
        }

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

    /** Tester le degrer */
    public function degre(){
        DB::enableQueryLog();
        $timestart = microtime(true);
        $person = Person::findOrFail(84);
        $degree = $person->getDegreeWith(1265);
        // afficher le rÃ©sultat, le temps d'execution, et le nombre de requÃªtes SQL :
        var_dump(["degree"=>$degree, "time"=>microtime(true)-$timestart, "nb_queries"=>count(DB::getQueryLog())]);
    }


    /** Liste des invitations envoyés */
    public function invitations(){
        $contibutions = Contribution::orderByDesc('id')->get();
         return view('admin.list_invitations',compact('contibutions'));
     }
    
     /** Confirmer ou rejeter une relation */
    public function make_action_contribution($id , $action){
        $contribution = Contribution::find($id);
        if(!$contribution or !in_array($action, ['confirm','reject'])){
            return back()->with('error',"Une erreur est subvenue");
        }

        switch ($action) {
            case 'confirm':
                $data = $contribution->getAcceptedUsers();
                $data[] = Auth::user()->id;
                $contribution->users_accept = json_encode($data);

                if(count($data) >= 3){
                    if($contribution->action == "new"){
                        Relationship::create([
                            'parent_id'=>$contribution->parent_id,
                            'child_id'=>$contribution->child_id,
                            'created_by'=>$contribution->created_by
                        ]);
                    }elseif($contribution->action == "edit"){
                        Relationship::find($contribution->relationship_id)->update([
                            'parent_id'=>$contribution->parent_id,
                            'child_id'=>$contribution->child_id,
                        ]);
                    }

                    $contribution->confirm_relation = now();
                }

                break;
            case 'reject':
                $data = $contribution->getRejectedUsers();
                $data[] = Auth::user()->id;
                $contribution->users_reject = json_encode($data);

                if(count($data) >= 3){
                    $contribution->reject_relation = now();
                }

                break;
            default:
                return back()->with('error', "Action invalide");
                break;
        }

        $contribution->save();
        return back()->with('success', "L'action a été réalisée avec succès");
    }

    /** Modifier une relation */
    public function edit_relation($first,$second,$action){
        if( !in_array($action, ['parent','child'])){
            return back()->with('error',"Une erreur est subvenue");
        }

        if($action == "parent"){
            $relation =  Relationship::where('child_id',$first)->where('parent_id',$second)->first();
            Contribution::create([
                'relationship_id'=>$relation->id,
                'action'=>'edit',
                'created_by'=> Auth::user()->id,
                'parent_id'=> $first,
                'child_id'=> $second,
            ]);
        }else{
            $relation =  Relationship::where('parent_id',$first)->where('child_id',$second)->first();
            Contribution::create([
                'relationship_id'=>$relation->id,
                'action'=>'edit',
                'created_by'=> Auth::user()->id,
                'child_id'=> $first,
                'parent_id'=> $second,
            ]);
        }
        return redirect()->route('invitations')->with('success',"Demande de modification envoyée");
    }

    /** Aller sur la page d'inscription */
    public function register_invitation($code){
        return view('auth.register-invitation',compact('code'));

        $verify = Invitation::where('code',$code)->whereNull('validated_at')->first();
        if($verify){
            return view('auth.register-invitation',compact('code'));
        }
        return redirect()->route('login')->with('error',"Votre code est invalide");
    }

}
