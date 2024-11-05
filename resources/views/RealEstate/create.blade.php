@extends('dashboard')
@section('main-content')
    <div class="container">
        <div class="row">
            <div class="col-12 p-5">
                <div class="d-flex align-items-center">
                    <a href="{{ route('admin.RealEstates.index') }}">
                        <i class="bi bi-arrow-left-short" style="font-size: 2.5rem"></i>
                    </a>
                    <h1 class="mx-3">Crea Immobile</h1>
                </div>

                <form action="{{ route('admin.RealEstates.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 col-12 col-lg-4 col-xl-3">
                            <div class="form-group">
                                <label class="my-2 fw-bold" for="title">Titolo</label>
                                <input type="text" name="title" class="form-control" value="{{ old('title') }}"
                                    required>
                                @error('title')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6 col-12 col-lg-4 col-xl-3">
                            <div class="form-group">
                                <label class="my-2 fw-bold" for="price">Prezzo</label>
                                <input type="number" name="price" class="form-control" value="{{ old('price') }}"
                                    required min="0" step="1">
                                @error('price')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6 col-12 col-lg-4 col-xl-3">
                            <div class="form-group">
                                <label class="my-2 fw-bold" for="address">Indirizzo</label>
                                <input type="text" name="address" class="form-control" value="{{ old('address') }}"
                                    required>
                                @error('address')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6 col-12 col-lg-4 col-xl-3">
                            <div class="form-group">
                                <label class="my-2 fw-bold" for="city">Città</label>
                                <input type="text" name="city" class="form-control" value="{{ old('city') }}"
                                    required>
                                @error('city')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6 col-12 col-lg-4 col-xl-3">
                            <div class="form-group">
                                <label class="my-2 fw-bold" for="availability">Disponibilità</label>
                                <select name="availability" class="form-control" required>
                                    <option selected value="1" {{ old('availability') == 1 ? 'selected' : '' }}>
                                        Disponibile
                                    </option>
                                    <option value="0" {{ old('availability') == 0 ? 'selected' : '' }}>Occupato
                                    </option>
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
                                        Seleziona
                                        tipologia</option>
                                    @foreach (['Appartamento', 'Villa', 'Casa indipendente', 'Villetta a schiera', 'Loft', 'Attico', 'Monolocale', 'Bilocale', 'Trilocale', 'Rustico', 'Cottage', 'Baita', 'Mansarda', 'Bungalow'] as $type)
                                        <option value="{{ $type }}"
                                            {{ old('structure_types') == $type ? 'selected' : '' }}>{{ $type }}
                                        </option>
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
                                <input type="number" name="rooms" class="form-control" value="{{ old('rooms') }}"
                                    min="0">
                                @error('rooms')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6 col-12 col-lg-4 col-xl-3">
                            <div class="form-group">
                                <label class="my-2 fw-bold" for="bathrooms">Numero di Bagni</label>
                                <input type="number" name="bathrooms" class="form-control" value="{{ old('bathrooms') }}"
                                    min="0">
                                @error('bathrooms')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6 col-12 col-lg-4 col-xl-3">
                            <div class="form-group">
                                <label class="my-2 fw-bold" for="beds">Numero di Letti</label>
                                <input type="number" name="beds" class="form-control" value="{{ old('beds') }}"
                                    min="0">
                                @error('beds')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6 col-12 col-lg-4 col-xl-3">
                            <div class="form-group">
                                <label class="my-2 fw-bold" for="square_meter">Superficie in m²</label>
                                <input type="number" name="square_meter" class="form-control"
                                    value="{{ old('square_meter') }}" min="0">
                                @error('square_meter')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="my-2 fw-bold" for="description">Descrizione</label>
                            <textarea name="description" rows="5" class="form-control">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="my-2 fw-bold" for="portrait">Immagine di Copertina</label>
                            <input type="file" name="portrait" class="form-control" accept="image/*">
                            @error('portrait')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="my-2 fw-bold" for="services">Servizi</label>
                            <div class="row">
                                @foreach ($services as $service)
                                    <div class="col-12 col-md-6 col-lg-4  col-xl-3">
                                        <div class="form-check">
                                            <input type="checkbox" name="services[]" value="{{ $service->id }}"
                                                class="form-check-input"
                                                {{ is_array(old('services')) && in_array($service->id, old('services')) ? 'checked' : '' }}>
                                            <label class="form-check-label">{{ $service->name }}</label>
                                        </div>
                                    </div>
                                @endforeach
                                @error('services')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>


                        <button type="submit" class="btn btn-primary mt-3">Crea Immobile</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
