@extends('layouts.app')
@section('title', 'Tableau de bord')

@section('content')
<h3 class="mb-4">Tableau de bord</h3>

<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card text-bg-primary"><div class="card-body">
            <h6>Patients</h6><h2>{{ $nbPatients }}</h2>
        </div></div>
    </div>
    <div class="col-md-3">
        <div class="card text-bg-success"><div class="card-body">
            <h6>RDV aujourd'hui</h6><h2>{{ $nbRdvAujourdhui }}</h2>
        </div></div>
    </div>
    <div class="col-md-3">
        <div class="card text-bg-warning"><div class="card-body">
            <h6>RDV à venir</h6><h2>{{ $nbRdvAVenir }}</h2>
        </div></div>
    </div>
    <div class="col-md-3">
        <div class="card text-bg-dark"><div class="card-body">
            <h6>CA du mois</h6><h2>{{ number_format($chiffreAffaires, 0, ',', ' ') }} DH</h2>
        </div></div>
    </div>
</div>

<div class="card">
    <div class="card-header">Rendez-vous du jour</div>
    <table class="table mb-0">
        <thead>
            <tr><th>Heure</th><th>Patient</th><th>Soin</th><th>Dentiste</th><th>Statut</th></tr>
        </thead>
        <tbody>
        @forelse($rdvDuJour as $rdv)
            <tr>
                <td>{{ substr($rdv->heure_rdv, 0, 5) }}</td>
                <td>{{ $rdv->patient->nom_complet }}</td>
                <td>{{ $rdv->soin->libelle }}</td>
                <td>{{ $rdv->dentiste->name }}</td>
                <td><span class="badge bg-{{ $rdv->badgeClass() }}">
                    {{ \App\Models\RendezVous::STATUTS[$rdv->statut] }}</span></td>
            </tr>
        @empty
            <tr><td colspan="5" class="text-center text-muted">Aucun rendez-vous aujourd'hui.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
@endsection
