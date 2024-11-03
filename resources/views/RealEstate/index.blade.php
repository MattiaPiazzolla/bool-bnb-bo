@extends('dashboard')
@section('main-content')
    <div class="container p-5">
        <a href="{{ route('admin.RealEstates.create') }}" class="btn btn-warning">Aggiungi immobile</a>
        @foreach ($real_estates as $real_estate)
            <div class="card my-4">
                <div class="card-header d-flex justify-content-between align-items-center bg-dark text-white text-uppercase">
                    <h3 class="m-0">{{ $real_estate->structure_types }}</h3>
                    <div class="rounded-circle {{ $real_estate->availability ? 'bg-success' : 'bg-danger' }}"
                        style="width: 20px; height: 20px;"></div>
                </div>
                <div class="card-body row">
                    <div class="col-6">
                        <h5 class="card-title">{{ $real_estate->title }}</h5>
                        <p class="card-text">{{ $real_estate->description }}</p>
                        <p class="card-text">{{ $real_estate->address }}, {{ $real_estate->city }}</p>
                        <p class="card-text">{{ $real_estate->price }}€</p>
                        <p class="card-text">L'immobile è
                            {{ $real_estate->availability == true ? 'disponibile' : 'occupato' }}</p>
                        <div class="buttons-cards d-flex justify-content-around">
                            <a href="{{ route('admin.RealEstates.show', $real_estate->id) }}"
                                class="btn btn-primary">Dettagli</a>
                            <a href="{{ route('admin.RealEstates.edit', $real_estate->id) }}"
                                class="btn btn-warning">Modifica</a>

                            <button type="button" class="btn btn-danger delete-real-estate"
                                data-url="/admin/RealEstates/{{ $real_estate->id }}">
                                Elimina
                            </button>
                        </div>
                    </div>
                    <div class="col-6">
                        <img src="{{ !empty($real_estate->portrait) ? asset('storage/' . $real_estate->portrait) : 'https://placehold.co/600x400?text=Immagine+non+disponibile' }}"
                            class="card-img-top" style="aspect-ratio: 1/1 ; object-fit: cover"
                            alt="{{ $real_estate->title }}">
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    @include('RealEstate.partials.modal_real_estates')
@endsection
