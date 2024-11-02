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
    // Recupero tutti gli immobili
    $real_estates = RealEstate::all();

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
    $real_estate->avilability = $request->input('avilability');
    $real_estate->rooms = $request->input('rooms');
    $real_estate->bathrooms = $request->input('bathrooms');
    $real_estate->beds = $request->input('beds');
    $real_estate->square_meter = $request->input('square_meter');

    $real_estate->user_id = Auth::id();

    // Chiamata alla funzione per ottenere le coordinate
    $coordinates = $this->getCoordinates($real_estate->address, $real_estate->city);
    if ($coordinates) {
        $real_estate->latitude = $coordinates['latitude'];
        $real_estate->longitude = $coordinates['longitude'];
    } else {
        $real_estate->latitude = null;
        $real_estate->longitude = null;
    }

    // Gestione del caricamento dell'immagine di copertina
    if ($request->hasFile('portrait')) {
        $file = $request->file('portrait');
        $filename = $real_estate->id . '-' . Str::slug($real_estate->title) . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('copertine_immobili', $filename, 'public'); // Salva nea cartella 'copertine_immobili'

        $real_estate->portrait = $filename; // Salva il nome del file nel database
    }

    $real_estate->save(); // Salva l'immobile

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
    public function edit(RealEstate $real_estates)
    {
        return view('real_estates.edit', compact('real_estates'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\real_estates  $real_estates
     * @return \Illuminate\Http\Response
     */
    public function update( $request, $realEstate)
    {
       
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\real_estates  $real_estates
     * @return \Illuminate\Http\Response
     */
    public function destroy(RealEstate $real_estates)
    {
        $real_estates->delete();
        return redirect()->route('real_estates.index')->with('success', 'Real Estate deleted successfully');
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