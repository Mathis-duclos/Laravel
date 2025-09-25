<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Article extends Model
{
    use HasFactory;

    //Autoriser les champs à etre remplis

    protected $fillable = ['title', 'content', 'user_id' ,
        'plateforme', 'annee_sortie', 'note', 'review',
        'points_positifs', 'points_negatifs', 'auteur_review',
        'image_url'
    ];
}
