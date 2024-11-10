<?php

namespace App\Http\Controllers;

use App\Models\subscriptions;
use App\Models\RealEstate;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Carbon\Carbon;

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
        // Recupera gli immobili dell'utente senza sottoscrizioni attive
        $real_estates = RealEstate::where('user_id', auth()->id())
            ->whereDoesntHave('subscriptions', function ($query) {
                $query->where('end_subscription', '>', now());
            })
            ->orderBy('title', 'asc')
            ->get();
    
        // Recupera tutte le opzioni di sottoscrizione ordinate per prezzo (dal più economico al più caro)
        $subscriptions = Subscription::orderBy('price', 'asc')->get(); // Assicurati che 'price' sia il nome corretto del campo nel modello Subscription
    
        return view('subscriptions.create', compact('real_estates', 'subscriptions'));
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
    $real_estate->subscriptions()->attach($subscription);

    return redirect()->route('admin.subscriptions.index')->with('success', 'Immobile sponsorizzato con successo');
}

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\subscriptions  $subscriptions
     * @return \Illuminate\Http\Response
     */
    public function show(Subscription $subscription)
    {
        // Recupera tutti gli immobili disponibili (puoi aggiungere filtri se necessario)
        $real_estates = RealEstate::all();
    
        // Mostra la vista con i dettagli della sponsorizzazione e gli immobili
        return view('subscriptions.show', compact('subscription', 'real_estates'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\subscriptions  $subscriptions
     * @return \Illuminate\Http\Response
     */
    public function edit(subscriptions $subscriptions)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\subscriptions  $subscriptions
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, subscriptions $subscriptions)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\subscriptions  $subscriptions
     * @return \Illuminate\Http\Response
     */
    public function destroy(subscriptions $subscriptions)
    {
        //
    }
}