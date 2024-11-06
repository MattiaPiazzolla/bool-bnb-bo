<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRealEstateRequest extends FormRequest
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
            'price' => 'required|numeric|min:0',
            'structure_types' => 'required|string|max:50',
            'availability' => 'required|boolean',
            'rooms' => 'nullable|integer|min:0',
            'bathrooms' => 'nullable|integer|min:0',
            'beds' => 'nullable|integer|min:0',
            'square_meter' => 'nullable|integer|min:0',
            'portrait' => 'nullable|image|max:2048', 
            'services' => 'required|array|min:1',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Il titolo è obbligatorio.',
            'description.max' => 'La descrizione non può superare i 500 caratteri.',
            'price.required' => 'Il prezzo è obbligatorio.',
            'structure_types.required' => 'La tipologia di struttura è obbligatoria.',
            'availability.required' => 'La disponibilità è obbligatoria.',
            'rooms.integer' => 'Il numero di stanze deve essere un numero intero.',
            'bathrooms.integer' => 'Il numero di bagni deve essere un numero intero.',
            'beds.integer' => 'Il numero di letti deve essere un numero intero.',
            'square_meter.integer' => 'La superficie in metri quadrati deve essere un numero intero.',
            'portrait.image' => 'Il file deve essere un\'immagine.',
            'portrait.max' => 'L\'immagine non può superare i 2 MB.',
            'services.required' => 'Selezionare almeno un servizio.',
            'services.array' => 'I servizi devono essere un array.',
            'services.min' => 'Selezionare almeno un servizio.',
        ];
    }
}