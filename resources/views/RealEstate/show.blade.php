@extends('dashboard')
@section('main-content')
    <div class="container">
        <div class="row">
            <div class="col-12 p-5">
                <div class="d-flex align-items-center">
                    <a href="{{ route('admin.RealEstates.index') }}"><i class="bi bi-arrow-left-short"
                            style="font-size: 2.5rem"></i></a>
                    <h1 class="mx-3">{{ $real_estate->title }}</h1>
                    <div class="rounded-circle {{ $real_estate->avilability ? 'bg-success' : 'bg-danger' }}"
                        style="width: 20px; height: 20px;"></div>
                </div>
                <h3>{{ $real_estate->structure_types }}</h3>
                <p>{{ $real_estate->description }}</p>
                <p><strong>Indirizzo:</strong> {{ $real_estate->address }}, {{ $real_estate->city }}</p>
                <p><strong>Prezzo:</strong> €{{ $real_estate->price }}</p>
                <p><strong>Stanze:</strong> {{ $real_estate->rooms }}</p>
                <p><strong>Bedrooms:</strong> {{ $real_estate->beds }}</p>
                <p><strong>Bagni:</strong> {{ $real_estate->bathrooms }}</p>
                <p><strong>Metri quadri:</strong> {{ $real_estate->square_meter }} m²</p>
                <img src="{{ !empty($real_estate->portrait) ? $real_estate->portrait : 'https://placehold.co/600x400?text=Immagine+non+disponibile' }}"
                    class="card-img-top" alt="Immobile">
            </div>
        </div>
    </div>
@endsection
