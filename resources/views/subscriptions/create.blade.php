@extends('dashboard')

@section('main-content')
    <div class="container">
        <h1>Sponsorizza un immobile</h1>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('admin.subscriptions.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-12 col-md-5">
                    <div class="form-group">
                        <label for="real_estate_id">Seleziona un immobile</label>
                        <select name="real_estate_id" id="real_estate_id" class="form-control p-2 select2" required>
                            <option value="">-- Seleziona un immobile --</option>
                            @foreach ($real_estates as $real_estate)
                                <option value="{{ $real_estate->id }}"
                                    data-image="{{ !empty($real_estate->portrait) ? asset('storage/' . $real_estate->portrait) : 'https://placehold.co/600x400?text=Immagine+non+disponibile' }}"
                                    data-latitude="{{ $real_estate->latitude }}"
                                    data-longitude="{{ $real_estate->longitude }}" data-title="{{ $real_estate->title }}">
                                    {{ $real_estate->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-12 col-md-5">
                    <div class="form-group">
                        <label for="subscription_id">Seleziona una sponsorizzazione</label>
                        <select name="subscription_id" id="subscription_id" class="form-control p-2" required>
                            <option value="">-- Seleziona una sponsorizzazione --</option>
                            @foreach ($subscriptions as $subscription)
                                <option value="{{ $subscription->id }}">
                                    {{ $subscription->name }} - Durata: {{ $subscription->duration }} ore - Prezzo:
                                    €{{ $subscription->price }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-2">
                    <button type="submit" class="btn btn-primary mt-4 p-2">Sponsorizza immobile</button>
                </div>
            </div>
        </form>

        <!-- Placeholder per immagine e mappa -->
        <div id="real_estate_details" class="row mt-3">
            <div class="col-12 col-md-6">
                <p>Anteprima immagine</p>
                <div class="" id="image-placeholder">
                    <div class="placeholder-content"
                        style="background: #e0e0e0; display: flex; align-items: center; justify-content: center; border-radius: 10px;">
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <p>Posizione immobile</p>
                <div class="" id="map-placeholder">
                    <div class="placeholder-content"
                        style="background: #e0e0e0; display: flex; align-items: center; justify-content: center; border-radius: 10px;">
                    </div>
                </div>
            </div>
        </div>
        <a href="{{ route("admin.subscriptions.braintree") }}">ciao</a>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const realEstateSelect = document.getElementById('real_estate_id');
            const imagePlaceholder = document.getElementById('image-placeholder');
            const mapPlaceholder = document.getElementById('map-placeholder');

            // Funzione per mostrare i placeholder
            function showPlaceholders() {
                imagePlaceholder.innerHTML = `<div class="placeholder-content">
                                               
                                              </div>`;
                mapPlaceholder.innerHTML = `<div class="placeholder-content">
                                              
                                            </div>`;
            }

            // Funzione per caricare i dettagli dell'immobile
            function loadRealEstateDetails(imageSrc, latitude, longitude, title) {
                // Carica l'immagine
                imagePlaceholder.innerHTML = `<div class="d-flex p-2">
                                                <img src="${imageSrc}" alt="${title}" class="img-fluid fixed-size">
                                              </div>`;

                // Carica la mappa con TomTom
                if (latitude && longitude) {
                    const map = tt.map({
                        key: "9Yq5kH65us12yazEXv9SX8bGsAYxX1fL",
                        container: 'map-placeholder',
                        center: [longitude, latitude],
                        zoom: 10
                    });

                    const marker = new tt.Marker().setLngLat([longitude, latitude]).addTo(map);

                    map.on('load', function() {
                        map.setCenter([longitude, latitude]);
                        map.resize();
                    });
                }
            }

            // Ascolta quando l'utente cambia la selezione
            realEstateSelect.addEventListener('change', function() {
                const selectedOption = realEstateSelect.options[realEstateSelect.selectedIndex];

                // Se non è stato selezionato un immobile (opzione vuota)
                if (!selectedOption.value) {
                    showPlaceholders();
                    return;
                }

                // Ottieni i dati dell'immobile selezionato
                const imageSrc = selectedOption.getAttribute('data-image');
                const latitude = selectedOption.getAttribute('data-latitude');
                const longitude = selectedOption.getAttribute('data-longitude');
                const title = selectedOption.getAttribute('data-title');

                // Carica i dettagli dell'immobile
                loadRealEstateDetails(imageSrc, latitude, longitude, title);
            });

            // Inizialmente mostra i placeholder (se nessuna selezione)
            if (!realEstateSelect.value) {
                showPlaceholders();
            }
        });
    </script>

    <style>
        /* Aggiungi l'effetto pulsante al placeholder */
        .placeholder-content {
            width: 100%;
            height: 300px;
            animation: pulse 1.5s ease-in-out infinite;
        }

        @keyframes pulse {
            0% {
                background-color: #e0e0e0;
            }

            50% {
                background-color: #b8b5b5;
            }

            100% {
                background-color: #e0e0e0;
            }
        }

        /* Impostazione dimensioni fisse per l'immagine e la mappa */
        .fixed-size {
            width: 100%;
            height: 300px;
            object-fit: cover;
            border-radius: 10px;
        }
    </style>
@endsection
