@extends('dashboard')

@section('main-content')
    <div class="container">
        <div class="row">
            <div class="col-12 p-5">
                <div class="d-flex align-items-center">
                    <a href="{{ route('admin.RealEstates.index') }}">
                        <i class="bi bi-arrow-left-short" style="font-size: 2.5rem"></i>
                    </a>
                    <h1 class="mx-3">Modifica Immobile</h1>
                </div>

                <form action="{{ route('admin.RealEstates.update', $real_estate->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="title">Titolo</label>
                        <input type="text" name="title" class="form-control"
                            value="{{ old('title', $real_estate->title) }}" required>
                        @error('title')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="description">Descrizione</label>
                        <textarea name="description" class="form-control">{{ old('description', $real_estate->description) }}</textarea>
                        @error('description')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="address">Indirizzo</label>
                        <input type="text" name="address" class="form-control"
                            value="{{ old('address', $real_estate->address) }}" required>
                        @error('address')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="city">Città</label>
                        <input type="text" name="city" class="form-control"
                            value="{{ old('city', $real_estate->city) }}" required>
                        @error('city')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="price">Prezzo</label>
                        <input type="number" name="price" class="form-control"
                            value="{{ old('price', $real_estate->price) }}" required min="0" step="0.01">
                        @error('price')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="structure_types">Tipologia di Struttura</label>
                        <input type="text" name="structure_types" class="form-control"
                            value="{{ old('structure_types', $real_estate->structure_types) }}" required>
                        @error('structure_types')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="availability">Disponibilità</label>
                        <select name="availability" class="form-control">
                            <option value="1"
                                {{ old('availability', $real_estate->availability) == 1 ? 'selected' : '' }}>Disponibile
                            </option>
                            <option value="0"
                                {{ old('availability', $real_estate->availability) == 0 ? 'selected' : '' }}>Non
                                Disponibile</option>
                        </select>
                        @error('availability')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="rooms">Stanze</label>
                        <input type="number" name="rooms" class="form-control"
                            value="{{ old('rooms', $real_estate->rooms) }}" min="0">
                        @error('rooms')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="bathrooms">Bagni</label>
                        <input type="number" name="bathrooms" class="form-control"
                            value="{{ old('bathrooms', $real_estate->bathrooms) }}" min="0">
                        @error('bathrooms')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="beds">Letti</label>
                        <input type="number" name="beds" class="form-control"
                            value="{{ old('beds', $real_estate->beds) }}" min="0">
                        @error('beds')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="square_meter">Metri Quadrati</label>
                        <input type="number" name="square_meter" class="form-control"
                            value="{{ old('square_meter', $real_estate->square_meter) }}" min="0">
                        @error('square_meter')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    @if ($real_estate->portrait)
                        <div class="form-group">
                            <label>Immagine Corrente</label>
                            <img src="{{ asset('storage/' . $real_estate->portrait) }}" class="img-thumbnail"
                                width="200" alt="Copertina attuale">
                        </div>
                    @endif

                    <div class="form-group">
                        <label for="portrait">Nuova Immagine di Copertina</label>
                        <input type="file" name="portrait" class="form-control">
                        @error('portrait')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="services">Servizi</label>
                        <div>
                            @foreach ($all_services as $service)
                                <div class="form-check">
                                    <input type="checkbox" name="services[]" value="{{ $service->id }}"
                                        class="form-check-input" id="service-{{ $service->id }}"
                                        {{ $real_estate->services->contains($service->id) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="service-{{ $service->id }}">
                                        {{ $service->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        <small class="form-text text-muted">Seleziona i servizi disponibili per questo immobile.</small>
                    </div>

                    <button type="submit" class="btn btn-primary mt-3">Aggiorna Immobile</button>
                </form>
            </div>
        </div>
    </div>
@endsection
