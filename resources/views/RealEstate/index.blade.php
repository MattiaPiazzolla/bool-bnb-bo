@extends('dashboard')
@section('main-content')
    <div class="container p-5">
        <a href="{{ route('admin.RealEstates.create') }}" class="btn btn-primary">Aggiungi immobile</a>
        @foreach ($real_estates as $real_estate)
            <!-- Controlla se l'immobile ha almeno una sottoscrizione attiva -->
            @php
                $isSponsored = $real_estate->subscriptions->isNotEmpty();
            @endphp

            <div class="card my-4 {{ $isSponsored ? 'border-warning border-5' : '' }}">
                <div
                    class="card-header d-flex justify-content-between align-items-center bg-dark text-white text-uppercase position-relative">
                    <h5 class="m-0">{{ $real_estate->structure_types }}</h5>
                    <div class="rounded-circle {{ $real_estate->availability ? 'bg-success' : 'bg-danger' }}"
                        style="width: 20px; height: 20px;"></div>
                </div>
                <div class="card-body row d-flex">
                    <div class="col-12 d-flex position-relative">
                        <div class="img-box">
                            <img src="{{ !empty($real_estate->portrait) ? asset('storage/' . $real_estate->portrait) : 'https://placehold.co/600x400?text=Immagine+non+disponibile' }}"
                                class="card-img-top" style="aspect-ratio: 1/1" alt="{{ $real_estate->title }}">
                        </div>
                        <h5
                            class="position-absolute top-0 end-0 bg-warning p-2 text-white rounded {{ $isSponsored ? 'd-block' : 'd-none' }}">
                            Sponsorizzato</h5>
                        <div class="d-flex flex-column info-cont mx-4">
                            <h4 class="card-title">{{ $real_estate->title }}</h4>
                            <p class="card-text">{{ $real_estate->description }}</p>
                            <p class="card-text">{{ $real_estate->address }}, {{ $real_estate->city }}</p>
                            <p class="card-text">{{ $real_estate->price }}€</p>
                            <p class="card-text">L'immobile è
                                {{ $real_estate->availability == true ? 'disponibile' : 'occupato' }}</p>
                            <a href="{{ route('admin.RealEstates.show', $real_estate->id) }}"
                                class="btn btn-primary me-5 details">Visualizza</a>
                        </div>
                        <div class="buttons-cards d-flex mt-5">
                            <a href="{{ route('admin.RealEstates.edit', $real_estate->id) }}"
                                class="me-1 btn btn-primary"><i class="bi bi-pencil-fill"></i></a>
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
