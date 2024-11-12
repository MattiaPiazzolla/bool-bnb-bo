@extends('layouts.app')
@section('content')
<div class="container">
        <div class="row">
            <div class="col-12 py-5 p-md-5">
                <div class="bg-wow p-5 lineUp2">
                    <h1 class="title text-white lineUp">Benvenuto <br>
                    nel back-office di <br>
                Bool-b&b</h1>
                <span class="text-white lineUp2">Se hai bisogno di pubblicare un annuncio per affittare il tuo appartamento, sei nel posto giusto!</span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 px-5">
                    <div class="line">
                        <h2 class="mb-5 text-center lineUp">
                            Mettiti in contatto con migliaia di possibili clienti!
                        </h2> 
                    </div>

                    <div class="d-flex flex-column mb-5 align-items-center justify-content-center">
                        <h3 class="mb-3">Entra a far parte di Boolb&b</h3>
                        @guest
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}">
                                    <button class="btn-wow mb-3">Registrati</button>
                                </a>
                            @endif
                        @else
                            <a href="{{ route('admin.RealEstates.create') }}">
                                <button class="btn-wow mb-3">Pubblica un annuncio</button>
                            </a>
                        @endguest
                    </div>

                    <div class="bg-wow2 p-5">
                    <h1 class="title rainbow mb-3">Semplice</h1>
                    <h1 class="title mb-3 text-white text-center">Affidabile</h1>
                    <h1 class="title rainbow2 mb-3 text-end">Veloce</h1>
                </div>
                <h1 class="title m-5">
                    Tutto quello che ti serve, <br> a portata di mano.
                </h1>
            </div>
        </div>
        
        <div class="row d-flex justify-content-center my-4">
            <div class="col-12 col-md-8 px-5">
            <div class="accordion accordion-flush" id="accordionFlushExample">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                        <span class="accordion-title me-5">Le basi dell'ospitalità</span>
                    </button>
                    </h2>
                    <div id="flush-collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                    <div class="accordion-body"><span style="font-size: 1.3rem;">
                    <strong>Da dove inizio?</strong><br>
                    Puoi creare un annuncio in pochi passaggi, quando vuoi. Parti dalla descrizione dell'alloggio, scatta qualche foto e aggiungi alcuni dettagli su ciò che lo rende unico.<br>
                    <br>
                    <strong>Come faccio a preparare il mio spazio per gli ospiti?</strong><br>
                    Assicurati che l'alloggio sia pulito e ordinato, e controlla che tutto funzioni correttamente. Inoltre, per rendere gli ambienti confortevoli e invitanti, verifica che la biancheria sia pulita e rifornisci il bagno di articoli essenziali. <br>
                    <br>
                    <strong>Che tutele ho quando ospito?</strong><br>
                    BoolCover per gli host offre una protezione completa ogni volta che affitti il tuo alloggio su Boolb&b.<br>
                    <br>
                    <strong>Qualche consiglio su come ospitare al meglio?</strong><br>
                    Per eccellere come host basta poco: potresti ad esempio fornire un elenco delle tue mete locali preferite e rispondere ai messaggi degli ospiti in modo tempestivo. 
                    </span></div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                    <span class="accordion-title me-5">Regole e leggi</span>
                    </button>
                    </h2>
                    <div id="flush-collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                    <div class="accordion-body"><span style="font-size: 1.3rem">
                    <strong>Esistono normative che si applicano nella mia città?</strong><br>
                    In alcune zone vi sono leggi e norme che regolano l'affitto degli alloggi. È importante che familiarizzi con quelle in vigore nella tua area geografica. Inoltre, a seconda di dove vivi, potresti dover contattare l'associazione di proprietari di alloggi per ottenere un nullaosta, leggere il tuo contratto di locazione o informare il tuo padrone di casa o i vicini in merito ai tuoi programmi come host su Boolb&b. <br>
                    <br>
                    <strong>E se avessi altre domande?</strong><br> 
                    Gli host del luogo sono un'ottima fonte di informazioni e approfondimenti. Possiamo metterti in contatto con una persona della tua zona che affitta da tempo il suo alloggio su Boolb&b, in modo che risponda a tutte le tue domande aggiuntive. Rivolgiti a un host.
                    </span></div>
                    </div>
                </div>
                <div class="accordion-item mb-5">
                    <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
                    <span class="accordion-title me-5">Co-host</span>
                    </button>
                    </h2>
                    <div id="flush-collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                    <div class="accordion-body">
                    <span style="font-size: 1.3rem">
                    <strong>In che modo possono aiutarti i co-host?</strong><br>
                    Puoi affidarti a un co-host per occuparsi di un aspetto dell'attività oppure di tutto quanto. Non tutti i co-host offrono gli stessi servizi, ma in generale possono aiutarti a configurare il tuo annuncio Boolb&b, a preparare l'alloggio, a gestire prenotazioni e messaggi, a pulire, a fare la manutenzione e a rispondere alle richieste in loco degli ospiti. <br>
                    <br>
                   <strong>Posso trovare un co‑host su Boolb&b?</strong> <br>
                   Boolb&b ti aiuta a trovare e ingaggiare facilmente un co-host con esperienza nella tua zona tramite la sua app. Fai le tue ricerche, invia messaggi ai co-host e scegli la persona più adatta alle tue esigenze. Scopri di più sulla Rete di co-host. <br>
                    <br>
                    <strong>Come pago il co-host?</strong><br>
                    Tu e il co-host dovrete concordare i termini di pagamento prima di iniziare la collaborazione. Hai la possibilità di condividere una parte del compenso di ogni prenotazione con questa persona direttamente tramite Boolb&b. Potrebbero essere applicate alcune limitazioni, a seconda della tua posizione, nonché di quella dell'alloggio e del co-host. Scopri come funzionano i compensi dei co-host.</span>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        
    </script>
@endsection

