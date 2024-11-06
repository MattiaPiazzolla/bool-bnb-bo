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
        $services = naServices::orderBy('me', 'asc')->get();

        // Ritorna la vista create con i servizi
        return view('RealEstate.create', compact('services'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreRealEstateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRealEstateRequest $request)
    {
        $real_estate = new RealEstate();
        $real_estate->fill($request->only([
            'title', 'description', 'address', 'city', 'price', 'structure_types', 
            'availability', 'rooms', 'bathrooms', 'beds', 'square_meter'
        ]));
        $real_estate->user_id = Auth::id();

        // Ottieni le coordinate dell'immobile
        $coordinates = $this->getCoordinates($real_estate->address, $real_estate->city);
        if ($coordinates) {
            $real_estate->latitude = $coordinates['latitude'];
            $real_estate->longitude = $coordinates['longitude'];
        }

        // Salva l'immobile
        $real_estate->save();

        // Gestione dell'immagine
        if ($request->hasFile('portrait')) {
            $file = $request->file('portrait');
            $slugTitle = Str::slug($real_estate->title);
            $filename = $real_estate->id . '-' . $slugTitle . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('copertine_immobili', $filename, 'public');
            $real_estate->portrait = $path;
            $real_estate->save();
        }

        // Associa i servizi selezionati
        if ($request->has('services')) {
            $real_estate->services()->sync($request->input('services'));
        }

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
    $latitude = $real_estate->latitude;
    $longitude = $real_estate->longitude;

    if ($real_estate->user_id !== Auth::id()) {
        abort(403, 'Cosa fai? Non è il tuo appartamento :(');
    }

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

    if ($real_estate->user_id !== Auth::id()) {
        abort(403, 'Cosa fai? Non è il tuo appartamento :(');
    }

    // Ottieni tutti i servizi disponibili
    $all_services = Services::orderBy('name', 'asc')->get();

    // Ritorna la vista edit con i dati dell'immobile e i servizi disponibili
    return view('RealEstate.edit', compact('real_estate', 'all_services'));
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
        $real_estate = RealEstate::findOrFail($id);

        if ($real_estate->user_id !== Auth::id()) {
            abort(403, 'Cosa fai? Non è il tuo appartamento :(');
        }

        // Aggiorna i dati dell'immobile
        $real_estate->fill($request->only([
            'title', 'description', 'address', 'city', 'price', 'structure_types', 
            'availability', 'rooms', 'bathrooms', 'beds', 'square_meter'
        ]));

        // Gestione dell’immagine
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

        $real_estate->save();

        // Aggiorna i servizi associati
        if ($request->has('services')) {
            $real_estate->services()->sync($request->input('services'));
        } else {
            $real_estate->services()->detach(); // Rimuove tutti i servizi se nessuno è selezionato
        }

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
    protected function getCoordinates($address, $city)
    {
        $apiKey = '9Yq5kH65us12yazEXv9SX8bGsAYxX1fL';
        $fullAddress = urlencode("$address, $city");

        $response = Http::get("https://api.tomtom.com/search/2/geocode/{$fullAddress}.json", [
            'key' => $apiKey
        ]);

        if ($response->successful()) {
            $data = $response->json();
            if (!empty($data['results'])) {
                return [
                    'latitude' => $data['results'][0]['position']['lat'],
                    'longitude' => $data['results'][0]['position']['lon'],
                ];
            }
        }
        return null;
    }
}