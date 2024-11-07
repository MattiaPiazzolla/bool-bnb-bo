<section>
    <header>
        <h2 class="text-secondary">
            {{ __('Aggiorna immagine del profilo') }}
        </h2>

        <p class="mt-1 text-muted">
            {{ __('Carica una nuova immagine per il tuo profilo.') }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.updatePicture') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <!-- Anteprima dell'immagine attuale -->
        <div class="mb-2">
            <label for="current-image" class="form-label">{{ __('Immagine attuale') }}</label>
            <div id="current-image" class="mb-3">
                @if (Auth::user()->image)
                    <img src="{{ asset('storage/' . Auth::user()->image) }}" alt="Immagine del profilo attuale"
                        class="img-thumbnail" width="150">
                @else
                    <p>{{ __('Nessuna immagine del profilo') }}</p>
                @endif
            </div>
        </div>

        <!-- Input file per selezionare una nuova immagine -->
        <div class="mb-2">
            <label for="image" class="form-label">{{ __('Immagine del profilo') }}</label>
            <input type="file" name="image" id="image" class="form-control" accept="image/*" required>

            @error('image')
                <span class="alert alert-danger mt-2" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="d-flex align-items-center gap-4">
            <button type="submit" class="btn btn-primary">{{ __('Aggiorna Immagine') }}</button>
        </div>
    </form>
</section>

<script>
    // Funzione per mostrare l'anteprima dell'immagine selezionata
    document.getElementById('image').addEventListener('change', function(event) {
        const file = event.target.files[0];
        const preview = document.getElementById('preview-image');

        if (file) {
            const reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block'; // Mostra l'anteprima
            };

            reader.readAsDataURL(file);
        }
    });
</script>
