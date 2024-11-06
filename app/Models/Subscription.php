<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    // Aggiungi il campo duration se non esiste
    protected $fillable = ['name', 'duration'];

    public function realEstates()
    {
        return $this->belongsToMany(RealEstate::class, 'real_estate_subscription')
                    ->withPivot('end_subscription')
                    ->withTimestamps();
    }
}