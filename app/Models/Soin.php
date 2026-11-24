<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Soin extends Model
{
    protected $fillable = ['libelle', 'description', 'prix', 'duree_minutes'];

    public function rendezVous(): HasMany
    {
        return $this->hasMany(RendezVous::class);
    }
}
