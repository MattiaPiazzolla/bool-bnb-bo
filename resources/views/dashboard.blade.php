@extends('layouts.app')

@section('content')
    <div class="wrapper d-flex">
        <!--sidebar-->
        <div class="side-bar d-flex flex-column justify-content-between p-3 py-4">
            <div class="div">
                <div class="bottom-menu d-flex flex-column justify-content-center">
                    <div class="d-flex align-items-center side-cont-alwayson p-2">
                        <!--menu d'accesso al logout rapido e al proprio profilo direttamente in sidebar-->
                        <div class="img-box me-3">
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
                        <h4 class="userNameSidebar mt-2">{{ Auth::user()->name }}</h4>
                    </div>
                </div>



                <!--sezione menu-->
                <ul class="text-white d-flex flex-column list-unstyled mt-5 gap-4">
                    <a href="{{ route('admin.RealEstates.index') }}"
                        class="d-flex side-cont p-2 mb-3 {{ request()->routeIs('admin.RealEstates.index', 'admin.RealEstates.show') ? 'side-cont-alwayson' : '' }}">
                        <i class="bi bi-substack me-2"></i>
                        <span class="text-white">I tuoi annunci</span>
                    </a>

                    <a href="{{ route('admin.RealEstates.create') }}"
                        class="d-flex side-cont p-2 mb-3 {{ request()->routeIs('admin.RealEstates.create') ? 'side-cont-alwayson' : '' }}">
                        <i class="bi bi-plus-circle-fill me-2"></i>
                        <span class="text-white">Aggiungi immobile</span>
                    </a>

                    <a href="{{ route('admin.subscriptions.index') }}"
                        class="d-flex side-cont p-2 mb-3 {{ request()->routeIs('admin.subscriptions.index', 'admin.subscriptions.show') ? 'side-cont-alwayson' : '' }}">
                        <i class="bi bi-badge-ad-fill me-2"></i>
                        <span class="text-white">Metti in evidenza</span>
                    </a>

                    <a href="{{ route('admin.messages.index') }}"
                        class="d-flex side-cont p-2 mb-3  {{ request()->routeIs('admin.messages.index', 'admin.messages.show') ? 'side-cont-alwayson' : '' }}">
                        <i class="bi bi-chat-left-dots-fill me-2"></i>
                        <span class="text-white">Messaggi</span>
                    </a>

                </ul>
            </div>

            <form action="{{ route('logout') }}" method="POST" style="display: inline;"
                class="d-none d-lg-flex side-cont-alwayson p-2">
                @csrf
                <button type="submit" class="logout" style="background: none; border: none; cursor: pointer;">
                    <i class="bi bi-box-arrow-left me-2"></i>
                    <span class="text-white">Logout</span>
                </button>
            </form>
        </div>

        <div class="dash-content">

            <!--Sezione dedicata allo yield. Qui vedrai tutto il contenuto effettivo della dashboard-->
            @yield('main-content')
        </div>
    </div>
@endsection
