@extends('layouts.app')
@section('title', 'Rendez-vous')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Rendez-vous</h3>
    @if(auth()->user()->peutGerer())
        <a href="{{ route('rendez-vous.create') }}" class="btn btn-primary">+ Nouveau rendez-vous</a>
    @endif
</div>

<form method="GET" class="row g-2 mb-3">
    <div class="col-md-3">
        <input type="date" name="date" value="{{ request('date') }}" class="form-control">
    </div>
    <div class="col-md-3">
        <select name="statut" class="form-select">
            <option value="">Tous les statuts</option>
            @foreach(\App\Models\RendezVous::STATUTS as $cle => $label)
                <option value="{{ $cle }}" @selected(request('statut') === $cle)>{{ $label }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-2">
        <button class="btn btn-outline-primary w-100">Filtrer</button>
    </div>
</form>

<table class="table table-striped bg-white align-middle">
    <thead>
        <tr><th>Date</th><th>Heure</th><th>Patient</th><th>Soin</th><th>Dentiste</th>
            <th>Statut</th><th></th></tr>
    </thead>
    <tbody>
    @forelse($rendezVous as $rdv)
        <tr>
            <td>{{ $rdv->date_rdv->format('d/m/Y') }}</td>
            <td>{{ substr($rdv->heure_rdv, 0, 5) }}</td>
            <td>{{ $rdv->patient->nom_complet }}</td>
            <td>{{ $rdv->soin->libelle }}</td>
            <td>{{ $rdv->dentiste->name }}</td>
            <td>
                @if(in_array(auth()->user()->role, ['admin', 'dentiste']))
                    <form action="{{ route('rendez-vous.statut', $rdv) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <select name="statut" class="form-select form-select-sm"
                                onchange="this.form.submit()">
                            @foreach(\App\Models\RendezVous::STATUTS as $cle => $label)
                                <option value="{{ $cle }}" @selected($rdv->statut === $cle)>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </form>
                @else
                    <span class="badge bg-{{ $rdv->badgeClass() }}">
                        {{ \App\Models\RendezVous::STATUTS[$rdv->statut] }}
                    </span>
                @endif
            </td>
            <td class="text-end">
                @if(auth()->user()->peutGerer())
                    <a href="{{ route('rendez-vous.edit', $rdv) }}"
                       class="btn btn-sm btn-warning">Modifier</a>
                    <form action="{{ route('rendez-vous.destroy', $rdv) }}" method="POST"
                          class="d-inline" onsubmit="return confirm('Supprimer ce rendez-vous ?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">Supprimer</button>
                    </form>
                @endif
            </td>
        </tr>
    @empty
        <tr><td colspan="7" class="text-center text-muted">Aucun rendez-vous.</td></tr>
    @endforelse
    </tbody>
</table>

{{ $rendezVous->links() }}
@endsection
