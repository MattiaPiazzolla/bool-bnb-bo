<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'surname',
        'email',
        'phone',
        'message',
        'real_estate_id'
    ];

    // Definisci la relazione con RealEstate
    public function realEstate()
    {
        return $this->belongsTo(RealEstate::class);
    }
}