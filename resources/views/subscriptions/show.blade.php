@extends('dashboard')

@section('main-content')
    <div class="container p-5">
        <h1 class="text-center mb-4">Sponsorizza un immobile</h1>

        <form action="{{ route('admin.subscriptions.braintree') }}" method="POST" id="payment-form">
            @csrf

            <!-- Campo nascosto per passare l'ID della sottoscrizione -->
            <input type="hidden" name="subscription_id" value="{{ $subscription->id }}">

            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-lg-6">
                        <label for="real_estate_id">Seleziona l'immobile che desideri sponsorizzare</label>
                        <select name="real_estate_id" id="real_estate_id" class="form-control" required>
                            <option value="">-- Seleziona un immobile --</option>
                            @foreach ($realEstates as $realEstate)
                                <option value="{{ $realEstate->id }}" data-title="{{ $realEstate->title }}"
                                    data-description="{{ $realEstate->description }}"
                                    data-address="{{ $realEstate->address }}" data-city="{{ $realEstate->city }}"
                                    data-rooms="{{ $realEstate->rooms }}" data-beds="{{ $realEstate->beds }}"
                                    data-bathrooms="{{ $realEstate->bathrooms }}"
                                    data-square_meter="{{ $realEstate->square_meter }}"
                                    data-image="{{ !empty($realEstate->portrait) ? asset('storage/' . $realEstate->portrait) : 'https://placehold.co/600x400?text=Immagine+non+disponibile' }}">
                                    {{ $realEstate->title }}
                                </option>
                            @endforeach
                        </select>

                        <!-- Informazioni sull'immobile selezionato -->
                        <div id="real-estate-info" class="mt-4 d-none">
                            <h4>Informazioni Immobile Selezionato</h4>
                            <img id="real-estate-image" src="" alt="Immagine immobile" class="img-fluid mb-3"
                                style="max-height: 200px; border-radius: 8px;">
                            <ul>
                                <li><strong>Titolo:</strong> <span id="real-estate-title"></span></li>
                                <li><strong>Descrizione:</strong> <span id="real-estate-description"></span></li>
                                <li><strong>Indirizzo:</strong> <span id="real-estate-address"></span>, <span
                                        id="real-estate-city"></span></li>
                                <li><strong>Stanze:</strong> <span id="real-estate-rooms"></span></li>
                                <li><strong>Camere da letto:</strong> <span id="real-estate-beds"></span></li>
                                <li><strong>Bagni:</strong> <span id="real-estate-bathrooms"></span></li>
                                <li><strong>Metri quadri:</strong> <span id="real-estate-square-meter"></span> m²</li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-12 col-lg-6 d-flex justify-content-center">
                        <div class="card shadow-sm p-4 mt-4">
                            <h3 class="text-center mb-4">Pagamento Sicuro</h3>

                            <!-- Visualizza il prezzo della sponsorizzazione -->
                            <div id="subscription-price-display" class="text-center mb-3"
                                style="font-size: 1.5rem; color: #007bff;">
                                € {{ number_format($subscription->price, 2) }}
                            </div>

                            <div id="dropin-container" class="mb-4"></div>
                            <button id="submit-button" class="btn btn-primary btn-block btn-lg" disabled>Esegui il
                                pagamento</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <style>
        .card {
            max-width: 400px;
        }

        #real-estate-info {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        #real-estate-info ul {
            list-style-type: none;
            padding-left: 0;
        }

        #real-estate-info ul li {
            margin: 5px 0;
        }
    </style>

    <script>
        var button = document.querySelector('#submit-button');
        var select = document.querySelector('#real_estate_id');
        var realEstateInfo = document.querySelector('#real-estate-info');
        var priceDisplay = document.querySelector('#subscription-price-display');

        // Funzione per abilitare/disabilitare il bottone
        function toggleButton() {
            if (select.value === '') {
                button.disabled = true; // Disabilita il bottone se non è selezionato un immobile
                realEstateInfo.classList.add('d-none'); // Nasconde le informazioni dell'immobile
            } else {
                button.disabled = false; // Abilita il bottone se un immobile è selezionato
                showRealEstateInfo(select.selectedOptions[0]); // Mostra le informazioni dell'immobile
                realEstateInfo.classList.remove('d-none');
            }
        }

        // Funzione per visualizzare le informazioni dell'immobile selezionato
        function showRealEstateInfo(option) {
            document.getElementById('real-estate-title').textContent = option.getAttribute('data-title');
            document.getElementById('real-estate-description').textContent = option.getAttribute('data-description');
            document.getElementById('real-estate-address').textContent = option.getAttribute('data-address');
            document.getElementById('real-estate-city').textContent = option.getAttribute('data-city');
            document.getElementById('real-estate-rooms').textContent = option.getAttribute('data-rooms');
            document.getElementById('real-estate-beds').textContent = option.getAttribute('data-beds');
            document.getElementById('real-estate-bathrooms').textContent = option.getAttribute('data-bathrooms');
            document.getElementById('real-estate-square-meter').textContent = option.getAttribute('data-square_meter');

            // Aggiorna l'immagine
            var imageUrl = option.getAttribute('data-image');
            document.getElementById('real-estate-image').src = imageUrl;
        }

        // Ascolta i cambiamenti nel campo select
        select.addEventListener('change', toggleButton);

        // Chiamata iniziale per verificare lo stato del bottone
        toggleButton();

        // Braintree Drop-in setup
        braintree.dropin.create({
            authorization: '{{ $clientToken }}',
            container: '#dropin-container'
        }, function(createErr, instance) {
            button.addEventListener('click', function(event) {
                event.preventDefault();

                instance.requestPaymentMethod(function(err, payload) {
                    if (err) {
                        console.error(err);
                        return;
                    }

                    var form = document.getElementById('payment-form');
                    var nonceInput = document.createElement('input');
                    nonceInput.setAttribute('type', 'hidden');
                    nonceInput.setAttribute('name', 'nonce');
                    nonceInput.setAttribute('value', payload.nonce);
                    form.appendChild(nonceInput);

                    form.submit();
                });
            });
        });
    </script>
@endsection
