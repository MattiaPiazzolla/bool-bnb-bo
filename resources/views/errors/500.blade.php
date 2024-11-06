<!-- resources/views/errors/500.blade.php -->
@extends('layouts.app')

@section('title', 'Errore del server')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h1 class="display-4">Oops! C'è stato un errore nel nostro server.</h1>
                <p class="lead">Ci scusiamo per l'inconveniente, stiamo cercando di risolvere il problema.</p>
                <div class="alert alert-danger">
                    <strong>Errore 500:</strong> Errore interno del server
                </div>
            </div>
        </div>
    </div>
@endsection
