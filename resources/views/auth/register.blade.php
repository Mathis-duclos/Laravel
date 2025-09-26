<x-guest-layout>
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">

    <div class="auth-box">
        <h1 class="auth-title">Inscription</h1>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div class="form-group">
                <x-input-label for="name" :value="__('Nom')" />
                <x-text-input id="name" class="auth-input"
                              type="text" name="name"
                              :value="old('name')" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Email -->
            <div class="form-group mt-4">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="auth-input"
                              type="email" name="email"
                              :value="old('email')" required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="form-group mt-4">
                <x-input-label for="password" :value="__('Mot de passe')" />
                <x-text-input id="password" class="auth-input"
                              type="password" name="password"
                              required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="form-group mt-4">
                <x-input-label for="password_confirmation" :value="__('Confirmer le mot de passe')" />
                <x-text-input id="password_confirmation" class="auth-input"
                              type="password" name="password_confirmation"
                              required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <!-- Actions -->
            <div class="form-actions mt-6 flex justify-between items-center">
                <a class="auth-link" href="{{ route('login') }}">
                    Déjà inscrit ?
                </a>

                <x-primary-button class="btn-auth">
                    {{ __('S\'inscrire') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-guest-layout>
