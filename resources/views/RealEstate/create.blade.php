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
                    </div>

                    <div class="form-group">
                        <label for="description">Descrizione</label>
                        <textarea name="description" class="form-control">{{ old('description') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="address">Indirizzo</label>
                        <input type="text" name="address" class="form-control" value="{{ old('address') }}" required>
                    </div>

                    <div class="form-group">
                        <label for="city">Città</label>
                        <input type="text" name="city" class="form-control" value="{{ old('city') }}" required>
                    </div>

                    <div class="form-group">
                        <label for="price">Prezzo</label>
                        <input type="number" name="price" class="form-control" value="{{ old('price') }}" required
                            min="0" step="0.01">
                    </div>

                    <div class="form-group">
                        <label for="structure_types">Tipologia Struttura</label>
                        <select name="structure_types" class="form-control" required>
                            <option value="Appartamento" {{ old('structure_types') == 'Appartamento' ? 'selected' : '' }}>
                                Appartamento</option>
                            <option value="Villa" {{ old('structure_types') == 'Villa' ? 'selected' : '' }}>Villa</option>
                            <option value="Casa indipendente"
                                {{ old('structure_types') == 'Casa indipendente' ? 'selected' : '' }}>Casa indipendente
                            </option>
                            <option value="Villetta a schiera"
                                {{ old('structure_types') == 'Villetta a schiera' ? 'selected' : '' }}>Villetta a schiera
                            </option>
                            <option value="Loft" {{ old('structure_types') == 'Loft' ? 'selected' : '' }}>Loft</option>
                            <option value="Attico" {{ old('structure_types') == 'Attico' ? 'selected' : '' }}>Attico
                            </option>
                            <option value="Monolocale" {{ old('structure_types') == 'Monolocale' ? 'selected' : '' }}>
                                Monolocale</option>
                            <option value="Bilocale" {{ old('structure_types') == 'Bilocale' ? 'selected' : '' }}>Bilocale
                            </option>
                            <option value="Trilocale" {{ old('structure_types') == 'Trilocale' ? 'selected' : '' }}>
                                Trilocale</option>
                            <option value="Rustico" {{ old('structure_types') == 'Rustico' ? 'selected' : '' }}>Rustico
                            </option>
                            <option value="Cottage" {{ old('structure_types') == 'Cottage' ? 'selected' : '' }}>Cottage
                            </option>
                            <option value="Baita" {{ old('structure_types') == 'Baita' ? 'selected' : '' }}>Baita</option>
                            <option value="Mansarda" {{ old('structure_types') == 'Mansarda' ? 'selected' : '' }}>Mansarda
                            </option>
                            <option value="Bungalow" {{ old('structure_types') == 'Bungalow' ? 'selected' : '' }}>Bungalow
                            </option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="avilability">Disponibilità</label>
                        <select name="avilability" class="form-control" required>
                            <option value="1" {{ old('avilability') == 1 ? 'selected' : '' }}>Disponibile</option>
                            <option value="0" {{ old('avilability') == 0 ? 'selected' : '' }}>Occupato</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="rooms">Numero di Stanze</label>
                        <input type="number" name="rooms" class="form-control" value="{{ old('rooms') }}"
                            min="0">
                    </div>

                    <div class="form-group">
                        <label for="bathrooms">Numero di Bagni</label>
                        <input type="number" name="bathrooms" class="form-control" value="{{ old('bathrooms') }}"
                            min="0">
                    </div>

                    <div class="form-group">
                        <label for="beds">Numero di Letti</label>
                        <input type="number" name="beds" class="form-control" value="{{ old('beds') }}"
                            min="0">
                    </div>

                    <div class="form-group">
                        <label for="square_meter">Superficie in m²</label>
                        <input type="number" name="square_meter" class="form-control" value="{{ old('square_meter') }}"
                            min="0">
                    </div>

                    <div class="form-group">
                        <label for="portrait">Immagine di Copertina</label>
                        <input type="file" name="portrait" class="form-control" accept="image/*">
                    </div>

                    <button type="submit" class="btn btn-primary mt-3">Crea Immobile</button>
                </form>
            </div>
        </div>
    </div>
@endsection
