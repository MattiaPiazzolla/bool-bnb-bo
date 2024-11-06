@extends('dashboard')
@section('main-content')
    <div class="wrapper p-5">
        <h1 class="title mb-4">Benvenuto nella tua<br> dashboard personale</h1>
        <h1 class="mb-1">Questa è l'area <span class="span-dashboard">dedicata a te!</span></h1>
        <p class="mb-4">Qui potrai gestire gli annunci per i tuoi immobili, ricevere messaggi da chiunque<br> sia
            interessato e consultare le statistiche relative al tuo annuncio.</p>
        <h2 class="mb-4"><span class="span-dashboard">Cosa aspetti?</span> Pubblica il tuo primo annuncio!</h2>
        <a href="{{ route('admin.RealEstates.create') }}"><button class="btn btn-primary">Iniziamo</button></a>
        <img src="{{ asset('img/houses_img/houses.png') }}" alt="" class="icon-config">
    </div>
@endsection
