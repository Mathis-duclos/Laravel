<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>

    {{-- 👉 Chaque vue peut injecter ses propres styles --}}
    @stack('styles')
</head>
<body class="bg-light">

    {{-- Contenu des pages --}}
    <main class="container-fluid py-4">
        @yield('content')
    </main>

    {{-- 👉 Chaque vue peut injecter ses propres scripts --}}
    @stack('scripts')
</body>
</html>
