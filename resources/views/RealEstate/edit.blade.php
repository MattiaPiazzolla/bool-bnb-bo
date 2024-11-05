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

                    <div class="row">
                        <div class="col-md-6 col-12 col-lg-4 col-xl-3">
                            <div class="form-group">
                                <label class="my-2 fw-bold" for="title">Titolo</label>
                                <input type="text" name="title" class="form-control"
                                    value="{{ old('title', $real_estate->title) }}" required>
                                @error('title')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6 col-12 col-lg-4 col-xl-3">
                            <div class="form-group">
                                <label class="my-2 fw-bold" for="price">Prezzo</label>
                                <input type="number" name="price" class="form-control"
                                    value="{{ old('price', $real_estate->price) }}" required min="0" step="1">
                                @error('price')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- <div class="col-md-6 col-12 col-lg-4 col-xl-3">
                            <div class="form-group">
                                <label class="my-2 fw-bold" for="address">Indirizzo</label>
                                <input type="text" name="address" class="form-control"
                                    value="{{ old('address', $real_estate->address) }}" required>
                                @error('address')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div> --}}

                        {{-- <div class="col-md-6 col-12 col-lg-4 col-xl-3">
                            <div class="form-group">
                                <label class="my-2 fw-bold" for="city">Città</label>
                                <input type="text" name="city" class="form-control"
                                    value="{{ old('city', $real_estate->city) }}" required>
                                @error('city')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div> --}}

                        <div class="col-md-6 col-12 col-lg-4 col-xl-3">
                            <div class="form-group">
                                <label class="my-2 fw-bold" for="availability">Disponibilità</label>
                                <select name="availability" class="form-control" required>
                                    <option value="1"
                                        {{ old('availability', $real_estate->availability) == 1 ? 'selected' : '' }}>
                                        Disponibile</option>
                                    <option value="0"
                                        {{ old('availability', $real_estate->availability) == 0 ? 'selected' : '' }}>
                                        Occupato</option>
                                </select>
                                @error('availability')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6 col-12 col-lg-4 col-xl-3">
                            <div class="form-group">
                                <label class="my-2 fw-bold" for="structure_types">Tipologia Struttura</label>
                                <select name="structure_types" class="form-control" required>
                                    <option value="" disabled {{ old('structure_types') ? '' : 'selected' }}>
                                        Seleziona tipologia</option>
                                    @foreach (['Appartamento', 'Villa', 'Casa indipendente', 'Villetta a schiera', 'Loft', 'Attico', 'Monolocale', 'Bilocale', 'Trilocale', 'Rustico', 'Cottage', 'Baita', 'Mansarda', 'Bungalow'] as $type)
                                        <option value="{{ $type }}"
                                            {{ old('structure_types', $real_estate->structure_types) == $type ? 'selected' : '' }}>
                                            {{ $type }}</option>
                                    @endforeach
                                </select>
                                @error('structure_types')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6 col-12 col-lg-4 col-xl-3">
                            <div class="form-group">
                                <label class="my-2 fw-bold" for="rooms">Numero di Stanze</label>
                                <input type="number" name="rooms" class="form-control"
                                    value="{{ old('rooms', $real_estate->rooms) }}" min="0">
                                @error('rooms')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6 col-12 col-lg-4 col-xl-3">
                            <div class="form-group">
                                <label class="my-2 fw-bold" for="bathrooms">Numero di Bagni</label>
                                <input type="number" name="bathrooms" class="form-control"
                                    value="{{ old('bathrooms', $real_estate->bathrooms) }}" min="0">
                                @error('bathrooms')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6 col-12 col-lg-4 col-xl-3">
                            <div class="form-group">
                                <label class="my-2 fw-bold" for="beds">Numero di Letti</label>
                                <input type="number" name="beds" class="form-control"
                                    value="{{ old('beds', $real_estate->beds) }}" min="0">
                                @error('beds')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6 col-12 col-lg-4 col-xl-3">
                            <div class="form-group">
                                <label class="my-2 fw-bold" for="square_meter">Superficie in m²</label>
                                <input type="number" name="square_meter" class="form-control"
                                    value="{{ old('square_meter', $real_estate->square_meter) }}" min="0">
                                @error('square_meter')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="my-2 fw-bold" for="description">Descrizione</label>
                            <textarea name="description" rows="5" class="form-control">{{ old('description', $real_estate->description) }}</textarea>
                            @error('description')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 col-md-6 mt-5">
                            <div class="form-group">
                                <label class="my-2 fw-bold" for="portrait">Nuova Immagine di Copertina</label>
                                <input type="file" name="portrait" class="form-control" accept="image/*">
                                @error('portrait')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 col-md-6 mt-5">
                            @if ($real_estate->portrait)
                                <div class="form-group">
                                    <label>Immagine Attuale</label>
                                    <img src="{{ asset('storage/' . $real_estate->portrait) }}" class="img-thumbnail"
                                        width="200" alt="Copertina attuale">
                                </div>
                            @endif
                        </div>


                        <div class="form-group">
                            <label class="my-2 fw-bold" for="services">Servizi</label>
                            <div class="row">
                                @foreach ($all_services as $service)
                                    <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                                        <div class="form-check">
                                            <input type="checkbox" name="services[]" value="{{ $service->id }}"
                                                class="form-check-input" id="service-{{ $service->id }}"
                                                {{ $real_estate->services->contains($service->id) ? 'checked' : '' }}>
                                            <label class="form-check-label"
                                                for="service-{{ $service->id }}">{{ $service->name }}</label>
                                        </div>
                                    </div>
                                @endforeach
                                @error('services')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude') }}">
                        <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude') }}">
                        <input type="hidden" name="address" id="address" value="{{ old('address') }}">
                        <input type="hidden" name="city" id="city" value="{{ old('city') }}">

                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex justify-content-between my-5 position-relative">
                                    <div id="searchBoxContainer"
                                        style="width: 30%; position:absolute; z-index: 1; top: 10px; left: 10px"></div>
                                    <div id='map' class='map' style="width: 100%; height: 500px"></div>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary mt-3">Aggiorna Immobile</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
