<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\RealEstate;
use App\Http\Resources\RealEstateResource; 
use Illuminate\Http\Request;

class RealEstateController extends Controller
{
    // Metodo per ottenere la lista di tutti gli immobili
    public function index()
    {
        // Recupera tutti gli immobili con le sponsorizzazioni e i servizi associati
        $realEstates = RealEstate::with(['subscriptions', 'services'])->orderByRaw('(SELECT COUNT(*) FROM real_estate_subscription WHERE real_estate_id = real_estates.id AND end_subscription > NOW()) DESC')->get();

        // Restituisce i dati in formato JSON
        return response()->json($realEstates);
    }

    // Metodo per ottenere i dettagli di un immobile specifico
    public function show($id)
    {
        // Recupera l'immobile con sponsorizzazioni e servizi associati
        $realEstate = RealEstate::with(['subscriptions', 'services'])->find($id);

        if (!$realEstate) {
            return response()->json(['message' => 'Immobile non trovato'], 404);
        }

        // Restituisce i dati in formato JSON
        return response()->json($realEstate);
    }
}