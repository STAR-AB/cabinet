@extends('layouts.app')
@section('title', $patient->nom_complet)

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h3>{{ $patient->nom_complet }}</h3>
    <a href="{{ route('patients.index') }}" class="btn btn-outline-secondary">Retour</a>
</div>

<div class="card mb-4">
    <div class="card-body row">
        <div class="col-md-4"><b>CIN :</b> {{ $patient->cin }}</div>
        <div class="col-md-4">
            <b>Naissance :</b> {{ $patient->date_naissance->format('d/m/Y') }}
            ({{ $patient->date_naissance->age }} ans)
        </div>
        <div class="col-md-4"><b>Sexe :</b> {{ $patient->sexe === 'M' ? 'Masculin' : 'Féminin' }}</div>
        <div class="col-md-4"><b>Téléphone :</b> {{ $patient->telephone }}</div>
        <div class="col-md-4"><b>Email :</b> {{ $patient->email ?? '-' }}</div>
        <div class="col-md-4"><b>Adresse :</b> {{ $patient->adresse ?? '-' }}</div>
        <div class="col-12 mt-2"><b>Antécédents :</b> {{ $patient->antecedents ?? 'Aucun' }}</div>
    </div>
</div>

<h5>Historique des rendez-vous</h5>
<table class="table bg-white">
    <thead><tr><th>Date</th><th>Heure</th><th>Soin</th><th>Dentiste</th><th>Statut</th></tr></thead>
    <tbody>
    @forelse($patient->rendezVous->sortByDesc('date_rdv') as $rdv)
        <tr>
            <td>{{ $rdv->date_rdv->format('d/m/Y') }}</td>
            <td>{{ substr($rdv->heure_rdv, 0, 5) }}</td>
            <td>{{ $rdv->soin->libelle }} ({{ number_format($rdv->soin->prix, 0, ',', ' ') }} DH)</td>
            <td>{{ $rdv->dentiste->name }}</td>
            <td><span class="badge bg-{{ $rdv->badgeClass() }}">
                {{ \App\Models\RendezVous::STATUTS[$rdv->statut] }}</span></td>
        </tr>
    @empty
        <tr><td colspan="5" class="text-center text-muted">Aucun rendez-vous.</td></tr>
    @endforelse
    </tbody>
</table>
@endsection
