<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Patient extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nom', 'prenom', 'cin', 'date_naissance', 'sexe',
        'telephone', 'email', 'adresse', 'antecedents',
    ];

    protected $casts = [
        'date_naissance' => 'date',
    ];

    // Accesseur : $patient->nom_complet
    protected function nomComplet(): Attribute
    {
        return Attribute::get(fn () => strtoupper($this->nom) . ' ' . $this->prenom);
    }

    // Scope : Patient::recherche('benali')
    public function scopeRecherche(Builder $query, ?string $terme): Builder
    {
        return $query->when($terme, function ($q) use ($terme) {
            $q->where(function ($q) use ($terme) {
                $q->where('nom', 'like', "%{$terme}%")
                  ->orWhere('prenom', 'like', "%{$terme}%")
                  ->orWhere('cin', 'like', "%{$terme}%")
                  ->orWhere('telephone', 'like', "%{$terme}%");
            });
        });
    }

    public function rendezVous(): HasMany
    {
        return $this->hasMany(RendezVous::class);
    }
}
