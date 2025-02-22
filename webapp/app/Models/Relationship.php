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
}
