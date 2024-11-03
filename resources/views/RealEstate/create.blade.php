@extends('dashboard')
@section('main-content')
    <div class="container">
        <div class="row">
            <div class="col-12 p-5">
                <h1>Crea Nuovo Immobile</h1>

                <form action="{{ route('admin.RealEstates.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label for="title">Titolo</label>
                        <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
                        @error('title')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="description">Descrizione</label>
                        <textarea name="description" class="form-control">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="address">Indirizzo</label>
                        <input type="text" name="address" class="form-control" value="{{ old('address') }}" required>
                        @error('address')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="city">Città</label>
                        <input type="text" name="city" class="form-control" value="{{ old('city') }}" required>
                        @error('city')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="price">Prezzo</label>
                        <input type="number" name="price" class="form-control" value="{{ old('price') }}" required
                            min="0" step="0.01">
                        @error('price')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="structure_types">Tipologia Struttura</label>
                        <select name="structure_types" class="form-control" required>
                            <option value="" disabled {{ old('structure_types') ? '' : 'selected' }}>Seleziona
                                tipologia</option>
                            @foreach (['Appartamento', 'Villa', 'Casa indipendente', 'Villetta a schiera', 'Loft', 'Attico', 'Monolocale', 'Bilocale', 'Trilocale', 'Rustico', 'Cottage', 'Baita', 'Mansarda', 'Bungalow'] as $type)
                                <option value="{{ $type }}"
                                    {{ old('structure_types') == $type ? 'selected' : '' }}>{{ $type }}</option>
                            @endforeach
                        </select>
                        @error('structure_types')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="availability">Disponibilità</label>
                        <select name="availability" class="form-control" required>
                            <option value="1" {{ old('availability') == 1 ? 'selected' : '' }}>Disponibile</option>
                            <option value="0" {{ old('availability') == 0 ? 'selected' : '' }}>Occupato</option>
                        </select>
                        @error('availability')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="rooms">Numero di Stanze</label>
                        <input type="number" name="rooms" class="form-control" value="{{ old('rooms') }}"
                            min="0">
                        @error('rooms')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="bathrooms">Numero di Bagni</label>
                        <input type="number" name="bathrooms" class="form-control" value="{{ old('bathrooms') }}"
                            min="0">
                        @error('bathrooms')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="beds">Numero di Letti</label>
                        <input type="number" name="beds" class="form-control" value="{{ old('beds') }}"
                            min="0">
                        @error('beds')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="square_meter">Superficie in m²</label>
                        <input type="number" name="square_meter" class="form-control" value="{{ old('square_meter') }}"
                            min="0">
                        @error('square_meter')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <h3>Servizi</h3>
                    @foreach ($services as $service)
                        <div class="form-check">
                            <input type="checkbox" name="services[]" value="{{ $service->id }}" class="form-check-input"
                                {{ is_array(old('services')) && in_array($service->id, old('services')) ? 'checked' : '' }}>
                            <label class="form-check-label">{{ $service->name }}</label>
                        </div>
                    @endforeach
                    @error('services')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror

                    <div class="form-group">
                        <label for="portrait">Immagine di Copertina</label>
                        <input type="file" name="portrait" class="form-control" accept="image/*">
                        @error('portrait')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary mt-3">Crea Immobile</button>
                </form>
            </div>
        </div>
    </div>
@endsection
