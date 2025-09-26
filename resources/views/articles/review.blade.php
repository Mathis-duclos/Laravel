@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/review.css') }}">
@include('partials.header')

<div class="min-h-screen">
    @yield('content')
</div>
<div class="container py-3">
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

    <div class="review-layout">
        <div class="colonne-gauche">
            <div class="info-box">
                @if(!empty($article->musique))
                    <div class="mb-3">
                        <audio id="audioPlayer" src="{{ $article->musique }}" preload="auto"></audio>

                        {{-- ✅ Player Spotify-like --}}
                        <div class="music-player">
                            <button type="button" class="play-btn" id="playPauseBtn">
                                <span class="icon icon-play"></span>
                            </button>
                            <input type="range" id="progressBar" value="0" min="0" step="1">
                            <span id="timeLabel" class="small text-muted">0:00</span>
                        </div>

                        <style>
                            .music-player {
                                display: flex;
                                align-items: center;
                                gap: 12px;
                                width: 100%;
                                max-width: 600px;
                            }
                            .music-player .play-btn {
                                border: none;
                                background: #1C62C1;
                                border-radius: 50%;
                                width: 50px;
                                height: 50px;
                                cursor: pointer;
                                display: flex;
                                align-items: center;
                                justify-content: center;
                                transition: background 0.2s ease;
                                padding: 0;
                                flex-shrink: 0;
                            }
                            .music-player .play-btn:hover { background: #1C62C1; }
                            .music-player .icon-play {
                                width: 0;
                                height: 0;
                                border-left: 14px solid #fff;
                                border-top: 9px solid transparent;
                                border-bottom: 9px solid transparent;
                                margin-left: 3px;
                            }
                            .music-player .icon-pause {
                                display: flex;
                                gap: 5px;
                            }
                            .music-player .icon-pause div {
                                width: 5px;
                                height: 18px;
                                background: #fff;
                            }
                            .music-player #progressBar {
                                flex: 1;
                                -webkit-appearance: none;
                                height: 5px;
                                background: #ddd;
                                border-radius: 3px;
                                cursor: pointer;
                            }
                            .music-player #progressBar::-webkit-slider-thumb {
                                -webkit-appearance: none;
                                width: 12px;
                                height: 12px;
                                border-radius: 50%;
                                background: #1C62C1;
                                cursor: pointer;
                            }
                            .music-player #progressBar::-moz-range-thumb {
                                width: 12px;
                                height: 12px;
                                border-radius: 50%;
                                background: #1C62C1;
                                cursor: pointer;
                            }
                            .music-player #timeLabel {
                                min-width: 40px;
                                text-align: right;
                            }
                        </style>

                        <script>
                            document.addEventListener('DOMContentLoaded', () => {
                                const audio = document.getElementById('audioPlayer');
                                const btn = document.getElementById('playPauseBtn');
                                const progressBar = document.getElementById('progressBar');
                                const timeLabel = document.getElementById('timeLabel');

                                function formatTime(seconds) {
                                    const m = Math.floor(seconds / 60);
                                    const s = Math.floor(seconds % 60).toString().padStart(2, '0');
                                    return `${m}:${s}`;
                                }

                                // Toggle Play/Pause
                                btn.addEventListener('click', () => {
                                    if (audio.paused) {
                                        audio.play();
                                        btn.innerHTML = '<span class="icon icon-pause"><div></div><div></div></span>';
                                    } else {
                                        audio.pause();
                                        btn.innerHTML = '<span class="icon icon-play"></span>';
                                    }
                                });

                                // Update progress bar
                                audio.addEventListener('timeupdate', () => {
                                    progressBar.value = audio.currentTime;
                                    timeLabel.textContent = formatTime(audio.currentTime);
                                });

                                // Set max duration
                                audio.addEventListener('loadedmetadata', () => {
                                    progressBar.max = audio.duration;
                                });

                                // Seek
                                progressBar.addEventListener('input', () => {
                                    audio.currentTime = progressBar.value;
                                });
                            });
                        </script>
                    </div>
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
        // Conversion note/10 vers note/5
        $noteSur5 = max(0, min(5, $article->note / 2));
        $fullStars = floor($noteSur5);
        $halfStar  = ($noteSur5 - $fullStars) >= 0.5 ? 1 : 0;
        $emptyStars = 5 - $fullStars - $halfStar;

        // SVG templates (grande taille 28px)
        $svgFull = '<svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="#FFD700" viewBox="0 0 16 16"><path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/></svg>';
        $svgHalf = '<svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="#FFD700" viewBox="0 0 16 16"><path d="M8 12.146l-3.76 1.93.72-4.2L2 6.865l4.24-.615L8 2.5v9.646z"/></svg>';
        $svgEmpty = '<svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="#ccc" viewBox="0 0 16 16"><path d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.159-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 00-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73z"/></svg>';
    @endphp

    <div class="mt-2 mb-3 d-flex align-items-center gap-3">
        <span class="note-stars" aria-label="note" style="display:flex; gap:6px;">
            {{-- Pleines --}}
            @for ($i = 0; $i < $fullStars; $i++)
                {!! $svgFull !!}
            @endfor

            {{-- Demi --}}
            @if($halfStar)
                {!! $svgHalf !!}
            @endif

            {{-- Vides --}}
            @for ($i = 0; $i < $emptyStars; $i++)
                {!! $svgEmpty !!}
            @endfor
        </span>

        <span class="text-muted" style="font-style: italic; font-size: 1.1rem;">
            ({{ $article->note }}/10)
        </span>
    </div>
@endif


                @if($article->content)
                    <div class="mb-3">
                        <h2 class="h5">Présentation</h2>
                        <p class="mb-0">{{ $article->content }}</p>
                    </div>
                @endif
            </div>
            
            <div class="info-box">
                <div class="text-muted small mb-3">
                    Publié le {{ $article->created_at?->format('d/m/Y H:i') }}
                    @if($article->updated_at && $article->updated_at->ne($article->created_at))
                        — MAJ {{ $article->updated_at->format('d/m/Y H:i') }}
                    @endif
                </div>
                
                @if($article->user)
    <p><strong>Auteur :</strong> {{ $article->user->name }}</p>
@endif

            </div>

            <div class="info-box">
                <div class="d-flex gap-2">
                    <a href="{{ url('/') }}" class="btn btn">← Retour</a>

                    @auth
                        @if(auth()->user()->admin == 1)
                            <a href="{{ route('articles.edit', $article->id) }}" class="btn btn">Modifier</a>
                            <form action="{{ route('articles.destroy', $article->id) }}" method="POST"
                                onsubmit="return confirm('Supprimer cet article ?');" class="d-flex">
                                @csrf
                                @method('DELETE')
                                <button class="btn">Supprimer</button>
                            </form>
                        @endif
                    @endauth
                </div>
            </div>
        </div>

        <div class="colonne-droite">
            @if($article->review)
                <div class="review-box mb-3">
                    <h2 class="h5">Critique</h2>
                    <p class="mb-0">{!! nl2br(e($article->review)) !!}</p>
                </div>
            @endif

            <div class="row mb-3">
                @if($article->points_positifs)
                    <div class="col-md-6 points-positifs-box">
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
                    <div class="col-md-6 points-negatifs-box">
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
        </div>
    </div>
</div>
{{-- ✅ Section Commentaires --}}
<div class="comments-section">
    <h3>Commentaires</h3>

   {{-- Liste des commentaires --}}
@foreach($article->comments as $comment)
    <div class="comment-box">
        <div class="comment-header">
            <strong>
                {{ $comment->user->name }}
                {{-- ✅ Badge Créateur si c’est l’auteur de l’article --}}
                @if($comment->user->name === $article->auteur_review)
                    <span class="creator-badge">Créateur</span>
                @endif
            </strong>
            <span>{{ $comment->created_at->format('d/m/Y H:i') }}</span>
        </div>
        <div class="comment-content">
            {{ $comment->content }}
        </div>
    </div>
@endforeach
    {{-- Formulaire nouveau commentaire --}}
    @auth
        <form action="{{ route('comments.store', $article->id) }}" method="POST" class="comment-form">
            @csrf
            <textarea name="content" class="comment-input" placeholder="Écrire un commentaire..." required></textarea>
            <button type="submit" class="comment-btn">Publier</button>
        </form>
    @endauth
</div>
</br></br>
@endsection
<!-- Footer -->