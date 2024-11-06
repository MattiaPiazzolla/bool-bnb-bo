<?php

namespace App\Http\Controllers\Admin;

use App\Models\RealEstate;
use App\Models\Services;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Subscription;
use App\Http\Requests\StoreRealEstateRequest; // Importa la classe StoreRealEstateRequest
use App\Http\Requests\UpdateRealEstateRequest; // Importa la classe UpdateRealEstateRequest

class RealEstatesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Recupera solo gli immobili associati all'utente loggato
        $real_estates = RealEstate::where('user_id', auth()->id())->get();
        

        // Passa la variabile alla vista
        return view('RealEstate.index', compact('real_estates'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        // Recupera tutti i servizi disponibili
        $services = Services::orderBy('name', 'asc')->get();

        $subscriptions = Subscription::orderBy('name', 'asc')->get();

        // Ritorna la vista create con i servizi
        return view('RealEstate.create', compact('services', 'subscriptions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreRealEstateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRealEstateRequest $request)
    {
        // Ottieni le coordinate dall'input della mappa
        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');
        
        // Recupera i dettagli dell'indirizzo tramite l'API di TomTom
        $locationDetails = $this->getAddressFromCoordinates($latitude, $longitude);
        $address = $locationDetails['address'] ?? '';
        $city = $locationDetails['city'] ?? '';
    
        // Crea e salva l'immobile
        $real_estate = new RealEstate();
        $real_estate->fill($request->only([
            'title', 'price', 'availability', 'structure_types', 'rooms', 
            'bathrooms', 'beds', 'square_meter', 'description'
        ]));
        
        // Imposta l'indirizzo e la città
        $real_estate->address = $address;
        $real_estate->city = $city;
        $real_estate->latitude = $latitude;
        $real_estate->longitude = $longitude;
        $real_estate->user_id = Auth::id();
    
        // Salva l'immobile
        $real_estate->save();
    
        // Associa i servizi selezionati
        if ($request->has('services')) {
            $real_estate->services()->sync($request->input('services'));
        }
    
        // Associa le sottoscrizioni, includendo il calcolo della data di fine
        if ($request->has('subscriptions')) {
            foreach ($request->input('subscriptions') as $subscription_id) {
                $subscription = Subscription::find($subscription_id);
    
                if ($subscription) {
                    $durationInHours = $subscription->duration;
    
                    // Verifica che la durata sia un valore valido
                    if ($durationInHours && $durationInHours > 0) {
                        // Calcola la data di fine
                        $end_subscription = Carbon::now()->addHours($durationInHours);
    
                        // Associa la sottoscrizione all'immobile
                        $real_estate->subscriptions()->attach($subscription_id, [
                            'end_subscription' => $end_subscription
                        ]);
                    } else {
                        // Se la durata non è valida, puoi scegliere di gestire l'errore
                        return redirect()->route('admin.RealEstates.index')->with('error', 'Durata della sottoscrizione non valida.');
                    }
                } else {
                    // Se la sottoscrizione non è stata trovata
                    return redirect()->route('admin.RealEstates.index')->with('error', 'Sottoscrizione non trovata.');
                }
            }
        }
    
        // Gestione dell'immagine
        if ($request->hasFile('portrait')) {
            $file = $request->file('portrait');
            $slugTitle = Str::slug($real_estate->title);
            $filename = $real_estate->id . '-' . $slugTitle . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('copertine_immobili', $filename, 'public');
            $real_estate->portrait = $path;
        }
    
        // Salva l'immobile dopo aver gestito l'immagine
        $real_estate->save();
    
        // Ritorna con il messaggio di successo
        return redirect()->route('admin.RealEstates.index')->with('success', 'Immobile creato con successo.');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
{
    $real_estate = RealEstate::with('services')->findOrFail($id);

    // Verifica che l'immobile appartenga all'utente loggato
    if ($real_estate->user_id !== Auth::id()) {
        abort(403, 'Cosa fai? Non è il tuo appartamento :(');
    }

    $latitude = $real_estate->latitude;
    $longitude = $real_estate->longitude;

        return view('RealEstate.show', compact('real_estate', 'latitude', 'longitude'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Trova l'immobile tramite ID
        $real_estate = RealEstate::findOrFail($id);
    
        // Verifica che l'immobile appartenga all'utente loggato
        if ($real_estate->user_id !== Auth::id()) {
            abort(403, 'Non hai il permesso di modificare questo immobile.');
        }
    
        // Ottieni tutte le sottoscrizioni
        $subscriptions = Subscription::all();
    
        // Ottieni tutti i servizi disponibili
        $all_services = Services::orderBy('name', 'asc')->get();
    
        // Passa i dati alla vista
        return view('RealEstate.edit', compact('real_estate', 'subscriptions', 'all_services'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateRealEstateRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRealEstateRequest $request, $id)
{
    // Trova l'immobile tramite ID
    $real_estate = RealEstate::findOrFail($id);

    // Verifica che l'immobile appartenga all'utente loggato
    if ($real_estate->user_id !== Auth::id()) {
        abort(403, 'Non hai il permesso di modificare questo immobile.');
    }

    // Aggiorna i dati dell'immobile
    $real_estate->fill($request->only([
        'title',
        'description',
        'address',
        'city',
        'price',
        'structure_types',
        'availability',
        'rooms',
        'bathrooms',
        'beds',
        'square_meter'
    ]));

    // Gestione dell’immagine (se presente)
    if ($request->hasFile('portrait')) {
        // Elimina l'immagine precedente
        if ($real_estate->portrait) {
            Storage::disk('public')->delete($real_estate->portrait);
        }

        // Salva la nuova immagine
        $file = $request->file('portrait');
        $filename = $real_estate->id . '-' . Str::slug($real_estate->title) . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('copertine_immobili', $filename, 'public');
        $real_estate->portrait = $path;
    }

    // **Aggiornamento delle sottoscrizioni** - rimuove quelle non selezionate e aggiunge le nuove
    if ($request->has('subscriptions')) {
        // 1. Rimuovi tutte le sottoscrizioni precedenti
        $real_estate->subscriptions()->detach();

        // 2. Aggiungi le nuove sottoscrizioni selezionate
        foreach ($request->input('subscriptions') as $subscription_id) {
            $subscription = Subscription::find($subscription_id);
            $durationInHours = $subscription->duration; // Durata della sottoscrizione
            
            // Calcola la data di fine sottoscrizione
            $end_subscription = Carbon::now()->addHours($durationInHours);

            // Associa le nuove sottoscrizioni
            $real_estate->subscriptions()->attach($subscription_id, [
                'end_subscription' => $end_subscription
            ]);
        }
    }

    // **Gestione dei servizi** - Assicurati che almeno un servizio sia selezionato
    if ($request->has('services')) {
        // Se ci sono servizi selezionati, associa i servizi all'immobile
        $real_estate->services()->sync($request->input('services'));
    } else {
        // Se non vengono selezionati servizi, rimuovili
        $real_estate->services()->detach();
    }

    // Aggiorna l'immobile
    $real_estate->save();

    // Ritorna alla lista con messaggio di successo
    return redirect()->route('admin.RealEstates.index')->with('success', 'Immobile aggiornato con successo.');
}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $real_estate = RealEstate::findOrFail($id);

        // Elimina l'immagine associata se esiste
        if ($real_estate->portrait) {
            Storage::disk('public')->delete($real_estate->portrait);
        }

        // Rimuove i servizi associati
        $real_estate->services()->detach();

        // Elimina l'immobile
        $real_estate->delete();

        return redirect()->route('admin.RealEstates.index')->with('success', 'Immobile eliminato con successo.');
    }

    /**
     * Ottieni le coordinate geografiche di un indirizzo.
     *
     * @param  string  $address
     * @param  string  $city
     * @return array|null
     */
    protected function getAddressFromCoordinates($latitude, $longitude)
    {
        $apiKey = '9Yq5kH65us12yazEXv9SX8bGsAYxX1fL';
        
        $response = Http::get("https://api.tomtom.com/search/2/reverseGeocode/{$latitude},{$longitude}.json", [
            'key' => $apiKey
        ]);
    
        if ($response->successful()) {
            $data = $response->json();
            if (!empty($data['addresses'])) {
                return [
                    'address' => $data['addresses'][0]['address']['freeformAddress'],
                    'city' => $data['addresses'][0]['address']['municipality'] ?? '',
                ];
            }
        }
        return [];
    }
}