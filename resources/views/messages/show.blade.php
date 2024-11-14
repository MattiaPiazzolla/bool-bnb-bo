@extends('dashboard')

@section('main-content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 d-flex">
                <div class="back-bt">
                    <a href="{{ route('admin.messages.index') }}" class="d-flex align-items-center">
                        <i class="bi bi-arrow-left-short" style="font-size: 2.5rem"></i>
                        <span class="text-primary mt-3" style="font-size: 14pt">Indietro</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="container mt-4 px-md-5">
        <h1 class="mb-3">Dettagli del Messaggio</h1>

        <div class="card">
            <div class="card-header bg-white">
                <span>Messaggio di {{ $message->name }} {{ $message->surname }}</span>
            </div>
            <div class="card-body p-4">
                <p> {{ $message->message }}</p>
            </div>
            <div class="card-footer d-flex flex-column">
                <span class="mb-2"><strong>Email:</strong> {{ $message->email }}</span>
                <span class="mb-2"><strong>Telefono:</strong> {{ $message->phone }}</span>
                <span class=""><strong>Interessato a:</strong> {{ $message->RealEstate->title }} / {{ $message->RealEstate->address }}
                    / {{ $message->RealEstate->city }}</span>
            </div>
        </div>
    </div>
@endsection
