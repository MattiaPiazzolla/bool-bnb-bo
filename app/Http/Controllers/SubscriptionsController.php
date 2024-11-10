<?php

namespace App\Http\Controllers;

use App\Models\RealEstate;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Braintree\Gateway;

class SubscriptionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Recupera tutte le sponsorizzazioni
        $subscriptions = Subscription::all();
    
        // Mostra la vista con l'elenco delle sponsorizzazioni
        return view('subscriptions.index', compact('subscriptions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Recupera tutti gli immobili e la sottoscrizione che vuoi mostrare
        $realEstates = RealEstate::all();
        $subscription = Subscription::first(); // O un altro metodo per ottenere la sottoscrizione desiderata

        return view('subscriptions.show', compact('realEstates', 'subscription'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'real_estate_id' => 'required|exists:real_estates,id',
            'subscription_id' => 'required|exists:subscriptions,id',
        ]);

        // Logica per salvare la sponsorizzazione (ad esempio, creando una relazione nella tabella pivot)
        $subscription = Subscription::find($request->subscription_id);
        $real_estate = RealEstate::find($request->real_estate_id);

        // Salva la sponsorizzazione (esempio con relazione many-to-many)
        // Assicurati che tu abbia una relazione many-to-many definita nel modello RealEstate (subscriptions)
        $real_estate->subscriptions()->attach($subscription);

        return redirect()->route('admin.subscriptions.index')->with('success', 'Immobile sponsorizzato con successo');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    public function show(Subscription $subscription)
    {
        $gateway = new \Braintree\Gateway([
            'environment' => env('BRAINTREE_ENVIRONMENT'),
            'merchantId' => env("BRAINTREE_MERCHANT_ID"),
            'publicKey' => env("BRAINTREE_PUBLIC_KEY"),
            'privateKey' => env("BRAINTREE_PRIVATE_KEY")
        ]);
    
        // Genera il token client di Braintree
        $clientToken = $gateway->clientToken()->generate();
    
        // Recupera gli immobili non ancora sponsorizzati e appartenenti all'utente autenticato
        $realEstates = RealEstate::where('user_id', auth()->id())  // Filtra per immobile dell'utente autenticato
                                 ->whereDoesntHave('subscriptions')  // Esclude gli immobili già sponsorizzati
                                 ->get();
    
        // Mostra la vista con gli immobili non sponsorizzati, la sottoscrizione e il token di Braintree
        return view('subscriptions.show', compact('subscription', 'realEstates', 'clientToken'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    public function edit(Subscription $subscription)
    {
        // Mostra la vista per la modifica di una sottoscrizione (se applicabile)
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subscription $subscription)
    {
        // Logica per aggiornare una sottoscrizione esistente
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subscription $subscription)
    {
        // Logica per eliminare una sottoscrizione
    }
}