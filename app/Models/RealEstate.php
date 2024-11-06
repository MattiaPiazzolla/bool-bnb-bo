<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes; // Se vuoi usare SoftDeletes
use App\Models\Subscription; // Aggiungi l'importazione per Subscription
use App\Models\Services; // Se usi il modello per i servizi

class RealEstate extends Model
{
    // Se vuoi usare il soft delete, decommenta la riga
    // use SoftDeletes;

    protected $fillable = [
        'title', 'description', 'user_id', 'address',
        'city', 'latitude', 'longitude', 'portrait',
        'price', 'rooms', 'bathrooms', 'beds',
        'square_meter', 'structure_types', 'availability'
    ];

    // Relazione con User
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Relazione many-to-many con Service
    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Services::class, 'real_estate_service', 'real_estate_id', 'service_id');
    }

    // Relazione many-to-many con Subscription
    public function subscriptions()
    {
        return $this->belongsToMany(Subscription::class, 'real_estate_subscription')
                    ->withPivot('end_subscription')  // Per includere la colonna 'end_subscription' nella tabella ponte
                    ->withTimestamps();  // Per tracciare i timestamp di creazione e aggiornamento
    }
}