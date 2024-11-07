<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:50'],
            'surname' => ['required', 'string', 'max:50'],
            'date_of_birth' => ['required', 'date'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'], // Aggiungi webp qui
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
    
        // Creazione utente senza l'immagine
        $user = User::create([
            'name' => $request->name,
            'surname' => $request->surname,
            'date_of_birth' => $request->date_of_birth,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
    
        // Verifica che l'utente sia stato creato
        if ($user) {
            // Caricamento dell'immagine, se esiste
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $fileName = $user->id . '-' . $user->name . '-' . $user->surname . '.' . $file->getClientOriginalExtension();
                $filePath = $file->storeAs('store/userProfilePictures', $fileName, 'public'); // Salva in storage/app/public/store/userProfilePictures
    
                // Salva il percorso dell'immagine nel database
                $user->image = $filePath;
                $user->save();
            }
    
            event(new Registered($user));
    
            Auth::login($user);
    
            return redirect('/admin');
        }
    
        // Ritorna un errore se la creazione fallisce
        return redirect()->back()->withErrors(['error' => 'Errore durante la registrazione. Riprova.']);
    }
}