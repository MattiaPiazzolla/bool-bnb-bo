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
        //
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
    // Validazione dei campi
    $request->validate([
        'real_estate_id' => 'required|exists:real_estates,id',
        'subscription_id' => 'required|exists:subscriptions,id',
    ]);

    $real_estate = RealEstate::where('id', $request->input('real_estate_id'))
        ->where('user_id', auth()->id())
        ->firstOrFail();

    $subscription = Subscription::findOrFail($request->input('subscription_id'));
    $end_subscription = Carbon::now()->addHours($subscription->duration);

    // Associa la sottoscrizione all'immobile con la data di fine
    $real_estate->subscriptions()->attach($subscription->id, [
        'end_subscription' => $end_subscription,
    ]);

    return redirect()->route('admin.RealEstates.index')->with('success', 'Sponsorizzazione aggiunta con successo.');
}

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\subscriptions  $subscriptions
     * @return \Illuminate\Http\Response
     */
    public function show(subscriptions $subscriptions)
    {
        //
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