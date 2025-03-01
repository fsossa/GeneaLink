<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Relationship extends Model
{
    use HasFactory;

    protected $fillable = ['created_by', 'parent_id', 'child_id'];

    public function creator() {
        return $this->belongsTo(User::class, 'created_by');
    }


    /**
     * Relation : La relation appartient à un parent (personne)
     */
    public function parent()
    {
        return $this->belongsTo(Person::class, 'parent_id');
    }

    /**
     * Relation : La relation appartient à un enfant (personne)
     */
    public function child()
    {
        return $this->belongsTo(Person::class, 'child_id');
    }

    public function contributions()
    {
        return $this->hasMany(Contribution::class, 'relationship_id');
    }
}
