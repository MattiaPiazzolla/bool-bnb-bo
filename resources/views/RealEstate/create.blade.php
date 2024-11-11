@extends('dashboard')

@section('main-content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 d-flex">
                <div class="back-bt">
                    <a href="{{ route('admin.RealEstates.index') }}" class="d-flex align-items-center">
                        <i class="bi bi-arrow-left-short" style="font-size: 2.5rem"></i>
                        <span class="text-primary mt-3" style="font-size: 14pt">Indietro</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-12 p-5">
                <div class="d-flex align-items-center">
                    <h1 class="mx-3 mb-5">Crea Immobile</h1>
                </div>

                <form action="{{ route('admin.RealEstates.store') }}" method="POST" enctype="multipart/form-data"
                    class="bg-light">
                    @csrf
                    <div class="row p-3">
                        <div class="col-sm-12 col-md-6 col-xl-4 mb-3">
                            <div class="form-group">
                                <label class="my-2 fw-bold" for="title">Titolo</label>
                                <input type="text" name="title" class="form-control" value="{{ old('title') }}"
                                    required>
                                @error('title')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6 col-xl-4 mb-3">
                            <div class="form-group">
                                <label class="my-2 fw-bold" for="price">Prezzo</label>
                                <input type="number" name="price" class="form-control" value="{{ old('price') }}"
                                    required min="0" step="1">
                                @error('price')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6 col-xl-4 mb-3">
                            <div class="form-group">
                                <label class="my-2 fw-bold" for="availability">Disponibilità</label>
                                <select name="availability" class="form-control" required>
                                    <option value="1" {{ old('availability', 1) == 1 ? 'selected' : '' }}>Disponibile
                                    </option>
                                    <option value="0" {{ old('availability') == 0 ? 'selected' : '' }}>Occupato
                                    </option>
                                </select>
                                @error('availability')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row p-3">
                            <div class="col-sm-12 col-md-6 col-xl-4 mb-3">
                                <div class="form-group">
                                    <label class="my-2 fw-bold" for="structure_types">Tipologia Struttura</label>
                                    <select name="structure_types" class="form-control" required>
                                        <option value="" disabled {{ old('structure_types') ? '' : 'selected' }}>
                                            Seleziona
                                            tipologia</option>
                                        @foreach (['Appartamento', 'Villa', 'Casa indipendente', 'Villetta a schiera', 'Loft', 'Attico', 'Monolocale', 'Bilocale', 'Trilocale', 'Rustico', 'Cottage', 'Baita', 'Mansarda', 'Bungalow'] as $type)
                                            <option value="{{ $type }}"
                                                {{ old('structure_types') == $type ? 'selected' : '' }}>
                                                {{ $type }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('structure_types')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6 col-xl-4 mb-3">
                                <div class="form-group">
                                    <label class="my-2 fw-bold" for="rooms">Numero di Stanze</label>
                                    <input type="number" name="rooms" class="form-control" value="{{ old('rooms') }}"
                                        min="0">
                                    @error('rooms')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6 col-xl-4 mb-3">
                                <div class="form-group">
                                    <label class="my-2 fw-bold" for="bathrooms">Numero di Bagni</label>
                                    <input type="number" name="bathrooms" class="form-control"
                                        value="{{ old('bathrooms') }}" min="0">
                                    @error('bathrooms')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row p-3">
                            <div class="col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label class="my-2 fw-bold" for="beds">Numero di Letti</label>
                                    <input type="number" name="beds" class="form-control" value="{{ old('beds') }}"
                                        min="0">
                                    @error('beds')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label class="my-2 fw-bold" for="square_meter">Superficie in m²</label>
                                    <input type="number" name="square_meter" class="form-control"
                                        value="{{ old('square_meter') }}" min="0">
                                    @error('square_meter')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row px-3">
                            <div class="col-12">
                                <div class="form-group mb-5">
                                    <label class="my-2 fw-bold" for="description">Descrizione</label>
                                    <textarea name="description" rows="5" class="form-control">{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group mb-5">
                                    <label class="my-2 fw-bold" for="portrait">Immagine di Copertina</label>
                                    <input type="file" name="portrait" class="form-control" accept="image/*">
                                    @error('portrait')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row px-3">
                            <div class="form-group">
                                <label class="my-2 fw-bold" for="services">Servizi</label>
                                <div class="row">
                                    @foreach ($services as $service)
                                        <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                                            <div class="form-check">
                                                <input type="checkbox" name="services[]" value="{{ $service->id }}"
                                                    class="form-check-input"
                                                    {{ is_array(old('services')) && in_array($service->id, old('services')) ? 'checked' : '' }}>
                                                <label class="form-check-label">
                                                    <i class="ms-2 opacity-75 {{ $service->icon }}"></i>
                                                    {{ $service->name }}</label>
                                            </div>
                                        </div>
                                    @endforeach
                                    @error('services')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude') }}">
                            <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude') }}">
                            <input type="hidden" name="address" id="address" value="{{ old('address') }}">
                            <input type="hidden" name="city" id="city" value="{{ old('city') }}">

                            <div class="row">
                                <div class="col-12">
                                    <div class="d-flex justify-content-between my-5 position-relative">
                                        <!-- Contenitore della casella di ricerca -->
                                        <div id="searchBoxContainer" class="position-absolute  rounded shadow"
                                            style="z-index: 1; top: 10px; left: 10px; width: 80%; max-width: 300px;">
                                            @error('address')
                                                <div class="text-white bg-danger p-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <!-- Contenitore della mappa -->
                                        <div id="map" class="map w-100" style="height: 500px;"></div>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary mt-3">Crea Immobile</button>
                            </div>
                        </div>
                </form>
            </div>
        </div>
    </div>
@endsection

<!--

                <div class="row p-3">
                    <div class="col-12 my-3">
                    <div class="card bg-warning p-3">
                                <div class="form-group d-flex justify-content-between align-items-center">
                                    <div>
                                        <label for="subscriptions">Sponsorizzazione</label>
                                        <select name="subscriptions[]" id="subscriptions">
                                            <option value="" selected>Seleziona una sottoscrizione (opzionale)
                                            </option>
                                            @foreach ($subscriptions as $subscription)
<option value="{{ $subscription->id }}"
                                                    {{ old('subscriptions') && in_array($subscription->id, old('subscriptions')) ? 'selected' : '' }}>
                                                    {{ $subscription->name }} ({{ $subscription->price }}&#8364;)
                                                    {{ $subscription->duration }} ore

                                                </option>
@endforeach
                                        </select>
                                        @error('subscriptions')
    <div class="text-danger">{{ $message }}</div>
@enderror
                                    </div>
                                    <a href="#" class="float-end">
                                        <div class="btn">Scopri di più sulle Sponsorizzazioni</div>
                                    </a>
                                </div>
                            </div>
                    </div>
                </div>
-->
