@extends('layouts.app')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
<style>
    /* ✅ Responsive : tableau visible seulement desktop */
    @media (max-width: 991px) {
        .table-responsive { display: none; }
        .articles-cards { display: block; }
    }
    @media (min-width: 992px) {
        .articles-cards { display: none; }
    }
</style>
@endpush

@section('content')

@include('partials.header')

<div class="container my-4">

    {{-- En-tête + actions --}}
    <div class="d-flex flex-column flex-md-row gap-2 gap-md-3 justify-content-between align-items-md-center mb-3">
        <h1 class="h3 mb-0">Mes articles</h1>

        <div class="d-flex gap-2 w-100 w-md-auto">
            <form class="w-100" role="search" onsubmit="return false;">
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                    <input type="search" class="form-control" id="tableFilter" placeholder="Rechercher…">
                </div>
            </form>
        </div>
    </div>

    {{-- Etat vide --}}
    @if($articles->isEmpty())
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-5">
                <div class="display-6 mb-2">😕</div>
                <h2 class="h5 mb-2">Aucun article trouvé</h2>
                <p class="text-muted mb-4">Commence par créer ton premier article.</p>
                <a href="{{ route('articles.create') }}" class="btn btn-primary" style="color: black;">
                    <i class="bi bi-plus-lg me-1"></i> Nouveau
                </a>
            </div>
        </div>
    @else

    {{-- Tableau (desktop) --}}
    <div class="table-responsive shadow-sm rounded-3">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-dark sticky-top">
                <tr>
                    <th>Article</th>
                    <th>Aperçu contenu</th>
                    <th>Plateforme</th>
                    <th>Année</th>
                    <th>Note</th>
                    <th>Review</th>
                    <th>Points +</th>
                    <th>Points −</th>
                    <th>Auteur</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody id="articlesTable">
                @foreach ($articles as $article)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                @if ($article->image_art)
                                    <img src="{{ $article->image_art }}" alt="Image du jeu"
                                         class="rounded object-fit-cover"
                                         style="width:56px;height:56px;" onerror="this.style.display='none'">
                                @endif
                                <div>
                                    <div class="fw-semibold">{{ $article->title }}</div>
                                    <small class="text-muted">
                                        {{ $article->plateforme ?? '' }}
                                        @if($article->annee_sortie) • {{ $article->annee_sortie }} @endif
                                    </small>
                                </div>
                            </div>
                        </td>
                        <td>{{ Str::limit($article->content, 80) }}</td>
                        <td>{{ $article->plateforme ?? '—' }}</td>
                        <td>{{ $article->annee_sortie ?? '—' }}</td>
                        <td>{{ $article->note ? $article->note.'/10' : '—' }}</td>
                        <td>{{ Str::limit($article->review, 80) }}</td>
                        <td>{{ Str::limit($article->points_positifs, 60) }}</td>
                        <td>{{ Str::limit($article->points_negatifs, 60) }}</td>
                        <td>{{ $article->auteur_review ?? '—' }}</td>
                        <td class="text-center">
                            <a href="{{ route('articles.review', $article->id) }}" class="btn btn-info btn-sm">Voir</a>
                            <a href="{{ route('articles.edit', $article->id) }}" class="btn btn-warning btn-sm">Modifier</a>
                            <form action="{{ route('articles.destroy', $article->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer cet article ?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Cartes (mobile/tablette) --}}
    <div class="articles-cards">
        <div class="row g-3">
            @foreach ($articles as $article)
                <div class="col-12">
                    <div class="card shadow-sm h-100 article-card">
                        <div class="card-body d-flex gap-3 align-items-center">
                            @if ($article->image_art)
                                <img src="{{ $article->image_art }}" alt="Miniature"
                                     class="rounded"
                                     style="width:80px;height:80px;object-fit:cover;">
                            @endif
                            <div>
                                <h5 class="mb-1">{{ $article->title }}</h5>
                                <small class="text-muted">
                                    {{ $article->plateforme ?? '' }}
                                    @if($article->annee_sortie) • {{ $article->annee_sortie }} @endif
                                </small>
                                <p class="mb-1 small text-truncate">{{ $article->content }}</p>
                                <div class="d-flex gap-2 mt-2">
                                    <a href="{{ route('articles.review', $article->id) }}" class="btn btn-info btn-sm">Voir</a>
                                    <a href="{{ route('articles.edit', $article->id) }}" class="btn btn-warning btn-sm">Modifier</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    @if(method_exists($articles, 'links'))
        <div class="mt-3">{{ $articles->links() }}</div>
    @endif

    {{-- Bouton en bas --}}
    <div class="mt-4 text-end">
        <a href="{{ route('articles.create') }}" class="btn btn-primary" style="color: black;">
            <i class="bi bi-plus-lg me-1"></i> Créer un article
        </a>
    </div>

    @endif
</div>

{{-- JS recherche universel (table + cartes) --}}
<script>
document.addEventListener('DOMContentLoaded', () => {
    const input = document.getElementById('tableFilter');
    if(!input) return;

    const rows = document.querySelectorAll('#articlesTable tr');
    const cards = document.querySelectorAll('.articles-cards .article-card');

    input.addEventListener('input', () => {
        const q = input.value.toLowerCase().trim();

        // 🔹 Filtrer les lignes du tableau
        rows.forEach(tr => {
            tr.style.display = tr.textContent.toLowerCase().includes(q) ? '' : 'none';
        });

        // 🔹 Filtrer les cartes
        cards.forEach(card => {
            card.style.display = card.textContent.toLowerCase().includes(q) ? '' : 'none';
        });
    });
});
</script>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@endpush
