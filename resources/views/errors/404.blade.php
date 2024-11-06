<!-- resources/views/errors/404.blade.php -->
@extends('layouts.app')

@section('title', 'Pagina non trovata')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h1 class="display-4">Oops! La pagina che cerchi non esiste.</h1>
                <p class="lead">Sembra che la pagina che stai cercando non sia stata trovata. Verifica l'URL o torna alla
                    <a href="{{ url('/') }}">home</a>.</p>
                <div class="alert alert-warning">
                    <strong>Errore 404:</strong> Pagina non trovata
                </div>
            </div>
        </div>
    </div>
@endsection
