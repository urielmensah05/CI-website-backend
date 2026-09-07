<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Champs autorisés (mass assignment)
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        
        
        
        
    ];

    /**
     * Champs cachés (sécurité)
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Conversion des types
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // ============================
    //  RELATIONS
    // ============================

    // annonces
    public function annonces()
    {
        return $this->hasMany(Annonce::class);
    }

    //  services
    public function services()
    {
        return $this->hasMany(Service::class);
    }

    // 🎓 formations
    public function formations()
    {
        return $this->hasMany(Formation::class);
    }

    // 👥 equipes
    public function equipes()
    {
        return $this->hasMany(Equipe::class);
    }
    public function partenaires()
{
    return $this->hasMany(Partenaire::class);
}
}