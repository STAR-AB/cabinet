<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\RendezVous;
use App\Models\Soin;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class RendezVousController extends Controller
{
    public function index(Request $request): View
    {
        $rendezVous = RendezVous::with(['patient', 'dentiste', 'soin'])
            ->when($request->user()->isDentiste(),
                fn ($q) => $q->where('dentiste_id', $request->user()->id))
            ->when($request->filled('date'), fn ($q) => $q->whereDate('date_rdv', $request->date))
            ->when($request->filled('statut'), fn ($q) => $q->where('statut', $request->statut))
            ->orderBy('date_rdv')
            ->orderBy('heure_rdv')
            ->paginate(10)
            ->withQueryString();

        return view('rendez-vous.index', compact('rendezVous'));
    }

    public function create(): View
    {
        return view('rendez-vous.create', $this->donneesFormulaire());
    }

    public function store(Request $request): RedirectResponse
    {
        RendezVous::create($this->validated($request));

        return redirect()->route('rendez-vous.index')
            ->with('success', 'Rendez-vous enregistré.');
    }

    public function edit(RendezVous $rendezVous): View
    {
        return view('rendez-vous.edit',
            array_merge($this->donneesFormulaire(), ['rdv' => $rendezVous]));
    }

    public function update(Request $request, RendezVous $rendezVous): RedirectResponse
    {
        $rendezVous->update($this->validated($request, $rendezVous));

        return redirect()->route('rendez-vous.index')
            ->with('success', 'Rendez-vous modifié.');
    }

    public function destroy(RendezVous $rendezVous): RedirectResponse
    {
        $rendezVous->delete();

        return redirect()->route('rendez-vous.index')
            ->with('success', 'Rendez-vous supprimé.');
    }

    public function changerStatut(Request $request, RendezVous $rendezVous): RedirectResponse
    {
        // Un dentiste ne peut changer le statut que de SES rendez-vous
        if ($request->user()->isDentiste() && $rendezVous->dentiste_id != $request->user()->id) {
            abort(403, "Ce rendez-vous n'est pas le vôtre.");
        }

        $request->validate([
            'statut' => ['required', Rule::in(array_keys(RendezVous::STATUTS))],
        ]);

        $rendezVous->update(['statut' => $request->statut]);

        return back()->with('success', 'Statut mis à jour.');
    }

    private function donneesFormulaire(): array
    {
        return [
            'patients'  => Patient::orderBy('nom')->get(),
            'dentistes' => User::where('role', 'dentiste')->orderBy('name')->get(),
            'soins'     => Soin::orderBy('libelle')->get(),
        ];
    }

    private function validated(Request $request, ?RendezVous $rdv = null): array
    {
        return $request->validate([
            'patient_id'  => ['required', 'exists:patients,id'],
            'dentiste_id' => ['required', 'exists:users,id'],
            'soin_id'     => ['required', 'exists:soins,id'],
            'date_rdv'    => ['required', 'date', 'after_or_equal:today'],
            'heure_rdv'   => [
                'required', 'date_format:H:i',
                // Créneau déjà pris pour ce dentiste à cette date ?
                Rule::unique('rendez_vous', 'heure_rdv')
                    ->where(fn ($q) => $q
                        ->where('dentiste_id', $request->dentiste_id)
                        ->where('date_rdv', $request->date_rdv))
                    ->ignore($rdv?->id),
            ],
            'statut'      => ['required', Rule::in(array_keys(RendezVous::STATUTS))],
            'notes'       => ['nullable', 'string'],
        ], [
            'heure_rdv.unique'        => 'Ce dentiste a déjà un rendez-vous à ce créneau.',
            'date_rdv.after_or_equal' => 'La date ne peut pas être dans le passé.',
        ]);
    }
}
