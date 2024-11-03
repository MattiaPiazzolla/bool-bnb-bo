<?php

namespace App\Http\Controllers\Admin;

use App\Models\RealEstate;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;



use App\Http\Controllers\Admin\real_estates;

use App\Http\Requests\StoreRealEstateRequest; //Importa la classe StoreRealEstateRequest
use App\Http\Requests\UpdateRealEstateRequest; //Importa la classe UpdateRealEstateRequest

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

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
    // Ritorna la vista create
    return view('RealEstate.create'); 
}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRealEstateRequest $request)
    {
        $real_estate = new RealEstate();
        $real_estate->title = $request->input('title');
        $real_estate->description = $request->input('description');
        $real_estate->address = $request->input('address');
        $real_estate->city = $request->input('city');
        $real_estate->price = $request->input('price');
        $real_estate->structure_types = $request->input('structure_types');
        $real_estate->availability = $request->input('availability');
        $real_estate->rooms = $request->input('rooms');
        $real_estate->bathrooms = $request->input('bathrooms');
        $real_estate->beds = $request->input('beds');
        $real_estate->square_meter = $request->input('square_meter');
        $real_estate->user_id = Auth::id();
    
        // Ottieni le coordinate
        $coordinates = $this->getCoordinates($real_estate->address, $real_estate->city);
        if ($coordinates) {
            $real_estate->latitude = $coordinates['latitude'];
            $real_estate->longitude = $coordinates['longitude'];
        }
    
        // Salva inizialmente l'immobile per ottenere l'ID
        $real_estate->save();
    
        // Gestione dell’immagine
        if ($request->hasFile('portrait')) {
            $file = $request->file('portrait');
            
            // Creazione del nome del file con ID e titolo come slug
            $slugTitle = Str::slug($real_estate->title); // Trasforma il titolo in slug
            $filename = $real_estate->id . '-' . $slugTitle . '.' . $file->getClientOriginalExtension();
    
            // Salva l’immagine nella cartella pubblica con il nome generato
            $path = $file->storeAs('copertine_immobili', $filename, 'public');
            $real_estate->portrait = $path; // Salva il percorso nel campo `portrait`
        }
    
        // Salva nuovamente per aggiornare il campo `portrait`
        $real_estate->save();
    
        return redirect()->route('admin.RealEstates.index')->with('success', 'Immobile creato con successo.');
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\real_estates  $real_estates
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $real_estate = RealEstate::findOrFail($id);
        return view('RealEstate.show', compact('real_estate'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\real_estates  $real_estates
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
{
    // Trova l'immobile tramite ID
    $real_estate = RealEstate::findOrFail($id);

    // Ritorna la vista edit con i dati dell'immobile
    return view('RealEstate.edit', compact('real_estate'));
}  

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\real_estates  $real_estates
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $real_estate = RealEstate::findOrFail($id);
    
        // Valida i dati
        $validatedData = $request->validate([
            'title' => 'required|max:150',
            'description' => 'nullable|max:500',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:50',
            'price' => 'required|numeric|min:0',
            'structure_types' => 'required|string|max:50',
            'availability' => 'required|boolean',
            'rooms' => 'nullable|integer|min:0',
            'bathrooms' => 'nullable|integer|min:0',
            'beds' => 'nullable|integer|min:0',
            'square_meter' => 'nullable|integer|min:0',
            'portrait' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048' // Limita il tipo e la dimensione dell’immagine
        ]);
    
        // Aggiorna i dati dell’immobile
        $real_estate->fill($validatedData);
    
        // Gestione dell’immagine
        if ($request->hasFile('portrait')) {
            // Elimina la vecchia immagine se esiste
            if ($real_estate->portrait) {
                Storage::disk('public')->delete($real_estate->portrait);
            }
    
            // Salva la nuova immagine
            $file = $request->file('portrait');
            $filename = $real_estate->id . '-' . \Str::slug($real_estate->title) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('copertine_immobili', $filename, 'public');
            $real_estate->portrait = $path;
        }
    
        // Salva i dati aggiornati nel DB
        $real_estate->save();
    
        // Redirect con messaggio di successo
        return redirect()->route('admin.RealEstates.index')->with('success', 'Immobile aggiornato con successo.');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\real_estates  $real_estates
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Trova l'immobile tramite ID
        $real_estate = RealEstate::findOrFail($id);
        
        // Controlla se l'immagine esiste e cancellala
        if ($real_estate->portrait) {
            Storage::disk('public')->delete($real_estate->portrait);
        }
        
        // Elimina l'immobile
        $real_estate->delete();
    
        return redirect()->route('admin.RealEstates.index')->with('success', 'Immobile eliminato con successo.');
    }

    // funzione per ottenere le coordinate geografiche di un indirizzo
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