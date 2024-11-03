<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\services;

class RealEstate extends Model
{
    // Per quando faremo il soft delete
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
        return $this->belongsToMany(services::class, 'real_estate_service', 'real_estate_id', 'service_id');
    }
}