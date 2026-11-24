<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = ['name', 'email', 'password', 'role'];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',   // le mot de passe est haché automatiquement
        ];
    }

    public function rendezVous(): HasMany
    {
        return $this->hasMany(RendezVous::class, 'dentiste_id');
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isDentiste(): bool
    {
        return $this->role === 'dentiste';
    }

    public function isSecretaire(): bool
    {
        return $this->role === 'secretaire';
    }

    // Admin et secrétaire peuvent créer / modifier / supprimer
    public function peutGerer(): bool
    {
        return $this->isAdmin() || $this->isSecretaire();
    }
}
