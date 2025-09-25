<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel') }}</title>

    
</head>
<body>


    <div class="container">
        <header>
        </header>

        <!-- Page Content -->
        <main>
            @yield('content')  <!-- Affiche la section 'content' -->
        </main>
    </div>
</body>
</html>
