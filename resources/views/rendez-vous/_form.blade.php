<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label">Patient</label>
        <select name="patient_id" class="form-select" required>
            <option value="">-- Choisir un patient --</option>
            @foreach($patients as $p)
                <option value="{{ $p->id }}" @selected(old('patient_id', $rdv->patient_id) == $p->id)>
                    {{ $p->nom_complet }} ({{ $p->cin }})
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6">
        <label class="form-label">Dentiste</label>
        <select name="dentiste_id" class="form-select" required>
            <option value="">-- Choisir un dentiste --</option>
            @foreach($dentistes as $d)
                <option value="{{ $d->id }}" @selected(old('dentiste_id', $rdv->dentiste_id) == $d->id)>
                    {{ $d->name }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6">
        <label class="form-label">Soin</label>
        <select name="soin_id" class="form-select" required>
            <option value="">-- Choisir un soin --</option>
            @foreach($soins as $s)
                <option value="{{ $s->id }}" @selected(old('soin_id', $rdv->soin_id) == $s->id)>
                    {{ $s->libelle }} - {{ number_format($s->prix, 0, ',', ' ') }} DH
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6">
        <label class="form-label">Statut</label>
        <select name="statut" class="form-select" required>
            @foreach(\App\Models\RendezVous::STATUTS as $cle => $label)
                <option value="{{ $cle }}" @selected(old('statut', $rdv->statut ?? 'planifie') === $cle)>
                    {{ $label }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6">
        <label class="form-label">Date</label>
        <input type="date" name="date_rdv" required
               value="{{ old('date_rdv', $rdv->date_rdv?->format('Y-m-d')) }}"
               class="form-control @error('date_rdv') is-invalid @enderror">
        @error('date_rdv') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6">
        <label class="form-label">Heure</label>
        <input type="time" name="heure_rdv" required
               value="{{ old('heure_rdv', $rdv->heure_rdv ? substr($rdv->heure_rdv, 0, 5) : '') }}"
               class="form-control @error('heure_rdv') is-invalid @enderror">
        @error('heure_rdv') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-12">
        <label class="form-label">Notes</label>
        <textarea name="notes" rows="3" class="form-control">{{ old('notes', $rdv->notes) }}</textarea>
    </div>
</div>
