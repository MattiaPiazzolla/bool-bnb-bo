<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class View extends Model
{
    use HasFactory;

    // Colonne che possono essere assegnate in modo massivo
    protected $fillable = [
        'ip_address', 'real_estate_id',
    ];

    // Relazione con RealEstate
    public function realEstate()
    {
        return $this->belongsTo(RealEstate::class, 'real_estate_id');
    }
}