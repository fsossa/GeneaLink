<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function person()
    {
        return $this->hasOne(Person::class, 'created_by');  // Lien vers l'utilisateur-créateur
    }

    public function contribution()
    {
        return $this->hasOne(Contribution::class, 'created_by');  // Lien vers l'utilisateur-créateur
    }

    public function invitations()
    {
        return $this->hasMany(Invitation::class, 'created_by');
    }

    // Relation : Un utilisateur peut créer plusieurs contributions
    public function contributions()
    {
        return $this->hasMany(Contribution::class, 'created_by');
    }
}
