<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Person extends Model
{
    use HasFactory;

    protected $fillable = [
        'created_by', 'first_name', 'last_name', 
        'birth_name', 'middle_names', 'date_of_birth'
    ];

    public function parents() {
        return $this->belongsToMany(Person::class, 'relationships', 'child_id', 'parent_id');
    }

    public function children() {
        return $this->belongsToMany(Person::class, 'relationships', 'parent_id', 'child_id');
    }

    public function creator() {
        return $this->belongsTo(User::class, 'created_by');
    }

    
    /**
     * Trouver le degré de parenté entre la personne actuelle et une autre personne donnée.
     * @param int $target_person_id
     * @return int|false
     */
    public function getDegreeWith($target_person_id){
        if ($this->id == $target_person_id) return 0; // Même personne -> degré 0

        // Vérifier si l'ID de la personne cible est valide
        if ($this->id == $target_person_id) {
            return 0;  // La même personne, degré de parenté est 0
        }

        // Recherche en largeur (BFS)
        $visited = [];
        $queue = [
            [$this->id, 0]  // La personne courante avec un degré initial de 0
        ];

        while (!empty($queue)) {
            list($current_person_id, $degree) = array_shift($queue);

            // Si la personne cible est trouvée, retourner le degré
            if ($current_person_id == $target_person_id) {
                return $degree;
            }

            // Marquer la personne comme visitée
            $visited[$current_person_id] = true;

            // Ajouter les parents et les enfants dans la queue, s'ils n'ont pas été visités
            $current_person = Person::find($current_person_id);
            $relations = $current_person->parents()->get()->pluck('id')->toArray();
            $relations = array_merge($relations, $current_person->enfants()->get()->pluck('id')->toArray());

            //Si inferieur à 25
            foreach ($relations as $relation_id) {
                if (!isset($visited[$relation_id])) {
                    $queue[] = [$relation_id, $degree + 1];  // Ajouter la personne dans la queue avec un degré incrémenté
                }
            }
        }
        return false; // Pas de connexion trouvée
    }
}
