<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}