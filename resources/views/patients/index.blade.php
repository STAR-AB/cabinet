@extends('layouts.app')
@section('title', 'Patients')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Liste des patients</h3>
    @if(auth()->user()->peutGerer())
        <a href="{{ route('patients.create') }}" class="btn btn-primary">+ Nouveau patient</a>
    @endif
</div>

<form method="GET" class="input-group mb-3">
    <input type="text" name="q" value="{{ request('q') }}" class="form-control"
           placeholder="Nom, prénom, CIN ou téléphone...">
    <button class="btn btn-outline-primary">Rechercher</button>
</form>

<table class="table table-striped bg-white align-middle">
    <thead>
        <tr><th>#</th><th>Nom complet</th><th>CIN</th><th>Âge</th><th>Téléphone</th><th></th></tr>
    </thead>
    <tbody>
    @forelse($patients as $patient)
        <tr>
            <td>{{ $patient->id }}</td>
            <td>{{ $patient->nom_complet }}</td>
            <td>{{ $patient->cin }}</td>
            <td>{{ $patient->date_naissance->age }} ans</td>
            <td>{{ $patient->telephone }}</td>
            <td class="text-end">
                <a href="{{ route('patients.show', $patient) }}" class="btn btn-sm btn-info">Voir</a>
                @if(auth()->user()->peutGerer())
                    <a href="{{ route('patients.edit', $patient) }}"
                       class="btn btn-sm btn-warning">Modifier</a>
                    <form action="{{ route('patients.destroy', $patient) }}" method="POST"
                          class="d-inline"
                          onsubmit="return confirm('Supprimer ce patient ?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">Supprimer</button>
                    </form>
                @endif
            </td>
        </tr>
    @empty
        <tr><td colspan="6" class="text-center text-muted">Aucun patient trouvé.</td></tr>
    @endforelse
    </tbody>
</table>

{{ $patients->links() }}
@endsection
