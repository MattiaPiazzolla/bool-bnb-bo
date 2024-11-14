@extends('dashboard')

@section('main-content')
    <div class="container p-3 p-md-5">
        <h1 class="mb-4">Messaggi</h1>
        @if ('messages' > 0)
            <!-- La tabella dei messaggi -->
            <div class="d-flex flex-column">
                @foreach ($messages as $message)
                    <div class="card mb-3">
                        <div class="card-header bg-white">
                            <span>Da: {{ $message->name }} {{ $message->surname }}</span>
                        </div>
                        <div class="card-body d-flex flex-column">
                            <span class="mb-2"><span class="text-secondary">Oggetto: </span>
                                {{ $message->realEstate->title }}
                            </span>
                            <span><span class="text-secondary">Ricevuto il: </span>
                                {{ $message->created_at->toFormattedDateString('it') }}
                                ({{ $message->created_at->format('H:i') }})
                            </span>
                        </div>
                        <div class="card-footer bg-white text-end">
                                <a href="{{ route('admin.messages.show', $message->id) }}" class="btn btn-primary me-2">Visualizza</a>
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal"
                                    data-id="{{ $message->id }}">
                                    Elimina
                                </button>
                        </div>
                    </div>   
                @endforeach
            </div>
            

            <!-- La modale di conferma esterna alla tabella -->
            <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteModalLabel">Conferma eliminazione</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Sei sicuro di voler eliminare questo messaggio? Questa azione non può essere annullata.
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
                            <form id="deleteForm" action="" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Elimina</button>
                            </form>
                        </div>
                    </div>
                </div>
            @else
            <div>
                <span class="text-secondary">Non ci sono ancora messaggi qui..</span>
            </div>
            @endif
        </div>

        <!-- Script per gestire l'aggiornamento del form con l'ID del messaggio -->
        <script>
            // Aggiungi un evento per ciascun pulsante di eliminazione
            const deleteButtons = document.querySelectorAll('[data-bs-toggle="modal"]');
            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const messageId = this.getAttribute('data-id');
                    const deleteForm = document.getElementById('deleteForm');
                    // Imposta l'azione del form per la cancellazione del messaggio
                    deleteForm.action = '/admin/messages/' + messageId; // Modifica l'URL con l'ID del messaggio
                });
            });
        </script>
    </div>
@endsection
