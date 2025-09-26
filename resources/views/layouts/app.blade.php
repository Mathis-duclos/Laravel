<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>

    @stack('styles')
    <link rel="stylesheet" href="{{ asset('css/footer.css') }}">
</head>
<body>
    <div class="page-wrapper">
        {{-- Contenu de la page --}}
        <main class="page-content">
            @yield('content')
        </main>

        {{-- Footer affiché partout --}}
        @include('partials.footer')
    </div>

    @stack('scripts')
</body>
</html>
