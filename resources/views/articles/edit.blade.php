@extends('layouts.app')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
<style>
    .btn-custom {
        color: #000 !important;
        font-weight: 500;
    }
</style>
@endpush

@section('content')

@include('partials.header')

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-11 col-xl-12" style="max-width:1400px;">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white">
                    <h1 class="h4 mb-0"><i class="bi bi-pencil-square me-2"></i>Modifier l'article</h1>
                </div>
                <div class="card-body p-4">

                    {{-- Erreurs de validation --}}
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

                        {{-- Éditeur --}}
                        <div class="mb-3">
                            <label for="editeur" class="form-label">Éditeur</label>
                            <input type="text" name="editeur" id="editeur" class="form-control"
                                value="{{ old('editeur', $article->editeur) }}">
                        </div>

                        {{-- Contenu --}}
                        <div class="mb-3">
                            <label for="content" class="form-label">Contenu</label>
                            <textarea name="content" id="content" rows="5" class="form-control" required>{{ old('content', $article->content) }}</textarea>
                        </div>

                        {{-- Image URL --}}
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

                        {{-- Plateforme --}}
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

                        {{-- Année de sortie --}}
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

                        {{-- Note --}}
                        <div class="mb-3">
                            <label for="note" class="form-label">Note (1 à 10)</label>
                            <input type="number" name="note" id="note" class="form-control" min="1" max="10"
                                value="{{ old('note', $article->note) }}" required>
                        </div>

                        {{-- Review --}}
                        <div class="mb-3">
                            <label for="review" class="form-label">Critique / Review</label>
                            <textarea name="review" id="review" class="form-control" rows="4">{{ old('review', $article->review) }}</textarea>
                        </div>

                        {{-- Points positifs --}}
                        <div class="mb-3">
                            <label for="points_positifs" class="form-label">Points positifs</label>
                            <textarea name="points_positifs" id="points_positifs" class="form-control" rows="3">{{ old('points_positifs', $article->points_positifs) }}</textarea>
                        </div>

                        {{-- Points négatifs --}}
                        <div class="mb-3">
                            <label for="points_negatifs" class="form-label">Points négatifs</label>
                            <textarea name="points_negatifs" id="points_negatifs" class="form-control" rows="3">{{ old('points_negatifs', $article->points_negatifs) }}</textarea>
                        </div>

                        {{-- Musique --}}
                        <div class="mb-3">
                            <label for="musique" class="form-label">Musique</label>
                            <input type="text" name="musique" id="musique" class="form-control"
                                value="{{ old('musique', $article->musique) }}">
                        </div>

                        {{-- Image carré de l'article --}}
                        <div class="mb-3">
                            <label for="image_art" class="form-label">Image carré de l'article (URL publique)</label>
                                <input type="text" name="image_art" id="image_art" class="form-control"
                                     value="{{ old('image_art', $article->image_art) }}">

                            @php 
                                    $previewArt = trim((string) old('image_art', $article->image_art)); 
                                            @endphp

                        @if($previewArt !== '')
                            <div class="mt-2">
                                      <small class="text-muted">Aperçu :</small><br>
                                    <img src="{{ $previewArt }}" alt="Aperçu carré"
                                        style="max-width: 200px; height: 200px; object-fit: cover; border:1px solid #ddd; border-radius:6px;"
                                            onerror="this.style.display='none'">
                                                </div>
                                                @endif
                                                </div>


                        {{-- Auteur --}}
                        <div class="mb-3">
                            <label for="auteur_review" class="form-label">Auteur de la review</label>
                            <input type="text" name="auteur_review" id="auteur_review" class="form-control"
                                value="{{ old('auteur_review', $article->auteur_review) }}">
                        </div>

                        {{-- Boutons --}}
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('articles.index') }}" class="btn btn-outline-secondary btn-custom">Annuler</a>
                            <button type="submit" class="btn btn-primary btn-custom">Enregistrer</button>
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
