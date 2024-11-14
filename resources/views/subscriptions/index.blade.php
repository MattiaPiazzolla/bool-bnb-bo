@extends('dashboard')

@section('main-content')
    <div class="container p-3 p-md-5">
        <h1 class="mb-2">Seleziona la sponsorizzazione che fa per te</h1>

        {{-- Sezione di promozione generale --}}
        <div class="">
            <h4 class="mb-2">Fai brillare il tuo immobile!</h4>
            <p>Le nostre sponsorizzazioni aumentano la visibilità del tuo immobile, facendolo emergere tra le offerte.</p>
            <p>Scegli un pacchetto che si adatta alle tue esigenze e fai crescere i contatti in modo rapido ed efficace!</p>
        </div>

        <div class="row g-5">
            @foreach ($subscriptions as $subscription)
                <div class="col-md-6 col-xl-4 mb-md-3">
                    <div class="card">
                        <div class="card-body d-flex flex-column justify-content-between">
                            <h4 class="card-title text-center mt-3 fw-bold">{{ $subscription->name }}</h4>
                            <h1 class="card-title text-center text_price_subscription">&euro;{{ $subscription->price }}</h1>
                            <div class="benefits_list">
                                <hr>
                                <ul>
                                    <li><i class="fas fa-clock"></i>{{ $subscription->duration }} Ore</li>
                                    <li><i class="fas fa-arrow-up"></i> In cima ai risultati</li>
                                    <li><i class="fas fa-eye"></i> Maggiore visibilità</li>
                                    <li><i class="fas fa-clock"></i> Durata estesa</li>
                                    <li><i class="fas fa-phone-alt"></i> Più contatti</li>
                                    <li><i class="fas fa-bullseye"></i> Target mirato</li>
                                </ul>
                            </div>
                        </div>
                        <a href="{{ route('admin.subscriptions.show', $subscription->id) }}"
                            class="btn btn-primary">Sponsorizza</a>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Elenco delle sottoscrizioni
        <div class="row g-5">
            @foreach ($subscriptions as $subscription)
                <div class="col-md-4 mb-md-3">
                    <div class="card">
                        <div class="card-body d-flex flex-column justify-content-between">
                            <h4 class="card-title text-center mt-3 fw-bold">{{ $subscription->name }}</h4>
                            <h1 class="card-title text-center text_price_subscription">&euro;{{ $subscription->price }}</h1>
                            <div class="benefits_list">
                                <hr>
                                <ul>
                                    <li><i class="fas fa-clock"></i>{{ $subscription->duration }} Ore</li>
                                    <li><i class="fas fa-arrow-up"></i> In cima ai risultati</li>
                                    <li><i class="fas fa-eye"></i> Maggiore visibilità</li>
                                    <li><i class="fas fa-clock"></i> Durata estesa</li>
                                    <li><i class="fas fa-phone-alt"></i> Più contatti</li>
                                    <li><i class="fas fa-bullseye"></i> Target mirato</li>
                                </ul>
                            </div>
                        </div>
                        <a href="{{ route('admin.subscriptions.show', $subscription->id) }}"
                            class="btn btn-primary">Sponsorizza</a>
                    </div>
                </div>
            @endforeach
        </div> --}}
    </div>

    <style>
        .card {
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
            min-height: 350px;
            padding: 10%;
        }

        .text_price_subscription {
            font-weight: 300
        }

        .benefits_list ul {
            list-style-type: none;
        }

        .benefits_list ul li {
            margin: 5px 0;
        }

        .benefits_list ul li i {
            margin-right: 10px;
        }
    </style>
@endsection
