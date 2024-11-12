@extends('dashboard')

@section('main-content')
    <div class="container mt-5">
        <h1 class="mb-3">Dettagli del Messaggio</h1>

        <div class="card">
            <div class="card-header">
                Messaggio di {{ $message->name }} {{ $message->surname }}
            </div>
            <div class="card-body">
                <h5 class="card-title">Dettagli</h5>
                <p><strong>Email:</strong> {{ $message->email }}</p>
                <p><strong>Telefono:</strong> {{ $message->phone }}</p>
                <p><strong>Messaggio:</strong> {{ $message->message }}</p>
            </div>
            <div class="card-footer">
                <a href="{{ route('admin.messages.index') }}" class="btn btn-secondary">Torna alla lista</a>
            </div>
        </div>
    </div>
@endsection
