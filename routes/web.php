<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\RealEstatesController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\SubscriptionsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BraintreeController;
use App\Http\Controllers\MessageController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->name('admin.')->prefix('admin')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('/RealEstates', RealEstatesController::class);

    // Rotte per gestire le sponsorizzazioni
    Route::get('/subscriptions', [SubscriptionsController::class, 'index'])->name('subscriptions.index');
    Route::get('/subscriptions/create', [SubscriptionsController::class, 'create'])->name('subscriptions.create');
    Route::post('/subscriptions/store', [SubscriptionsController::class, 'store'])->name('subscriptions.store');
    Route::get('/subscriptions/{subscription}', [SubscriptionsController::class, 'show'])->name('subscriptions.show');

    // Rotta per Braintree
    Route::any('/subscriptions/braintree', [BraintreeController::class, 'token'])->name('subscriptions.braintree');

    // Rotte per la gestione dei messaggi
    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/{message}', [MessageController::class, 'show'])->name('messages.show');
    Route::delete('/messages/{message}', [MessageController::class, 'destroy'])->name('messages.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/update-picture', [ProfileController::class, 'updatePicture'])->name('profile.updatePicture');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';