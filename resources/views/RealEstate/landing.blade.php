@extends('dashboard')
@section('main-content')
    <div class="wrapper bg-light p-5">
        <h1 class="title mb-4 rainbow">Benvenuto <br>nella tua dashboard personale</h1>
        <h1 class="mb-1 rainbow">Questa è l'area dedicata a te</h1>
        <p class="mb-4">Qui potrai gestire gli annunci per i tuoi immobili, ricevere messaggi da chiunque<br> sia
            interessato e consultare le statistiche relative al tuo annuncio.</p>
        <h2 class="mb-4 rainbow">Cosa aspetti? Pubblica il tuo primo annuncio!</h2>
        <a href="{{ route('admin.RealEstates.create') }}"><button class="btn btn-primary">Iniziamo</button></a>
    </div>
@endsection
