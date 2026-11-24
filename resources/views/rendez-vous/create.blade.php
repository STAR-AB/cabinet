@extends('layouts.app')
@section('title', 'Nouveau rendez-vous')

@section('content')
<h3 class="mb-3">Nouveau rendez-vous</h3>
<form method="POST" action="{{ route('rendez-vous.store') }}" class="card card-body">
    @csrf
    @include('rendez-vous._form', ['rdv' => new \App\Models\RendezVous])
    <div class="mt-4">
        <button class="btn btn-primary">Enregistrer</button>
        <a href="{{ route('rendez-vous.index') }}" class="btn btn-secondary">Annuler</a>
    </div>
</form>
@endsection
