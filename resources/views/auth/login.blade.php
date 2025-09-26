<x-guest-layout>
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">

    <div class="auth-box">
        <h1 class="auth-title">Connexion</h1>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email -->
            <div class="form-group">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="auth-input"
                              type="email" name="email"
                              :value="old('email')" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="form-group mt-4">
                <x-input-label for="password" :value="__('Mot de passe')" />
                <x-text-input id="password" class="auth-input"
                              type="password" name="password"
                              required autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Remember -->
            <div class="form-group mt-4 flex items-center">
                <input id="remember_me" type="checkbox" class="auth-checkbox" name="remember">
                <label for="remember_me" class="ml-2 text-sm text-gray-700">Se souvenir de moi</label>
            </div>

            <!-- Actions -->
            <div class="form-actions mt-6 flex justify-between items-center">
                @if (Route::has('password.request'))
                    <a class="auth-link" href="{{ route('password.request') }}">
                        Mot de passe oublié ?
                    </a>
                @endif

                <x-primary-button class="btn-auth">
                    {{ __('Se connecter') }}
                </x-primary-button>
            </div>

            <!-- Google -->
            <div class="mt-6 text-center">
                <a href="{{ route('google.redirect') }}" class="btn-google">
                    <svg class="w-4 h-4 mr-2 inline" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 488 512" fill="currentColor">
                        <path d="M488 261.8c0-17.8-1.6-35-4.7-51.6H249v97.8h135.7c-5.9 32-23.6 59.2-50.5 77.2l81.4 63.4c47.6-43.9 72.4-108.6 72.4-186.8z"/>
                        <path d="M249 492c66.4 0 122.1-21.9 162.9-59.3l-81.4-63.4c-22.5 15.1-51.1 23.9-81.5 23.9-62.7 0-115.8-42.4-134.8-99.4l-83.2 64.4C67.7 433.6 152 492 249 492z"/>
                        <path d="M114.2 294.8c-5.6-16.8-8.7-34.7-8.7-53.8s3.1-37 8.7-53.8l-83.2-64.4C11.2 162.4 0 204.1 0 241s11.2 78.6 31 118.2l83.2-64.4z"/>
                        <path d="M249 97.5c35.7 0 67.8 12.3 93 36.4l69.7-69.7C365.8 25.6 310.1 0 249 0 152 0 67.7 58.4 31 122.8l83.2 64.4C133.2 139.9 186.3 97.5 249 97.5z"/>
                    </svg>
                    Connexion avec Google
                </a>
            </div>
        </form>
    </div>
</x-guest-layout>
