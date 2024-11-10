<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Braintree\Gateway;
use App\Models\RealEstate;
use App\Models\Subscription;
use Carbon\Carbon;

class BraintreeController extends Controller
{
    public function token(Request $request)
    {
        // Configura il gateway Braintree
        $gateway = new Gateway([
            'environment' => env('BRAINTREE_ENVIRONMENT'),
            'merchantId' => env('BRAINTREE_MERCHANT_ID'),
            'publicKey' => env('BRAINTREE_PUBLIC_KEY'),
            'privateKey' => env('BRAINTREE_PRIVATE_KEY'),
        ]);

        // Se c'è il nonce (che proviene dalla transazione di pagamento)
        if ($request->input('nonce') != null) {
            $nonceFromTheClient = $request->input('nonce');
            $realEstateId = $request->input('real_estate_id'); // Assicurati che l'immobile sia passato nel form

            // Recupera l'immobile selezionato
            $realEstate = RealEstate::findOrFail($realEstateId);

            // Esegui la transazione
            $result = $gateway->transaction()->sale([
                'amount' => '10.00', // Aggiungi il prezzo corretto dinamicamente
                'paymentMethodNonce' => $nonceFromTheClient,
                'options' => [
                    'submitForSettlement' => true
                ]
            ]);

            // Se la transazione è stata completata con successo
            if ($result->success) {
                // Recupera la sottoscrizione associata (ad esempio, la più economica, o quella selezionata nel form)
                $subscription = Subscription::findOrFail($request->input('subscription_id'));

                // Calcola la data di fine della sottoscrizione (ad esempio, 30 giorni da oggi)
                $endSubscription = Carbon::now()->addDays(30); // Modifica la durata se necessario

                // Inserisci nella tabella ponte real_estate_subscription
                $realEstate->subscriptions()->attach($subscription, [
                    'end_subscription' => $endSubscription
                ]);

                // Reindirizza con un messaggio di successo
                return redirect()->route('admin.subscriptions.index')->with('success', 'Pagamento completato con successo e immobile sponsorizzato!');
            } else {
                // Se la transazione fallisce
                return redirect()->route('admin.subscriptions.index')->with('error', 'Errore nel pagamento. Riprova.');
            }
        }

        // Ottieni il client token per Braintree
        $clientToken = $gateway->clientToken()->generate();

        // Mostra il form per il pagamento
        return view('subscriptions.braintree', ['token' => $clientToken]);
    }

    // Pagina di conferma dopo il pagamento
    public function confirmation()
    {
        return view('subscriptions.confirmation');
    }
}