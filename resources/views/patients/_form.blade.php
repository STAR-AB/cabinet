<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label">Nom</label>
        <input type="text" name="nom" value="{{ old('nom', $patient->nom) }}"
               class="form-control @error('nom') is-invalid @enderror" required>
        @error('nom') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6">
        <label class="form-label">Prénom</label>
        <input type="text" name="prenom" value="{{ old('prenom', $patient->prenom) }}"
               class="form-control @error('prenom') is-invalid @enderror" required>
        @error('prenom') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-4">
        <label class="form-label">CIN</label>
        <input type="text" name="cin" value="{{ old('cin', $patient->cin) }}"
               class="form-control @error('cin') is-invalid @enderror" required>
        @error('cin') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-4">
        <label class="form-label">Date de naissance</label>
        <input type="date" name="date_naissance"
               value="{{ old('date_naissance', $patient->date_naissance?->format('Y-m-d')) }}"
               class="form-control @error('date_naissance') is-invalid @enderror" required>
        @error('date_naissance') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-4">
        <label class="form-label">Sexe</label>
        <select name="sexe" class="form-select" required>
            <option value="M" @selected(old('sexe', $patient->sexe) === 'M')>Masculin</option>
            <option value="F" @selected(old('sexe', $patient->sexe) === 'F')>Féminin</option>
        </select>
    </div>
    <div class="col-md-6">
        <label class="form-label">Téléphone</label>
        <input type="text" name="telephone" value="{{ old('telephone', $patient->telephone) }}"
               class="form-control @error('telephone') is-invalid @enderror" required>
        @error('telephone') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6">
        <label class="form-label">Email</label>
        <input type="email" name="email" value="{{ old('email', $patient->email) }}"
               class="form-control @error('email') is-invalid @enderror">
        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-12">
        <label class="form-label">Adresse</label>
        <input type="text" name="adresse" value="{{ old('adresse', $patient->adresse) }}"
               class="form-control">
    </div>
    <div class="col-12">
        <label class="form-label">Antécédents médicaux</label>
        <textarea name="antecedents" rows="3" class="form-control">{{ old('antecedents', $patient->antecedents) }}</textarea>
    </div>
</div>
