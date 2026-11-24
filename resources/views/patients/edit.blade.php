@extends('layouts.app')
@section('title', 'Modifier le patient')

@section('content')
<h3 class="mb-3">Modifier : {{ $patient->nom_complet }}</h3>
<form method="POST" action="{{ route('patients.update', $patient) }}" class="card card-body">
    @csrf
    @method('PUT')
    @include('patients._form')
    <div class="mt-4">
        <button class="btn btn-primary">Mettre à jour</button>
        <a href="{{ route('patients.show', $patient) }}" class="btn btn-secondary">Annuler</a>
    </div>
</form>
@endsection
