@extends('dashboard')
@section('main-content')
    <div class="container p-5">
        @foreach ($real_estates as $real_estate)
            <div class="card">
                <h3 class="card-header bg-dark text-white text-uppercase">{{ $real_estate->structure_types }}</h3>
                <div class="card-body row">
                    <div class="col-6">
                        <h5 class="card-title">{{ $real_estate->title }}</h5>
                        <p class="card-text">{{ $real_estate->description }}</p>
                        <p class="card-text">{{ $real_estate->address }}, {{ $real_estate->city }}</p>
                        <p class="card-text">{{ $real_estate->price }}€</p>
                        <div class="d-flex">
                            <p class="card-text me-3">Disponibilita:
                            </p>
                            <div class="rounded-circle {{ $real_estate->avilability ? 'bg-success' : 'bg-danger' }}"
                                style="width: 20px; height: 20px;"></div>

                        </div>
                        <a href="#" class="btn btn-primary">Go somewhere</a>
                    </div>
                    <div class="col-6">
                        <img src="{{ !empty($real_estate->portrait) ? $real_estate->portrait : 'https://placehold.co/600x400?text=Copertina' }}"
                            class="card-img-top" alt="Immobile">
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
