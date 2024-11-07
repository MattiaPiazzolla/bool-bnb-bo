<?php

namespace App\Http\Controllers\Admin;

use App\Models\RealEstate;
use App\Models\Services;
use App\Models\Subscription;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Requests\StoreRealEstateRequest;
use App\Http\Requests\UpdateRealEstateRequest;

class RealEstatesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Recupera gli immobili dell'utente, ordinando per sottoscrizione attiva
        $real_estates = RealEstate::where('user_id', auth()->id())
            ->with(['subscriptions' => function ($query) {
                // Filtra solo le sottoscrizioni attive
                $query->where('end_subscription', '>', Carbon::now());
            }])
            ->orderByRaw('(SELECT COUNT(*) FROM real_estate_subscription WHERE real_estate_id = real_estates.id AND end_subscription > NOW()) DESC')
            ->get();

            

        // Passa gli immobili alla vista
        return view('RealEstate.index', compact('real_estates'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Recupera servizi e sottoscrizioni per il form di creazione
        $services = Services::orderBy('name', 'asc')->get();
        $subscriptions = Subscription::orderBy('name', 'asc')->get();

        return view('RealEstate.create', compact('services', 'subscriptions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRealEstateRequest $request)
    {
        // Gestione coordinate e indirizzo tramite API
        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');
        $locationDetails = $this->getAddressFromCoordinates($latitude, $longitude);
        $address = $locationDetails['address'] ?? '';
        $city = $locationDetails['city'] ?? '';

        // Crea e salva l'immobile
        $real_estate = new RealEstate();
        $real_estate->fill($request->only([
            'title', 'price', 'availability', 'structure_types', 'rooms', 
            'bathrooms', 'beds', 'square_meter', 'description'
        ]));
        $real_estate->address = $address;
        $real_estate->city = $city;
        $real_estate->latitude = $latitude;
        $real_estate->longitude = $longitude;
        $real_estate->user_id = Auth::id();
        $real_estate->save();

        // Associa servizi selezionati
        if ($request->has('services')) {
            $real_estate->services()->sync($request->input('services'));
        }

        // Associa sottoscrizioni con calcolo data di fine
        if ($request->has('subscriptions')) {
            foreach ($request->input('subscriptions') as $subscription_id) {
                $subscription = Subscription::find($subscription_id);
                if ($subscription) {
                    $end_subscription = Carbon::now()->addHours($subscription->duration);
                    $real_estate->subscriptions()->attach($subscription_id, [
                        'end_subscription' => $end_subscription
                    ]);
                }
            }
        }

        // Gestione immagine principale
        if ($request->hasFile('portrait')) {
            $file = $request->file('portrait');
            $slugTitle = Str::slug($real_estate->title);
            $filename = $real_estate->id . '-' . $slugTitle . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('copertine_immobili', $filename, 'public');
            $real_estate->portrait = $path;
            $real_estate->save();
        }

        return redirect()->route('admin.RealEstates.index')->with('success', 'Immobile creato con successo.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $real_estate = RealEstate::with('services')->findOrFail($id);

        if ($real_estate->user_id !== Auth::id()) {
            abort(403, 'Non hai il permesso di visualizzare questo immobile.');
        }

        $latitude = $real_estate->latitude;
        $longitude = $real_estate->longitude;

        return view('RealEstate.show', compact('real_estate', 'latitude', 'longitude'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $real_estate = RealEstate::findOrFail($id);

        if ($real_estate->user_id !== Auth::id()) {
            abort(403, 'Non hai il permesso di modificare questo immobile.');
        }

        $subscriptions = Subscription::all();
        $all_services = Services::orderBy('name', 'asc')->get();

        return view('RealEstate.edit', compact('real_estate', 'subscriptions', 'all_services'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRealEstateRequest $request, $id)
    {
        $real_estate = RealEstate::findOrFail($id);

        if ($real_estate->user_id !== Auth::id()) {
            abort(403, 'Non hai il permesso di modificare questo immobile.');
        }

        $real_estate->fill($request->only([
            'title', 'description', 'address', 'city', 'price', 
            'structure_types', 'availability', 'rooms', 'bathrooms', 
            'beds', 'square_meter'
        ]));

        // Gestione immagine
        if ($request->hasFile('portrait')) {
            if ($real_estate->portrait) {
                Storage::disk('public')->delete($real_estate->portrait);
            }
            $file = $request->file('portrait');
            $filename = $real_estate->id . '-' . Str::slug($real_estate->title) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('copertine_immobili', $filename, 'public');
            $real_estate->portrait = $path;
        }

        // Aggiornamento delle sottoscrizioni
        if ($request->has('subscriptions')) {
            $real_estate->subscriptions()->detach();
            foreach ($request->input('subscriptions') as $subscription_id) {
                $subscription = Subscription::find($subscription_id);
                if ($subscription) {
                    $end_subscription = Carbon::now()->addHours($subscription->duration);
                    $real_estate->subscriptions()->attach($subscription_id, [
                        'end_subscription' => $end_subscription
                    ]);
                }
            }
        }

        // Aggiornamento dei servizi
        if ($request->has('services')) {
            $real_estate->services()->sync($request->input('services'));
        } else {
            $real_estate->services()->detach();
        }

        $real_estate->save();

        return redirect()->route('admin.RealEstates.index')->with('success', 'Immobile aggiornato con successo.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $real_estate = RealEstate::findOrFail($id);

        if ($real_estate->portrait) {
            Storage::disk('public')->delete($real_estate->portrait);
        }

        $real_estate->services()->detach();
        $real_estate->subscriptions()->detach();
        $real_estate->delete();

        return redirect()->route('admin.RealEstates.index')->with('success', 'Immobile eliminato con successo.');
    }

    /**
     * Ottieni le coordinate geografiche di un indirizzo.
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