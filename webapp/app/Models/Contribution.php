<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contribution extends Model
{
    protected $table = 'contributions';

    // Les colonnes
    protected $fillable = [
        'created_by',
        'relationship_id',
        'parent_id',
        'child_id',
        "action",
        'users_accept',
        'users_reject',
        'confirm_relation',
        'reject_relation'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function parent()
    {
        return $this->belongsTo(Person::class, 'parent_id');
    }

    public function child()
    {
        return $this->belongsTo(Person::class, 'child_id');
    }

    public function relation()
    {
        return $this->belongsTo(Relation::class, 'relationship_id');
    }

    public function getAcceptedUsers()
    {
        return $this->users_accept ? json_decode($this->users_accept) : [];
    }

    public function getRejectedUsers()
    {
        return $this->users_reject ? json_decode($this->users_reject) : [];
    }

}