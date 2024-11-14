<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RealEstateController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\MessageController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Rotta per ottenere tutti gli immobili
Route::get('real-estates', [RealEstateController::class, 'index']);

// Rotta per ottenere i dettagli di un immobile specifico
Route::get('real-estates/{id}', [RealEstateController::class, 'show']);

// Rotta per ottenere la lista dei servizi
Route::get('/services', [ServiceController::class, 'index']);

// Rotta per inviare un messaggio
Route::post('/messages', [MessageController::class, 'store']);

// Rotta per registrare una visualizzazione di un immobile
Route::post('real-estates/{id}/view', [RealEstateController::class, 'storeView']);