@extends('layouts.app')
<!DOCTYPE html>
<html lang="en">
        <main class="container-fluid py-4">
        @yield('content')
    </main>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site</title>
</head>
<body>
    @include('partials.header')

@section('content')
<link rel="stylesheet" href="{{ asset('css/home.css') }}">
@include('partials.header')

    <div class="min-h-screen">
        @yield('content')
    </div>

    <section class="hero-section">
        <h1>Bienvene sur NOM DU SITE!</h1>
        <br>
        <h2>Le meilleur site de review de l'IUT<h2>

    </section>

    {{-- Derniers articles --}}
    <section class="articles-section">
        <h2>Articles récents</h2>

        @if($articles->count() > 0)
            <div class="articles-grid">
                @foreach($articles as $article)
                    <div class="card">
                        <div class="image-container">
                            @if ($article->image_art)
                                <a href="{{ route('articles.review', $article->id) }}" class="image-link">
                                    <img src="{{ $article->image_art }}" alt="Image de l'article" class="card-image">
                                </a>
                            @else
                                <a href="{{ route('articles.review', $article->id) }}" class="image-link">
                                    <img src="https://via.placeholder.com/300x300?text=Pas+d'image" alt="Image de l'article" class="card-image">
                                </a>
                            @endif

                            <!-- Overlay dégradé pour rendre le texte lisible -->
                            <div class="overlay">
                                <h3 class="overlay-title">
                                    <a href="{{ route('articles.review', $article->id) }}">{{ $article->title }}</a>
                                </h3>
                            </div>
                        </div>

                        <!-- Partie blanche cachée, visible uniquement au hover -->
                        <div class="hidden-text">
                            <small>
                                @if($article->plateforme)
                                    {{ $article->plateforme }}
                                @endif
                                @if($article->editeur)
                                    — {{ $article->editeur }}
                                @endif
                            </small>
                            <p>{{ Str::limit($article->content, 150) }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p>Aucun article pour le moment.</p>
        @endif
    </section>

    
    {{-- Form logout (inutile sur welcome si public, mais tu peux le garder) --}}
    <form method="POST" action="{{ route('logout') }}">
        @csrf
    </form>

    <style>
    /* Grid */
    .articles-grid {
        display:flex;
        flex-wrap:wrap;
        gap:20px;
        align-items:flex-start;
    }

    /* Card */
    .card {
        width:300px;
        border-radius:12px;
        overflow:hidden;
        background:white;
        box-shadow: 0 6px 18px rgba(0,0,0,0.08);
        cursor:pointer;
        transition: transform 0.28s ease, box-shadow 0.28s ease;
        display:flex;
        flex-direction:column;
    }

    /* force le carréé */
    .image-container {
        position:relative;
        width:100%;
        aspect-ratio:1/1; /* force carrré */
        overflow:hidden;
        flex: 0 0 auto; /* empêche l'image de s'étirer quand la card est étiréé */
    }

    /* Image */
    .card-image {
        width:100%;
        height:100%;
        object-fit:cover;
        display:block;
        transition: transform 0.35s ease;
    }

    /* Overlay: transparent pourlalisibilité*/
    .overlay {
        position:absolute;
        left:0;
        right:0;
        top:0;
        bottom:0;
        display:flex;
        flex-direction:column;
        justify-content:flex-end;
        padding:16px;
        color:#fff;
        background: linear-gradient(to bottom, rgba(255,255,255,0) 25%, rgba(0,0,0,1) 100%);
      pointer-events:none; /* laisse les clics sur le lien */
    }

    .overlay-title { margin:0; font-size:1.05rem; }
    .overlay-title a { color: #fff; text-decoration:none; }

    /* cache le blanc derrière l'image par défaut */
    .hidden-text {
        background:white;
        color:#111;
        max-height:0;
        overflow:hidden;
        padding:0 16px;
        transition: all 0.35s ease;
        font-size:0.95rem;
        line-height:1.4;
    }

    /* le hover affiche le blanc de derreiere  */
    .card:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 30px rgba(0,0,0,0.18);
    }
    .card:hover .card-image { transform: scale(1.03); }
    .card:hover .hidden-text {
      max-height:160px; 
        padding:16px;
    }

    /* Pour les écrans touts petits comme Hélène */
    @media (max-width:640px) {
        .card { width:calc(50% - 10px); }
    }
    @media (max-width:420px) {
        .card { width:100%; }
    }
    </style>
</body>
</html>
