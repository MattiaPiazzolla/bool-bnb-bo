@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Registrati') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}" id="registerForm">
                            @csrf

                            <!-- Nome -->
                            <div class="mb-4 row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Nome') }}
                                    *</label>
                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" name="name"
                                        value="{{ old('name') }}" required autocomplete="name" autofocus>
                                    <small id="nameError" class="invalid-feedback"></small>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Cognome -->
                            <div class="mb-4 row">
                                <label for="surname" class="col-md-4 col-form-label text-md-right">{{ __('Cognome') }}
                                    *</label>
                                <div class="col-md-6">
                                    <input id="surname" type="text" class="form-control" name="surname"
                                        value="{{ old('surname') }}" required autocomplete="surname" autofocus>
                                    <small id="surnameError" class="invalid-feedback"></small>
                                    @error('surname')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Data di nascita -->
                            <div class="mb-4 row">
                                <label for="date_of_birth"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Data di nascita') }} *</label>
                                <div class="col-md-6">
                                    <input id="date_of_birth" type="date" class="form-control" name="date_of_birth"
                                        value="{{ old('date_of_birth') }}" required autocomplete="date_of_birth">
                                    <div id="dobError" class="text-danger"></div>
                                </div>
                            </div>

                            <!-- Immagine Profilo -->
                            <div class="mb-4 row">
                                <label for="image"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Immagine Profilo') }}</label>
                                <div class="col-md-6">
                                    <input id="image" type="file" class="form-control" name="image"
                                        value="{{ old('image') }}" autocomplete="image">
                                    @error('image')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="mb-4 row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('e-mail') }}
                                    *</label>
                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" name="email"
                                        value="{{ old('email') }}" required autocomplete="email">
                                    <small id="emailError" class="invalid-feedback"></small>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Password -->
                            <div class="mb-4 row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}
                                    *</label>
                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" name="password" required
                                        autocomplete="new-password">
                                    <small id="passwordError" class="invalid-feedback"></small>
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Conferma Password -->
                            <div class="mb-4 row">
                                <label for="password-confirm"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Conferma Password') }} *</label>
                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control"
                                        name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>

                            <div class="mb-4 row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">{{ __('Registrati') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('registerForm');
            const name = document.getElementById('name');
            const surname = document.getElementById('surname');
            const dateOfBirth = document.getElementById('date_of_birth');
            const email = document.getElementById('email');
            const password = document.getElementById('password');
            const passwordConfirm = document.getElementById('password-confirm');
            const nameError = document.getElementById('nameError');
            const surnameError = document.getElementById('surnameError');
            const dobError = document.getElementById('dobError');
            const emailError = document.getElementById('emailError');
            const passwordError = document.getElementById('passwordError');

            // Funzione per validazione dinamica
            function toggleError(input, errorElement, isError, message) {
                if (isError) {
                    input.classList.add('is-invalid');
                    input.classList.remove('is-valid');
                    errorElement.textContent = message;
                } else {
                    input.classList.remove('is-invalid');
                    input.classList.add('is-valid');
                    errorElement.textContent = '';
                }
            }

            // Funzione per calcolare l'età
            function calculateAge(dob) {
                const today = new Date();
                const birthDate = new Date(dob);
                let age = today.getFullYear() - birthDate.getFullYear();
                const month = today.getMonth();
                const day = today.getDate();
                if (month < birthDate.getMonth() || (month === birthDate.getMonth() && day < birthDate.getDate())) {
                    age--;
                }
                return age;
            }

            // Funzione per la validazione dell'età
            function validateAge(dateOfBirth) {
                const age = calculateAge(dateOfBirth);
                return age >= 18;
            }

            // Validazione nome
            name.addEventListener('input', function() {
                const isValid = name.value.length >= 2;
                if (!isValid) {
                    toggleError(name, nameError, true, 'Il nome deve avere almeno 2 caratteri.');
                } else {
                    toggleError(name, nameError, false, '');
                }
            });

            // Validazione cognome
            surname.addEventListener('input', function() {
                const isValid = surname.value.length >= 2;
                if (!isValid) {
                    toggleError(surname, surnameError, true, 'Il cognome deve avere almeno 2 caratteri.');
                } else {
                    toggleError(surname, surnameError, false, '');
                }
            });

            // Validazione data di nascita
            dateOfBirth.addEventListener('blur', function() {
                if (!validateAge(dateOfBirth.value)) {
                    dobError.textContent = "Devi essere maggiorenne per registrarti.";
                    dateOfBirth.style.borderColor = "red";
                } else {
                    dobError.textContent = "";
                    dateOfBirth.style.borderColor = "green";
                }
            });

            // Validazione email
            email.addEventListener('input', function() {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                const isValid = emailRegex.test(email.value);
                if (!isValid) {
                    toggleError(email, emailError, true, 'Per favore inserisci una email valida.');
                } else {
                    toggleError(email, emailError, false, '');
                }
            });

            // Validazione password
            password.addEventListener('input', function() {
                const isValid = password.value.length >= 6;
                if (!isValid) {
                    toggleError(password, passwordError, true,
                        'La password deve essere lunga almeno 6 caratteri.');
                } else {
                    toggleError(password, passwordError, false, '');
                }
            });

            // Validazione conferma password
            passwordConfirm.addEventListener('input', function() {
                const isValid = password.value === passwordConfirm.value;
                if (!isValid) {
                    toggleError(passwordConfirm, passwordError, true, 'Le password non corrispondono.');
                } else {
                    toggleError(passwordConfirm, passwordError, false, '');
                }
            });

            // Validazione del form alla sottomissione
            form.addEventListener('submit', function(event) {
                let valid = true;

                if (name.value.length < 2) {
                    toggleError(name, nameError, true, 'Il nome deve avere almeno 2 caratteri.');
                    valid = false;
                }

                if (surname.value.length < 2) {
                    toggleError(surname, surnameError, true, 'Il cognome deve avere almeno 2 caratteri.');
                    valid = false;
                }

                if (!validateAge(dateOfBirth.value)) {
                    toggleError(dateOfBirth, dobError, true, 'Devi essere maggiorenne per registrarti.');
                    valid = false;
                }

                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(email.value)) {
                    toggleError(email, emailError, true, 'Per favore inserisci una email valida.');
                    valid = false;
                }

                if (password.value.length < 6) {
                    toggleError(password, passwordError, true,
                        'La password deve essere lunga almeno 6 caratteri.');
                    valid = false;
                }

                if (password.value !== passwordConfirm.value) {
                    toggleError(passwordConfirm, passwordError, true, 'Le password non corrispondono.');
                    valid = false;
                }

                if (!valid) {
                    event.preventDefault(); // Blocca l'invio se ci sono errori
                }
            });
        });
    </script>
@endsection
