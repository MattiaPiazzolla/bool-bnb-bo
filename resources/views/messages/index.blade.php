@extends('dashboard')

@section('main-content')
    <div class="container mt-5">
        <h1>Gestione Messaggi</h1>
        <!-- La tabella dei messaggi -->
        <table class="table">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Cognome</th>
                    <th>Email</th>
                    <th>Telefono</th>
                    <th>Messaggio</th>
                    <th>Azioni</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($messages as $message)
                    <tr>
                        <td>{{ $message->name }}</td>
                        <td>{{ $message->surname }}</td>
                        <td>{{ $message->email }}</td>
                        <td>{{ $message->phone }}</td>
                        <td>{{ $message->message }}</td>
                        <td>
                            <a href="{{ route('admin.messages.show', $message->id) }}" class="btn btn-primary"><i
                                    class="bi bi-eye"></i></a>
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal"
                                data-id="{{ $message->id }}">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">Nessun messaggio trovato</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

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
