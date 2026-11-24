<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\RendezVous;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
class DashboardController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();

        // Rendez-vous du jour (un dentiste ne voit que les siens)
        $rdvDuJour = RendezVous::with(['patient', 'soin', 'dentiste'])
            ->whereDate('date_rdv', today())
            ->when($user->isDentiste(), fn ($q) => $q->where('dentiste_id', $user->id))
            ->orderBy('heure_rdv')
            ->get();

        // Chiffre d'affaires du mois = somme du prix des soins des rendez-vous terminés
        $chiffreAffaires = RendezVous::join('soins', 'soins.id', '=', 'rendez_vous.soin_id')
            ->where('rendez_vous.statut', 'termine')
            ->whereMonth('rendez_vous.date_rdv', now()->month)
            ->whereYear('rendez_vous.date_rdv', now()->year)
            ->sum('soins.prix');

        return view('dashboard', [
            'nbPatients'      => Patient::count(),
            'nbRdvAujourdhui' => $rdvDuJour->count(),
            'nbRdvAVenir'     => RendezVous::whereDate('date_rdv', '>', today())
                                    ->where('statut', '!=', 'annule')->count(),
            'chiffreAffaires' => $chiffreAffaires,
            'rdvDuJour'       => $rdvDuJour,
        ]);
    }
}
