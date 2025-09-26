<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Article;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, $articleId)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $article = Article::findOrFail($articleId);

        Comment::create([
            'user_id'    => auth()->id(),
            'article_id' => $article->id,   // ✅ ici on met bien l’article
            'content'    => $request->input('content'),
        ]);

        return redirect()->back()->with('success', 'Commentaire publié !');
    }
}

