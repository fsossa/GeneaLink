<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    protected $table = 'invitations';

    // Colonnes
    protected $fillable = [
        'person_id',
        'code',
        'created_by',
        'validated_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');  // Lien vers l'utilisateur-créateur
    }

    public function person()
    {
        return $this->belongsTo(Person::class, 'person_id');  // Lien vers l'utilisateur-créateur
    }
}