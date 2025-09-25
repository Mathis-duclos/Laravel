@extends('layouts.app')

@section('content')

 <link rel="stylesheet" href="{{ asset('css/review.css') }}">

    <body> 
        <body>
    @include('partials.header')
    {{-- le reste de ton layout --}}
    <div class="min-h-screen">
        @yield('content')
    </div>
</body>
    <div class="container py-3">
        {{-- IMAGE: URL PUBLIQUE UNIQUEMENT --}}
        @if(!empty($article->image_url))
            <img
                src="{{ trim($article->image_url) }}"
                alt="Image de l'article"
                width="160"
                class="rounded mb-3"
                referrerpolicy="no-referrer"
                onerror="this.replaceWith(document.createTextNode('⚠️ Impossible de charger l’image depuis l’URL fournie.'))"
            >
        @endif

        @if(!empty($article->musique))
            <div class="mb-3">
                <audio id="audioPlayer" src="{{ $article->musique }}" preload="none"></audio>
                <button type="button" class="btn btn-primary" id="playPauseBtn" onclick="toggleAudio()">
                    ▶️ Play
                </button>
            </div>
            <script>
                function toggleAudio() {
                    const audio = document.getElementById('audioPlayer');
                    const btn = document.getElementById('playPauseBtn');
                    if (audio.paused) {
                        audio.play();
                        btn.textContent = '⏸️ Pause';
                    } else {
                        audio.pause();
                        btn.textContent = '▶️ Play';
                    }
                }
            </script>
        @endif

        <h1 class="h3 mb-1">{{ $article->title }}</h1>

        <div class="text-muted mb-2">
            @if($article->plateforme)
                <span class="badge bg-secondary">{{ $article->plateforme }}</span>
            @endif
            @if($article->annee_sortie)
                <span class="ms-2">• {{ $article->annee_sortie }}</span>
            @endif
            @if($article->editeur)
                <span class="ms-2">• {{ $article->editeur }}</span>
            @endif
        </div>

        @if(!is_null($article->note))
            @php
                $note = max(0, min(10, (int)$article->note));
                $stars = str_repeat('★', $note) . str_repeat('☆', 10 - $note);
            @endphp
            <div class="mt-1 mb-2">
                <strong>Note :</strong> {{ $note }}/10
                <span class="ms-2" aria-label="note" style="letter-spacing:1px;">{{ $stars }}</span>
            </div>
        @endif

        <div class="text-muted small mb-3">
            Publié le {{ $article->created_at?->format('d/m/Y H:i') }}
            @if($article->updated_at && $article->updated_at->ne($article->created_at))
                — MAJ {{ $article->updated_at->format('d/m/Y H:i') }}
            @endif
        </div>

        @if($article->content)
            <div class="mb-3">
                <h2 class="h5">Présentation</h2>
                <p class="mb-0">{{ $article->content }}</p>
            </div>
        @endif

        @if($article->review)
            <div class="mb-3">
                <h2 class="h5">Critique</h2>
                <p class="mb-0">{{ $article->review }}</p>
            </div>
        @endif

        <div class="row g-3 mb-3">
            @if($article->points_positifs)
                <div class="col-md-6">
                    <h3 class="h6 mb-2">Points positifs</h3>
                    @php $pp = preg_split('/[\r\n;]+/', $article->points_positifs); @endphp
                    <ul class="mb-0">
                        @foreach($pp as $p)
                            @if(trim($p) !== '') <li>{{ trim($p) }}</li> @endif
                        @endforeach
                    </ul>
                </div>
            @endif

            @if($article->points_negatifs)
                <div class="col-md-6">
                    <h3 class="h6 mb-2">Points négatifs</h3>
                    @php $pn = preg_split('/[\r\n;]+/', $article->points_negatifs); @endphp
                    <ul class="mb-0">
                        @foreach($pn as $p)
                            @if(trim($p) !== '') <li>{{ trim($p) }}</li> @endif
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        @if($article->auteur_review)
            <div class="mb-3 text-muted">
                <strong>Auteur de la review :</strong> {{ $article->auteur_review }}
            </div>
        @endif

        <div class="d-flex gap-2">
            <a href="{{ route('articles.index') }}" class="btn btn-outline-secondary">← Retour</a>

            @auth
            @if(auth()->user()->admin == 1)
            <a href="{{ route('articles.edit', $article->id) }}" class="btn btn-warning">Modifier</a>
            <form action="{{ route('articles.destroy', $article->id) }}" method="POST"
                    onsubmit="return confirm('Supprimer cet article ?');" class="d-inline">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger">Supprimer</button>
            </form>
            @endif
            @endauth
        </div>
    </div>
@endsection
