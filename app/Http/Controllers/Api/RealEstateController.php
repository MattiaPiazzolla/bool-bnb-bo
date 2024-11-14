<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\RealEstate;
use App\Models\View;
use Illuminate\Http\Request;

class RealEstateController extends Controller
{
    // Metodo per ottenere la lista di tutti gli immobili
    public function index()
    {
        // Recupera tutti gli immobili con le sponsorizzazioni e i servizi associati
        $realEstates = RealEstate::with(['subscriptions', 'services'])
            ->orderByRaw('(SELECT COUNT(*) FROM real_estate_subscription WHERE real_estate_id = real_estates.id AND end_subscription > NOW()) DESC')
            ->get();

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

        // Ottieni l'indirizzo IP dell'utente che visita l'immobile
        $ip = request()->ip();

        // Verifica se l'IP ha già visualizzato questo immobile
        $existingView = View::where('real_estate_id', $realEstate->id)
                            ->where('ip_address', $ip)
                            ->first();

        if (!$existingView) {
            // Se l'IP non ha visualizzato questo immobile, registra una nuova visualizzazione
            View::create([
                'real_estate_id' => $realEstate->id,
                'ip_address' => $ip,
            ]);
        }

        // Restituisce i dettagli dell'immobile
        return response()->json($realEstate);
    }

    // Metodo per registrare una visualizzazione dell'immobile da un determinato IP
    public function storeView($id)
    {
        // Recupera l'immobile con l'ID passato
        $realEstate = RealEstate::find($id);

        if (!$realEstate) {
            return response()->json(['message' => 'Immobile non trovato'], 404);
        }

        // Ottieni l'indirizzo IP dell'utente
        $ip = request()->ip();

        // Verifica se l'IP ha già visualizzato questo immobile
        $existingView = View::where('real_estate_id', $realEstate->id)
                            ->where('ip_address', $ip)
                            ->first();

        if (!$existingView) {
            // Se l'IP non ha visualizzato questo immobile, registriamo una nuova visualizzazione
            View::create([
                'real_estate_id' => $realEstate->id,
                'ip_address' => $ip,
            ]);
        }

        // Rispondi con i dettagli dell'immobile
        return response()->json($realEstate);
    }
}