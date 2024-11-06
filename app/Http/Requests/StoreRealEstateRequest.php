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
            'services' => 'required|array|min:1', 
        ];
    }
    
    public function messages()
    {
        return [
            'title.required' => 'Il titolo è obbligatorio.',
            'title.string' => 'Il titolo deve essere una stringa.',
            'title.max' => 'Il titolo non può superare i :max caratteri.',
            
            'description.string' => 'La descrizione deve essere una stringa.',
            'description.max' => 'La descrizione non può superare i :max caratteri.',
            
            'address.required' => 'L\'indirizzo è obbligatorio.',
            'address.string' => 'L\'indirizzo deve essere una stringa.',
            'address.max' => 'L\'indirizzo non può superare i :max caratteri.',
            
            'city.required' => 'La città è obbligatoria.',
            'city.string' => 'La città deve essere una stringa.',
            'city.max' => 'La città non può superare i :max caratteri.',
            
            'price.required' => 'Il prezzo è obbligatorio.',
            'price.numeric' => 'Il prezzo deve essere un numero.',
            'price.min' => 'Il prezzo deve essere maggiore o uguale a :min.',
            
            'structure_types.required' => 'La tipologia di struttura è obbligatoria.',
            'structure_types.string' => 'La tipologia di struttura deve essere una stringa.',
            'structure_types.max' => 'La tipologia di struttura non può superare i :max caratteri.',
            
            'availability.required' => 'La disponibilità è obbligatoria.',
            'availability.boolean' => 'La disponibilità deve essere true o false.',
            
            'rooms.integer' => 'Il numero di stanze deve essere un numero intero.',
            'rooms.min' => 'Il numero di stanze deve essere maggiore o uguale a :min.',
            
            'bathrooms.integer' => 'Il numero di bagni deve essere un numero intero.',
            'bathrooms.min' => 'Il numero di bagni deve essere maggiore o uguale a :min.',
            
            'beds.integer' => 'Il numero di letti deve essere un numero intero.',
            'beds.min' => 'Il numero di letti deve essere maggiore o uguale a :min.',
            
            'square_meter.integer' => 'Il numero di metri quadrati deve essere un numero intero.',
            'square_meter.min' => 'Il numero di metri quadrati deve essere maggiore o uguale a :min.',
            
            'portrait.image' => 'L\'immagine deve essere un file immagine.',
            'portrait.max' => 'L\'immagine non può superare i :max kilobyte.',
            
            'services.required' => 'Selezionare almeno un servizio.',
            'services.array' => 'I servizi devono essere un array.',
            'services.min' => 'Selezionare almeno un servizio.',
        ];
    }
}