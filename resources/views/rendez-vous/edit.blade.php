@extends('layouts.app')
@section('title', 'Modifier le rendez-vous')

@section('content')
<h3 class="mb-3">Modifier le rendez-vous</h3>
<form method="POST" action="{{ route('rendez-vous.update', $rdv) }}" class="card card-body">
    @csrf
    @method('PUT')
    @include('rendez-vous._form')
    <div class="mt-4">
        <button class="btn btn-primary">Mettre à jour</button>
        <a href="{{ route('rendez-vous.index') }}" class="btn btn-secondary">Annuler</a>
    </div>
</form>
@endsection
