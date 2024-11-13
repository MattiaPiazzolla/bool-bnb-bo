@extends('dashboard')

@section('main-content')
    <div class="container mt-5">
        <h1 class="mb-3">Dettagli del Messaggio</h1>

        <div class="card">
            <div class="card-header bg-white">
                Messaggio di {{ $message->name }} {{ $message->surname }}
            </div>
            <div class="card-body">
                <p><strong>Email:</strong> {{ $message->email }}</p>
                <p><strong>Telefono:</strong> {{ $message->phone }}</p>
                <p><strong>Interessato a:</strong> {{ $message->RealEstate->title }} / {{ $message->RealEstate->address }}
                    / {{ $message->RealEstate->city }}</p>
                <p><strong>Messaggio:</strong> {{ $message->message }}</p>
            </div>
            <div class="card-footer d-flex justify-content-end">
                <a href="{{ route('admin.messages.index') }}" class="btn btn-secondary">Torna ai messaggi</a>
            </div>
        </div>
    </div>
@endsection
