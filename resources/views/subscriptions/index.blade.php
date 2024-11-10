@extends('dashboard')

@section('main-content')
    <div class="container">
        <h1>Elenco delle Sponsorizzazioni</h1>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="row">
            @foreach ($subscriptions as $subscription)
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $subscription->name }}</h5>
                            <p class="card-text">Durata: {{ $subscription->duration }} ore</p>
                            <p class="card-text">Prezzo: €{{ $subscription->price }}</p>
                            <a href="{{ route('admin.subscriptions.show', $subscription->id) }}"
                                class="btn btn-primary">Dettagli Sponsorizzazione</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
