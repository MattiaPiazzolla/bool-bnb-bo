<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class services extends Model  // Mantieni il nome 'services' in minuscolo
{
    protected $table = 'services';  // Specifica esplicitamente il nome della tabella

    protected $fillable = [
        'name',
    ];

    // Relazione many-to-many con RealEstate
    public function realEstates(): BelongsToMany
    {
        return $this->belongsToMany(RealEstate::class, 'real_estate_service', 'service_id', 'real_estate_id');
    }
}