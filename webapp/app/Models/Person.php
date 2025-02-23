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

        $queue = [[$this->id, 0]]; // File d'attente (id_personne, degré)
        $visited = [$this->id => true]; // Pour éviter les boucles infinies

        while (!empty($queue)) {
            [$current_id, $degree] = array_shift($queue); // Défilement FIFO

            if ($degree >= 25) return false; // Stop si trop long

            // Récupérer les parents et enfants de la personne actuelle
            $related_people = DB::table('relationships')
                ->where('parent_id', $current_id)
                ->orWhere('child_id', $current_id)
                ->pluck('parent_id', 'child_id')
                ->merge(DB::table('relationships')
                ->where('parent_id', $current_id)
                ->orWhere('child_id', $current_id)
                ->pluck('child_id', 'parent_id'))
                ->unique()
                ->except([$current_id]);

            foreach ($related_people as $related_id) {
                if ($related_id == $target_person_id) return $degree + 1; // Trouvé !

                if (!isset($visited[$related_id])) {
                    $visited[$related_id] = true;
                    $queue[] = [$related_id, $degree + 1]; // Ajouter en file d'attente
                }
            }
        }

        return false; // Pas de connexion trouvée
    }
}
