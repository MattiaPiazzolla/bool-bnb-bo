@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Login') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('login') }}" id="loginForm">
                            @csrf

                            <div class="mb-4 row">
                                <label for="email"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Indirizzo e-mail') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" required autocomplete="email" autofocus>
                                    <small id="emailError" class="invalid-feedback"></small>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-4 row">
                                <label for="password"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                                <div class="col-md-6">
                                    <div class="passwd-wrap">
                                        <input id="password" type="password"
                                            class="form-control @error('password') is-invalid @enderror" name="password"
                                            required autocomplete="current-password">
                                        <button type="button" id="showPassword" class="btn">
                                            <i class="bi-eye"></i>
                                        </button>
                                    </div>
                                    <small id="passwordError" class="invalid-feedback"></small>
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-4 row">
                                <div class="col-md-6 offset-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                            {{ old('remember') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="remember">
                                            {{ __('Ricordati di me') }}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4 row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Accedi') }}
                                    </button>

                                    @if (Route::has('password.request'))
                                        <a class="btn btn-link" href="{{ route('password.request') }}">
                                            {{ __('Password dimenticata?') }}
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Aggiunta del JavaScript per la validazione lato client -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('loginForm');
            const email = document.getElementById('email');
            const password = document.getElementById('password');
            const emailError = document.getElementById('emailError');
            const passwordError = document.getElementById('passwordError');

            // Funzione per aggiungere o rimuovere la classe di errore
            function toggleError(input, errorElement, isError, message) {
                if (isError) {
                    input.classList.add('is-invalid');
                    input.classList.remove('is-valid');
                    errorElement.textContent = message;
                } else {
                    input.classList.remove('is-invalid');
                    input.classList.add('is-valid');
                    errorElement.textContent = ''; // Rimuove il messaggio di errore
                }
            }

            // Validazione per email
            email.addEventListener('blur', function() {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                const isValid = emailRegex.test(email.value);
                if (!isValid) {
                    toggleError(email, emailError, true, 'Per favore inserisci una email valida.');
                } else {
                    toggleError(email, emailError, false, '');
                }
            });

            // Validazione per password
            password.addEventListener('blur', function() {
                const isValid = password.value.length >= 8;
                if (!isValid) {
                    toggleError(password, passwordError, true,
                        'La password deve essere lunga almeno 8 caratteri.');
                } else {
                    toggleError(password, passwordError, false, '');
                }
            });

            // Validazione in tempo reale al cambiamento del valore del campo
            email.addEventListener('input', function() {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                const isValid = emailRegex.test(email.value);
                if (!isValid) {
                    toggleError(email, emailError, true, 'Per favore inserisci una email valida.');
                } else {
                    toggleError(email, emailError, false, '');
                }
            });

            password.addEventListener('input', function() {
                const isValid = password.value.length >= 8;
                if (!isValid) {
                    toggleError(password, passwordError, true,
                        'La password deve essere lunga almeno 8 caratteri.');
                } else {
                    toggleError(password, passwordError, false, '');
                }
            });

            // Validazione al submit del form
            form.addEventListener('submit', function(event) {
                let valid = true;

                // Verifica per la validità della email
                const emailValid = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value);
                if (!emailValid) {
                    toggleError(email, emailError, true, 'Per favore inserisci una email valida.');
                    valid = false;
                }

                // Verifica per la validità della password
                const passwordValid = password.value.length >= 8;
                if (!passwordValid) {
                    toggleError(password, passwordError, true,
                        'La password deve essere lunga almeno 8 caratteri.');
                    valid = false;
                }

                // Se il form non è valido, previeni il submit
                if (!valid) {
                    event.preventDefault();
                }
            });
        });
    </script>

    <!-- Aggiunta del CSS per la gestione dei bordi e dei messaggi -->
    <style>
        .is-invalid {
            border-color: red;
        }

        .is-valid {
            border-color: green;
        }

        .invalid-feedback {
            color: red;
            font-size: 0.875em;
        }
    </style>
@endsection
