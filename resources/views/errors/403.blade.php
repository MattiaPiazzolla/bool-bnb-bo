<!-- resources/views/errors/403.blade.php -->
@extends('layouts.app')

@section('title', 'Accesso negato')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center align-items-center text-center">
            <div class="col-md-8">
                <h1 class="display-4">Accesso negato</h1>
                <p class="lead">Cosa fai? Non è il tuo appartamento :(</p>
                <div class="alert alert-danger">
                    <strong>Errore 403:</strong> Accesso vietato.
                </div>
            </div>
        </div>
    </div>
@endsection
