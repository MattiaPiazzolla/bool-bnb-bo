<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRealEstateRequest extends FormRequest
{
    public function authorize()
    {
        return true; 
    }

    public function rules()
    {
        return [
            'title' => 'required|string|max:150',
            'description' => 'nullable|string|max:500',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:50',
            'price' => 'required|numeric|min:0',
            'structure_types' => 'required|string|max:50',
            'availability' => 'required|boolean',
            'rooms' => 'nullable|integer|min:0',
            'bathrooms' => 'nullable|integer|min:0',
            'beds' => 'nullable|integer|min:0',
            'square_meter' => 'nullable|integer|min:0',
            'portrait' => 'nullable|image|max:2048', 
        ];
    }
}