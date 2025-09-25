<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site</title>
</head>
<body>
    @include('partials.header')

    <div class="min-h-screen">
        @yield('content')
    </div>

    <h1>Votre site de review JV favori ! </h1>
    <p>This is the welcome page.</p>

    {{-- Derniers articles --}}
    <section style="margin-top:20px;">
        <h2>Articles récents</h2>

        @if($articles->count() > 0)
            <ul>
                @foreach($articles as $article)
                    <li style="margin-bottom:12px;">
                        <h3>
                            <a href="{{ route('articles.review', $article->id) }}">
                                {{ $article->title }}
                            </a>
                        </h3>
                        <small>
                            Publié le {{ $article->created_at->format('d/m/Y H:i') }}
                            @if($article->plateforme)
                                — {{ $article->plateforme }}
                            @endif
                            @if($article->editeur)
                                — {{ $article->editeur }}
                            @endif
                        </small>
                        <p>{{ Str::limit($article->content, 120) }}</p>
                    </li>
                @endforeach
            </ul>
        @else
            <p>Aucun article pour le moment.</p>
        @endif
    </section>

    {{-- Form logout (inutile sur welcome si public, mais tu peux le garder) --}}
    <form method="POST" action="{{ route('logout') }}">
        @csrf
    </form>
</body>
</html>
