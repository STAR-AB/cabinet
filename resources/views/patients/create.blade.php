@extends('layouts.app')
@section('title', 'Nouveau patient')

@section('content')
<h3 class="mb-3">Nouveau patient</h3>
<form method="POST" action="{{ route('patients.store') }}" class="card card-body">
    @csrf
    @include('patients._form', ['patient' => new \App\Models\Patient])
    <div class="mt-4">
        <button class="btn btn-primary">Enregistrer</button>
        <a href="{{ route('patients.index') }}" class="btn btn-secondary">Annuler</a>
    </div>
</form>
@endsection
