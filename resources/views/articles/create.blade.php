@extends('layouts.app')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

<style>
    /* ✅ Boutons avec texte noir */
    .btn-custom {
        color: #000 !important;   /* Texte noir */
        font-weight: 500;
    }
</style>
@endpush

@section('content')

@include('partials.header')

<div class="container my-5">
    <div class="row justify-content-center">
    {{-- ✅ Plus large : 12 colonnes sur grand écran, max 1400px --}}
    <div class="col-12 col-lg-11 col-xl-12" style="max-width:1400px;">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white">
                    <h1 class="h4 mb-0"><i class="bi bi-file-earmark-plus me-2"></i>Créer un nouvel article</h1>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('articles.store') }}" method="POST">
                        @csrf

                        <!-- Titre -->
                        <div class="mb-3">
                            <label for="title" class="form-label">Titre</label>
                            <input type="text" name="title" class="form-control" id="title" required>
                        </div>

                        <!-- Éditeur -->
                        <div class="mb-3">
                            <label for="editeur" class="form-label">Éditeur</label>
                            <input type="text" name="editeur" class="form-control" id="editeur" value="{{ old('editeur') }}">
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
                                <option value="Nintendo Switch 2">Nintendo Switch 2</option>
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

                        <!-- Musique -->
                        <div class="mb-3">
                            <label for="musique" class="form-label">Musique</label>
                            <input type="text" name="musique" id="musique" class="form-control">
                        </div>

                        <!-- Image de l'article carré -->
                        <div class="mb-3">
                            <label for="image_art" class="form-label">Image carré de l'article (URL publique)</label>
                            <input type="text" name="image_art" id="image_art" class="form-control">
                        </div>

                        <!-- Auteur review (readonly) -->
        <div class="mb-3">
            <label for="auteur_review" class="form-label">Auteur de la review</label>
            <input type="text" id="auteur_review" 
                   class="form-control" 
                   value="{{ Auth::user()->name }}" readonly disabled>
            <!-- Champ hidden pour envoyer quand même en BDD -->
            <input type="hidden" name="auteur_review" value="{{ Auth::user()->name }}">
        </div>
                        <!-- Boutons -->
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('articles.index') }}" class="btn btn-outline-secondary btn-custom">Annuler</a>
                            <button type="submit" class="btn btn-primary btn-custom">Créer l'article</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@endpush

