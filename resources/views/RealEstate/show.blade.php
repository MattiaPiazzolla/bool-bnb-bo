@extends('dashboard')

@section('main-content')
    <div class="bg-light">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 d-flex justify-content-between align-items-center">
                    <div class="back-bt">
                        <a href="{{ route('admin.RealEstates.index') }}" class="d-flex align-items-center">
                            <i class="bi bi-arrow-left-short" style="font-size: 2.5rem"></i>
                            <span class="text-primary mt-3" style="font-size: 14pt">Indietro</span>
                        </a>
                    </div>
                    <a href="{{ route('admin.RealEstates.edit', $real_estate->id) }}" style="text-decoration: none">
                        <span class="text-primary mt-3 me-2" style="font-size: 14pt">modifica </span>
                        <i class="bi bi-pencil-fill text-primary me-2"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="container p-md-5">
            <div class="row bg-white">
                <div class="col-sm-12 col-lg-7 p-3">
                    <div class="d-flex align-items-center">
                        <h1 class="me-3">{{ $real_estate->title }}</h1>
                        <div class="rounded-circle {{ $real_estate->availability ? 'bg-success' : 'bg-danger' }}"
                            style="width: 20px; height: 20px;">
                        </div>
                    </div>
                    <span class="text-uppercase">{{ $real_estate->structure_types }}</span>
                    <p class="mt-1">{{ $real_estate->description }}</p>
                </div>
                <div class="col-sm-12 col-lg-5 img-head d-flex p-3">
                    <img src="{{ !empty($real_estate->portrait) ? asset('storage/' . $real_estate->portrait) : 'https://placehold.co/600x400?text=Immagine+non+disponibile' }}"
                        alt="{{ $real_estate->title }}">
                </div>
            </div>

            <div class="row bg-white mt-5 py-3">
                <div class="col-sm-12 col-lg-6 d-flex flex-column">
                    <span class="text-black"><strong>Indirizzo:</strong> {{ $real_estate->address }},
                        {{ $real_estate->city }}</span>
                    <span class="text-black"><strong>Prezzo:</strong> € {{ $real_estate->price }}</span>
                    <span class="text-black"><strong>Stanze:</strong> {{ $real_estate->rooms }}</span>
                    <span class="text-black"><strong>Camere da letto:</strong> {{ $real_estate->beds }}</span>
                    <span class="text-black"><strong>Bagni:</strong> {{ $real_estate->bathrooms }}</span>
                    <span class="text-black"><strong>Metri quadri:</strong> {{ $real_estate->square_meter }} m²</span>

                    <!-- Sezione per i servizi -->
                    <h4 class="mt-3">Servizi</h4>
                    @if ($real_estate->services->isEmpty())
                        <p>Nessun servizio disponibile per questo immobile.</p>
                    @else
                        <ul class="list-unstyled">
                            @foreach ($real_estate->services as $service)
                                <li>{{ $service->name }}</li>
                            @endforeach
                        </ul>
                    @endif

                    <!-- Data di fine sponsorizzazione -->
                    @if ($endSubscription)
                        <h5 class="mt-4">Sponsorizzazione attiva fino a:</h5>
                        <p>{{ \Carbon\Carbon::parse($endSubscription)->format('d-m-Y') }}</p>
                    @else
                        <p>Questo immobile non è sponsorizzato al momento.</p>
                    @endif
                </div>

                <div class="col-sm-12 col-lg-6">
                    {{-- Sezione mappa --}}
                    @include('map')
                </div>
            </div>
        </div>
    </div>
@endsection
