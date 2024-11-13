@extends('dashboard')

@section('main-content')
    <div class="container py-5 p-md-5">

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <a href="{{ route('admin.RealEstates.create') }}" class="btn btn-primary">Aggiungi immobile</a>
        @foreach ($real_estates as $real_estate)
            <!-- Controlla se l'immobile ha almeno una sottoscrizione attiva -->
            @php
                // Verifica se l'immobile ha almeno una sottoscrizione
$isSponsored = $real_estate->subscriptions->isNotEmpty();

// Imposta la data di fine della sponsorizzazione se esiste
$endSubscription = null;
if ($isSponsored) {
    // Assumiamo che l'immobile possa avere più sponsorizzazioni, quindi prendo la prima
                    $endSubscription = $real_estate->subscriptions->first()->pivot->end_subscription;
                }
            @endphp

            <div class="card my-4 {{ $isSponsored ? 'border-warning border-5' : '' }}">
                <div class="card-header d-flex align-items-center bg-white position-relative">
                    <div class="d-flex flex-column flex-md-row align-items-md-center">
                        <h5 class="m-0 me-4 text-uppercase">{{ $real_estate->structure_types }}</h5>
                        <span class="card-text text-success me-2">L'immobile è
                            {{ $real_estate->availability == true ? 'disponibile' : 'occupato' }}</span>
                        <div class="d-none d-md-block rounded-circle {{ $real_estate->availability ? 'bg-success' : 'bg-danger' }}"
                            style="width: 20px; height: 20px;"></div>
                    </div>
                    <span
                        class="position-absolute top-0 end-0 text-warning p-2 rounded me-2 {{ $isSponsored ? 'd-block' : 'd-none' }}">
                        Sponsorizzato</span>
                </div>
                <div class="card-body row d-flex">
                    <div class="col-12 d-flex position-relative flex-column flex-md-row">
                        <div class="img-box">
                            <img src="{{ !empty($real_estate->portrait) ? asset('storage/' . $real_estate->portrait) : 'https://placehold.co/600x400?text=Immagine+non+disponibile' }}"
                                class="card-img" style="aspect-ratio: 1/1" alt="{{ $real_estate->title }}">
                        </div>
                        <div class="d-flex flex-column info-cont mx-md-4 mt-3 mt-md-0">
                            <h4 class="card-title">{{ $real_estate->title }}</h4>
                            <span class="card-text">{{ $real_estate->address }}, {{ $real_estate->city }}</span>
                            <span class="card-text mb-1">€ {{ $real_estate->price }}</span>

                            <!-- Mostra la data di fine sponsorizzazione, se presente -->
                            @if ($isSponsored && $endSubscription)
                                <span class="card-text mt-2 text-muted">
                                    La sponsorizzazione termina il
                                    {{ \Carbon\Carbon::parse($endSubscription)->format('d-m-Y') }}
                                </span>
                            @endif
                        </div>
                        <div class="buttons-cards d-flex mt-4 mt-md-5">
                            <a href="{{ route('admin.RealEstates.show', $real_estate->id) }}"
                                class="btn btn-primary details me-5 me-md-1">Visualizza</a>
                            <a href="{{ route('admin.RealEstates.edit', $real_estate->id) }}"
                                class="me-1 btn btn-primary me-2 me-md-3"><i class="bi bi-pencil-fill"></i></a>
                            <button type="button" class="btn btn-danger delete-real-estate"
                                data-url="/admin/RealEstates/{{ $real_estate->id }}">
                                <i class="bi bi-trash3-fill"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    @include('RealEstate.partials.modal_real_estates')
@endsection
