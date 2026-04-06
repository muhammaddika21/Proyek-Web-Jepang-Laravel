<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticleQuiz extends Model
{
    use HasFactory;

    protected $fillable = ['article_id', 'question', 'options', 'correct_answer_index'];

    protected $casts = [
        'options' => 'array',
        'correct_answer_index' => 'integer',
    ];

    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}
