@extends('dashboard')

@section('main-content')
    <div class="container py-5">
        <h2 class="text-center mb-4">Sponsorizza un immobile</h2>

        <form action="{{ route('admin.subscriptions.braintree') }}" method="POST" id="payment-form">
            @csrf

            <!-- Aggiungi il campo per passare l'ID della sottoscrizione -->
            <input type="hidden" name="subscription_id" value="{{ $subscription->id }}">

            <div class="form-group">
                <label for="real_estate_id">Seleziona un immobile</label>
                <select name="real_estate_id" id="real_estate_id" class="form-control" required>
                    <option value="">-- Seleziona un immobile --</option>

                    @foreach ($realEstates as $realEstate)
                        <option value="{{ $realEstate->id }}">{{ $realEstate->title }}</option>
                    @endforeach
                </select>
            </div>

            <div class="card shadow-sm p-4 mt-4">
                <h3 class="text-center mb-4">Pagamento Sicuro</h3>
                <div id="dropin-container" class="mb-4"></div>
                <button id="submit-button" class="btn btn-primary btn-block btn-lg" disabled>Esegui il pagamento</button>
            </div>
        </form>
    </div>

    <script src="https://js.braintreegateway.com/web/dropin/1.31.1/js/dropin.min.js"></script>
    <script>
        var button = document.querySelector('#submit-button');
        var select = document.querySelector('#real_estate_id');

        // Funzione per abilitare/disabilitare il bottone
        function toggleButton() {
            if (select.value === '') {
                button.disabled = true; // Disabilita il bottone se non è selezionato un immobile
            } else {
                button.disabled = false; // Abilita il bottone se un immobile è selezionato
            }
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
