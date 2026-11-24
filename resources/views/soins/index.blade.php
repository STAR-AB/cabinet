@extends('layouts.app')
@section('title', 'Catalogue des soins')

@section('content')
<h3 class="mb-3">Catalogue des soins</h3>

<form method="POST" action="{{ route('soins.store') }}" class="card card-body mb-4">
    @csrf
    <div class="row g-2">
        <div class="col-md-3">
            <input name="libelle" class="form-control" placeholder="Libellé" required>
        </div>
        <div class="col-md-4">
            <input name="description" class="form-control" placeholder="Description">
        </div>
        <div class="col-md-2">
            <input type="number" step="0.01" name="prix" class="form-control"
                   placeholder="Prix (DH)" required>
        </div>
        <div class="col-md-2">
            <input type="number" name="duree_minutes" value="30" class="form-control" required>
        </div>
        <div class="col-md-1"><button class="btn btn-primary w-100">+</button></div>
    </div>
</form>

<table class="table table-striped bg-white align-middle">
    <thead><tr><th>Soin</th><th>Prix</th><th>Durée</th><th>Utilisé</th><th></th></tr></thead>
    <tbody>
    @foreach($soins as $soin)
        <tr>
            <td>
                <b>{{ $soin->libelle }}</b><br>
                <small class="text-muted">{{ $soin->description }}</small>
            </td>
            <td>{{ number_format($soin->prix, 2, ',', ' ') }} DH</td>
            <td>{{ $soin->duree_minutes }} min</td>
            <td>{{ $soin->rendez_vous_count }} fois</td>
            <td class="text-end">
                <form action="{{ route('soins.destroy', $soin) }}" method="POST"
                      onsubmit="return confirm('Supprimer ce soin ?')">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger">Supprimer</button>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
@endsection
