<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RendezVous extends Model
{
    // Sans cette ligne, Laravel chercherait une table "rendez_vouses"
    protected $table = 'rendez_vous';

    public const STATUTS = [
        'planifie' => 'Planifié',
        'confirme' => 'Confirmé',
        'termine'  => 'Terminé',
        'annule'   => 'Annulé',
    ];

    protected $fillable = [
        'patient_id', 'dentiste_id', 'soin_id',
        'date_rdv', 'heure_rdv', 'statut', 'notes',
    ];

    protected $casts = [
        'date_rdv' => 'date',
    ];

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class)->withTrashed();
    }

    public function dentiste(): BelongsTo
    {
        return $this->belongsTo(User::class, 'dentiste_id');
    }

    public function soin(): BelongsTo
    {
        return $this->belongsTo(Soin::class);
    }

    // Couleur Bootstrap du badge selon le statut
    public function badgeClass(): string
    {
        return match ($this->statut) {
            'planifie' => 'secondary',
            'confirme' => 'primary',
            'termine'  => 'success',
            'annule'   => 'danger',
            default    => 'light',
        };
    }
}
