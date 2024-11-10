@extends('layouts.app')

@section('content')
    <div class="wrapper d-flex">
        <!--sidebar-->
        <div class="side-bar d-flex flex-column justify-content-between py-5">
            <!--sezione menu-->
            <ul class="text-white d-flex flex-column list-unstyled gap-3 py-5">
                <li><a href="{{ route('admin.RealEstates.index') }}">I tuoi annunci</a></li>
                <li><a href="{{ route('admin.RealEstates.create') }}">Aggiungi immobile</a></li>
                <li><a href="{{ route('admin.subscriptions.index') }}"><span class="me-2">Metti in evidenza</span><i
                            class="bi bi-stars"></i></a></li>
                <li><a href="#">Messaggi</a></li>
                <li><a href="#">Statistiche</a></li>
            </ul>

            <div class="bottom-menu d-flex flex-column justify-content-center">
                <!--menu d'accesso al logout rapido e al proprio profilo direttamente in sidebar-->
                <div class="img-box mb-2">
                    @if (Auth::user()->image)
                        <!-- Mostra l'immagine dell'utente se presente -->
                        <img src="{{ asset('storage/' . Auth::user()->image) }}" alt="Immagine Profilo">
                    @else
                        <!-- Visualizza le iniziali dell'utente con CSS -->
                        <div class="initials-avatar">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}{{ strtoupper(substr(Auth::user()->surname, 0, 1)) }}
                        </div>
                    @endif
                </div>
                <h4 class="userNameSidebar">{{ Auth::user()->name }}</h4>
                <!-- Form di logout -->
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="logout"
                        style="background: none; border: none; color: inherit; cursor: pointer;">
                        Logout
                    </button>
                </form>
            </div>
        </div>

        <div class="dash-content">
            <!--Sezione dedicata allo yield. Qui vedrai tutto il contenuto effettivo della dashboard-->
            @yield('main-content')
        </div>
    </div>
@endsection
