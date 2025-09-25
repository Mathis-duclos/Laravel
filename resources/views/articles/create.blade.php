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

    <h1>Créer un nouvel article</h1>
    <form action="{{ route('articles.store') }}" method="POST">
        @csrf

        <!-- Titre -->
        <div class="mb-3">
            <label for="title" class="form-label">Titre</label>
            <input type="text" name="title" class="form-control" id="title" required>
        </div>

        <!-- Contenu -->
        <div class="mb-3">
            <label for="content" class="form-label">Contenu</label>
            <textarea name="content" class="form-control" id="content" rows="5" required></textarea>
        </div>

        <!-- Image URL -->
        <div class="mb-3">
            <label for="image_url" class="form-label">Image (URL publique)</label>
            <input type="text" name="image_url" class="form-control" id="image_url" value="{{ old('image_url') }}">
        </div>

        <!-- Plateforme -->
        <div class="mb-3">
            <label for="plateforme" class="form-label">Plateforme</label>
            <select name="plateforme" id="plateforme" class="form-select" required>
                <option value="">-- Choisir une console --</option>
                <option value="PlayStation 5">PlayStation 5</option>
                <option value="PlayStation 4">PlayStation 4</option>
                <option value="PlayStation 3">PlayStation 3</option>
                <option value="Xbox Series X/S">Xbox Series X/S</option>
                <option value="Xbox One">Xbox One</option>
                <option value="Xbox 360">Xbox 360</option>
                <option value="Nintendo Switch">Nintendo Switch</option>
                <option value="Nintendo Wii U">Nintendo Wii U</option>
                <option value="Nintendo 3DS">Nintendo 3DS</option>
                <option value="Nintendo DS">Nintendo DS</option>
                <option value="Nintendo Wii">Nintendo Wii</option>
                <option value="Nintendo GameCube">Nintendo GameCube</option>
                <option value="Nintendo 64">Nintendo 64</option>
                <option value="Nintendo SNES">Nintendo SNES</option>
                <option value="Nintendo NES">Nintendo NES</option>
                <option value="Sega Genesis/Mega Drive">Sega Genesis/Mega Drive</option>
                <option value="Sega Saturn">Sega Saturn</option>
                <option value="Sega Dreamcast">Sega Dreamcast</option>
                <option value="Atari">Atari</option>
                <option value="PC">PC</option>
                <option value="Autre">Autre</option>
            </select>
        </div>

        <!-- Année de sortie -->
        <div class="mb-3">
            <label for="annee_sortie" class="form-label">Année de sortie</label>
            <select name="annee_sortie" id="annee_sortie" class="form-select" required>
                <option value="">-- Choisir une année --</option>
                @for ($year = date('Y'); $year >= 1980; $year--)
                    <option value="{{ $year }}">{{ $year }}</option>
                @endfor
            </select>
        </div>

        <!-- Note -->
        <div class="mb-3">
            <label for="note" class="form-label">Note (1 à 10)</label>
            <input type="number" name="note" id="note" class="form-control" min="1" max="10" required>
        </div>

        <!-- Review -->
        <div class="mb-3">
            <label for="review" class="form-label">Critique / Review</label>
            <textarea name="review" id="review" class="form-control" rows="4"></textarea>
        </div>

        <!-- Points positifs -->
        <div class="mb-3">
            <label for="points_positifs" class="form-label">Points positifs</label>
            <textarea name="points_positifs" id="points_positifs" class="form-control" rows="3"></textarea>
        </div>

        <!-- Points négatifs -->
        <div class="mb-3">
            <label for="points_negatifs" class="form-label">Points négatifs</label>
            <textarea name="points_negatifs" id="points_negatifs" class="form-control" rows="3"></textarea>
        </div>

        <!-- Auteur de la review -->
        <div class="mb-3">
            <label for="auteur_review" class="form-label">Auteur de la review</label>
            <input type="text" name="auteur_review" id="auteur_review" class="form-control">
        </div>

        <!-- Bouton -->
        <button type="submit" class="btn btn-primary">Créer l'article</button>
    </form>
@endsection
