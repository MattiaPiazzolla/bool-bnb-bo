<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\services;  // Usa il modello 'services' come definito
use Illuminate\Http\JsonResponse;

class ServiceController extends Controller
{
    public function index(): JsonResponse
{
    $services = Services::all();  // Assicurati che Services sia il nome corretto del modello
    return response()->json([
        'success' => true,
        'data' => $services
    ]);
}
}