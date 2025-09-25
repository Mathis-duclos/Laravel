<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    // Afficher tous les articles (uniquement ceux de l'utilisateur connecté)
    public function index()
    {
        $articles = Article::where('user_id', Auth::id())->get();
        return view('articles.index', compact('articles'));
    }

    // Formulaire de création d'un article
    public function create()
    {
        return view('articles.create');
    }

    // Enregistrer un nouvel article
    public function store(Request $request)
    {
        // ---- Validation ----
        $request->validate([
            'title'            => 'required|string|max:255',
            'content'          => 'required|string',
            'image_url'        => 'nullable|string|max:2048', // URL publique
            'plateforme'       => 'nullable|string|max:255',
            'annee_sortie'     => 'nullable|integer',
            'note'             => 'nullable|integer|between:1,10',
            'review'           => 'nullable|string',
            'points_positifs'  => 'nullable|string',
            'points_negatifs'  => 'nullable|string',
            'auteur_review'    => 'nullable|string|max:255',
        ]);

        // ---- Création ----
        $article = new Article();
        $article->title            = $request->input('title');
        $article->content          = $request->input('content');
        $article->user_id          = Auth::id();

        // Nouvelles colonnes
        $article->image_url        = trim((string) $request->input('image_url'));
        $article->plateforme       = $request->input('plateforme');
        $article->annee_sortie     = $request->integer('annee_sortie'); // cast int
        $article->note             = $request->integer('note');          // cast int
        $article->review           = $request->input('review');
        $article->points_positifs  = $request->input('points_positifs');
        $article->points_negatifs  = $request->input('points_negatifs');
        $article->auteur_review    = $request->input('auteur_review');
        $article->editeur         = $request->input('editeur');

        // Plus d'upload de fichier : on ne touche pas à $article->image

        $article->save();

        return redirect()->route('articles.index')->with('success', 'Article créé avec succès.');
    }

    // Formulaire d'édition d'un article
    public function edit(Article $article)
    {
        if ($article->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('articles.edit', compact('article'));
    }

    // Mettre à jour un article
    public function update(Request $request, Article $article)
    {
        if ($article->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // ---- Validation ----
        $request->validate([
            'title'            => 'required|string|max:255',
            'content'          => 'required|string',
            'image_url'        => 'nullable|string|max:2048', // URL publique
            'plateforme'       => 'nullable|string|max:255',
            'annee_sortie'     => 'nullable|integer',
            'note'             => 'nullable|integer|between:1,10',
            'review'           => 'nullable|string',
            'points_positifs'  => 'nullable|string',
            'points_negatifs'  => 'nullable|string',
            'auteur_review'    => 'nullable|string|max:255',
            'editeur'          => 'nullable|string|max:255',
        ]);

        // ---- Mises à jour ----
        $article->title            = $request->input('title');
        $article->content          = $request->input('content');

        // Nouvelles colonnes
        $article->image_url        = trim((string) $request->input('image_url'));
        $article->plateforme       = $request->input('plateforme');
        $article->annee_sortie     = $request->integer('annee_sortie');
        $article->note             = $request->integer('note');
        $article->review           = $request->input('review');
        $article->points_positifs  = $request->input('points_positifs');
        $article->points_negatifs  = $request->input('points_negatifs');
        $article->auteur_review    = $request->input('auteur_review');
        $article->editeur          = $request->input('editeur');

        // Plus d'upload de fichier

        $article->save();

        return redirect()->route('articles.index')->with('success', 'Article mis à jour avec succès.');
    }

    // Supprimer un article
    public function destroy(Article $article)
    {
        if ($article->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $article->delete();

        return redirect()->route('articles.index')->with('success', 'Article supprimé avec succès.');
    }

    // Afficher un article (review)
    public function show(Article $article)
    {
        return view('articles.review', compact('article'));
    }
}
