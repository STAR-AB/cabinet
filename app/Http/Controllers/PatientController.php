<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class PatientController extends Controller
{
    public function index(Request $request): View
    {
        $patients = Patient::recherche($request->q)
            ->orderBy('nom')
            ->paginate(10)
            ->withQueryString();

        return view('patients.index', compact('patients'));
    }

    public function create(): View
    {
        return view('patients.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $patient = Patient::create($this->validated($request));

        return redirect()->route('patients.show', $patient)
            ->with('success', 'Patient ajouté avec succès.');
    }

    public function show(Patient $patient): View
    {
        $patient->load(['rendezVous.soin', 'rendezVous.dentiste']);

        return view('patients.show', compact('patient'));
    }

    public function edit(Patient $patient): View
    {
        return view('patients.edit', compact('patient'));
    }

    public function update(Request $request, Patient $patient): RedirectResponse
    {
        $patient->update($this->validated($request, $patient));

        return redirect()->route('patients.show', $patient)
            ->with('success', 'Patient modifié avec succès.');
    }

    public function destroy(Patient $patient): RedirectResponse
    {
        $patient->delete();   // SoftDelete : le patient reste en base (deleted_at)

        return redirect()->route('patients.index')
            ->with('success', 'Patient supprimé.');
    }

    private function validated(Request $request, ?Patient $patient = null): array
    {
        return $request->validate([
            'nom'            => ['required', 'string', 'max:80'],
            'prenom'         => ['required', 'string', 'max:80'],
            'cin'            => ['required', 'string', 'max:20',
                                 Rule::unique('patients', 'cin')->ignore($patient?->id)],
            'date_naissance' => ['required', 'date', 'before:today'],
            'sexe'           => ['required', Rule::in(['M', 'F'])],
            'telephone'      => ['required', 'regex:/^0[5-7][0-9]{8}$/'],
            'email'          => ['nullable', 'email', 'max:255'],
            'adresse'        => ['nullable', 'string', 'max:255'],
            'antecedents'    => ['nullable', 'string'],
        ], [
            'cin.unique'      => 'Ce CIN existe déjà.',
            'telephone.regex' => 'Le téléphone doit être au format 06XXXXXXXX ou 07XXXXXXXX.',
        ]);
    }
}
