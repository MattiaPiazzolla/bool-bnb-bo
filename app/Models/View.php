<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class View extends Model
{
    use HasFactory;

    public function realEstate()
    {
        return $this->belongsTo(RealEstate::class, 'real_estate_id');
    }
}