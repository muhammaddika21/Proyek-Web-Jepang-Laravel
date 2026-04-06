<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticleVocabulary extends Model
{
    use HasFactory;

    protected $fillable = ['article_id', 'kanji', 'furigana', 'meaning', 'example'];

    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}
