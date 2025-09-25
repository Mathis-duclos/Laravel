@extends('layouts.app')

@section('content')

<body> 
        <body>
    @include('partials.header')
    {{-- le reste de ton layout --}}
    <div class="min-h-screen">
        @yield('content')
    </div>
</body>

    <h1>Modifier l'article</h1>

    {{-- Affichage rapide des erreurs de validation --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('articles.update', $article->id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Titre --}}
        <div class="mb-3">
            <label for="title" class="form-label">Titre</label>
            <input type="text" name="title" id="title" class="form-control"
                   value="{{ old('title', $article->title) }}" required>
        </div>

        {{-- Contenu --}}
        <div class="mb-3">
            <label for="content" class="form-label">Contenu</label>
            <textarea name="content" id="content" rows="5" class="form-control" required>{{ old('content', $article->content) }}</textarea>
        </div>

        {{-- Image URL (publique) + aperçu --}}
        <div class="mb-3">
            <label for="image_url" class="form-label">Image (URL publique)</label>
            <input type="text" name="image_url" id="image_url" class="form-control"
                   value="{{ old('image_url', $article->image_url) }}">
            @php $previewUrl = trim((string) old('image_url', $article->image_url)); @endphp
            @if($previewUrl !== '')
                <div class="mt-2">
                    <small class="text-muted">Aperçu :</small><br>
                    <img src="{{ $previewUrl }}" alt="Aperçu"
                         style="max-width: 200px; height: auto"
                         onerror="this.style.display='none'">
                </div>
            @endif
        </div>

        {{-- Plateforme (pré-sélection) --}}
        @php
            $platforms = [
                'PlayStation 5','PlayStation 4','PlayStation 3',
                'Xbox Series X/S','Xbox One','Xbox 360',
                'Nintendo Switch','Nintendo Wii U','Nintendo 3DS','Nintendo DS',
                'Nintendo Wii','Nintendo GameCube','Nintendo 64','Nintendo SNES','Nintendo NES',
                'Sega Genesis/Mega Drive','Sega Saturn','Sega Dreamcast',
                'Atari','PC','Autre'
            ];
            $currentPlatform = old('plateforme', $article->plateforme);
        @endphp
        <div class="mb-3">
            <label for="plateforme" class="form-label">Plateforme</label>
            <select name="plateforme" id="plateforme" class="form-select" required>
                <option value="">-- Choisir une console --</option>
                @foreach($platforms as $p)
                    <option value="{{ $p }}" {{ $currentPlatform === $p ? 'selected' : '' }}>{{ $p }}</option>
                @endforeach
            </select>
        </div>

        {{-- Année de sortie (pré-sélection) --}}
        @php
            $currentYear = (int) date('Y');
            $selectedYear = (int) old('annee_sortie', (int) ($article->annee_sortie ?? 0));
        @endphp
        <div class="mb-3">
            <label for="annee_sortie" class="form-label">Année de sortie</label>
            <select name="annee_sortie" id="annee_sortie" class="form-select" required>
                <option value="">-- Choisir une année --</option>
                @for ($year = $currentYear; $year >= 1980; $year--)
                    <option value="{{ $year }}" {{ $selectedYear === $year ? 'selected' : '' }}>{{ $year }}</option>
                @endfor
            </select>
        </div>

        {{-- Note (préremplie) --}}
        <div class="mb-3">
            <label for="note" class="form-label">Note (1 à 10)</label>
            <input type="number" name="note" id="note" class="form-control" min="1" max="10"
                   value="{{ old('note', $article->note) }}" required>
        </div>

        {{-- Review (préremplie) --}}
        <div class="mb-3">
            <label for="review" class="form-label">Critique / Review</label>
            <textarea name="review" id="review" class="form-control" rows="4">{{ old('review', $article->review) }}</textarea>
        </div>

        {{-- Points positifs (préremplis) --}}
        <div class="mb-3">
            <label for="points_positifs" class="form-label">Points positifs</label>
            <textarea name="points_positifs" id="points_positifs" class="form-control" rows="3">{{ old('points_positifs', $article->points_positifs) }}</textarea>
        </div>

        {{-- Points négatifs (préremplis) --}}
        <div class="mb-3">
            <label for="points_negatifs" class="form-label">Points négatifs</label>
            <textarea name="points_negatifs" id="points_negatifs" class="form-control" rows="3">{{ old('points_negatifs', $article->points_negatifs) }}</textarea>
        </div>

        {{-- Auteur de la review (prérempli) --}}
        <div class="mb-3">
            <label for="auteur_review" class="form-label">Auteur de la review</label>
            <input type="text" name="auteur_review" id="auteur_review" class="form-control"
                   value="{{ old('auteur_review', $article->auteur_review) }}">
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">Enregistrer</button>
            <a href="{{ route('articles.index') }}" class="btn btn-outline-secondary">Annuler</a>
        </div>
    </form>
@endsection
