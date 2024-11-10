@extends('dashboard')

@section('main-content')
    <div class="container">
        <h1>Sponsorizza un immobile con il piano: {{ $subscription->name }}</h1>

        <!-- Mostra le informazioni sulla sponsorizzazione -->
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ $subscription->name }}</h5>
                <p class="card-text">Durata: {{ $subscription->duration }} ore</p>
                <p class="card-text">Prezzo: €{{ $subscription->price }}</p>
            </div>
        </div>

        <hr>

        <h3>Seleziona un immobile da sponsorizzare</h3>

        <form action="{{ route('admin.subscriptions.store') }}" method="POST">
            @csrf
            <input type="hidden" name="subscription_id" value="{{ $subscription->id }}">

            <div class="row">
                @foreach ($real_estates as $real_estate)
                    <div class="col-md-4 mb-3">
                        <div class="card">
                            <img src="{{ !empty($real_estate->portrait) ? asset('storage/' . $real_estate->portrait) : 'https://placehold.co/600x400?text=Immagine+non+disponibile' }}"
                                class="card-img-top" alt="Immobile">
                            <div class="card-body">
                                <h5 class="card-title">{{ $real_estate->title }}</h5>
                                <p class="card-text">{{ $real_estate->description }}</p>
                                <a href="{{ route('admin.subscriptions.braintree') }}" class="btn btn-warning">
                                    Sponsorizza
                                </a>
                                <a href="{{ route('admin.subscriptions.braintree') }}">ciao</a>

                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </form>
    </div>
@endsection
