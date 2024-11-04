@extends('dashboard')

@section('main-content')
    <div class="container">
        <div class="row">
            <div class="col-12 p-5">
                <div class="d-flex align-items-center">
                    <a href="{{ route('admin.RealEstates.index') }}">
                        <i class="bi bi-arrow-left-short" style="font-size: 2.5rem"></i>
                    </a>
                    <h1 class="mx-3">{{ $real_estate->title }}</h1>
                    <div class="rounded-circle {{ $real_estate->availability ? 'bg-success' : 'bg-danger' }}"
                        style="width: 20px; height: 20px;"></div>
                </div>
                <h3>{{ $real_estate->structure_types }}</h3>
                <p>{{ $real_estate->description }}</p>
                <p><strong>Indirizzo:</strong> {{ $real_estate->address }}, {{ $real_estate->city }}</p>
                <p><strong>Prezzo:</strong> €{{ $real_estate->price }}</p>
                <p><strong>Stanze:</strong> {{ $real_estate->rooms }}</p>
                <p><strong>Camere da letto:</strong> {{ $real_estate->beds }}</p>
                <p><strong>Bagni:</strong> {{ $real_estate->bathrooms }}</p>
                <p><strong>Metri quadri:</strong> {{ $real_estate->square_meter }} m²</p>
                <!-- Sezione per i servizi -->
                <h4 class="mt-4">Servizi</h4>
                @if ($real_estate->services->isEmpty())
                    <p>Nessun servizio disponibile per questo immobile.</p>
                @else
                    <ul class="list-unstyled">
                        @foreach ($real_estate->services as $service)
                            <li>{{ $service->name }}</li>
                        @endforeach
                    </ul>
                @endif
                <img src="{{ !empty($real_estate->portrait) ? asset('storage/' . $real_estate->portrait) : 'https://placehold.co/600x400?text=Immagine+non+disponibile' }}"
                    class="card-img-top" alt="{{ $real_estate->title }}">



                {{-- Sezione mappa --}}
                <h4 class="mt-4">Mappa</h4>
                @include('map')
            </div>
        </div>
    </div>
@endsection
