@extends('layouts.app') <!-- Utilise le layout app.blade.php -->

@section('content')  <!-- Définir la section 'content' -->

<body>
    @include('partials.header')
    {{-- le reste de ton layout --}}
    <div class="min-h-screen">
        @yield('content')
    </div>
</body>
    <h1>Mes Articles</h1>
    <a href="{{ route('articles.create') }}" class="btn btn-primary mb-3">Créer un nouvel article</a>
    
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Titre</th>
                <th>Contenu</th>
                <th>Plateforme</th>
                <th>Année</th>
                <th>Note</th>
                <th>Review</th>
                <th>Points positifs</th>
                <th>Points négatifs</th>
                <th>Auteur review</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($articles as $article)
                <tr>
                    <td>{{ $article->title }}</td>
                    <td>{{ Str::limit($article->content, 80) }}</td>
                    <td>{{ $article->plateforme ?? '-' }}</td>
                    <td>{{ $article->annee_sortie ?? '-' }}</td>
                    <td>{{ $article->note ?? '-' }}/10</td>
                    <td>{{ Str::limit($article->review, 80) }}</td>
                    <td>{{ Str::limit($article->points_positifs, 50) }}</td>
                    <td>{{ Str::limit($article->points_negatifs, 50) }}</td>
                    <td>{{ $article->auteur_review ?? '-' }}</td>
                    <td>
                        @if ($article->image)
                            <img src="{{ asset('storage/' . $article->image) }}" alt="Image de l'article" width="80">
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('articles.edit', $article->id) }}" class="btn btn-warning btn-sm">Modifier</a>
                        
                        <form action="{{ route('articles.destroy', $article->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                        </form>
                        <a href="{{ route('articles.review', $article->id) }}" class="btn btn-info btn-sm">Voir la review</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="11" class="text-center">Aucun article trouvé.</td>
                </tr>
            @endforelse
        </tbody>

        
    </table>
@endsection
