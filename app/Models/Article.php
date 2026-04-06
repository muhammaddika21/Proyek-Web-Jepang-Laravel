<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'category_id', 'title', 'slug', 'type', 'excerpt',
        'content', 'cover_image', 'cover_image_caption',
        'japanese_title', 'romaji_title', 'jlpt_level',
        'grammar_explanation', 'vocabulary_list', 'quiz_questions',
        'status', 'read_time', 'view_count', 'published_at',
    ];

    protected $casts = [
        'vocabulary_list' => 'array',
        'quiz_questions'  => 'array',
        'published_at'    => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function (Article $article) {
            if (empty($article->slug)) {
                $article->slug = Str::slug($article->title);
            }
            if ($article->status === 'published' && is_null($article->published_at)) {
                $article->published_at = now();
            }
        });

        static::updating(function (Article $article) {
            if ($article->isDirty('status') && $article->status === 'published' && is_null($article->published_at)) {
                $article->published_at = now();
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeBahasa($query)
    {
        return $query->where('type', 'bahasa');
    }

    public function scopeUmum($query)
    {
        return $query->where('type', 'umum');
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'published' => 'bg-green-50 text-green-600 dark:bg-green-500/15 dark:text-green-400',
            'draft'     => 'bg-yellow-50 text-yellow-600 dark:bg-yellow-500/15 dark:text-yellow-400',
            default     => 'bg-gray-100 text-gray-500',
        };
    }

    public function getTypeBadgeAttribute(): string
    {
        return match($this->type) {
            'bahasa' => 'bg-blue-50 text-blue-600 dark:bg-blue-500/15 dark:text-blue-400',
            'umum'   => 'bg-amber-50 text-amber-600 dark:bg-amber-500/15 dark:text-amber-400',
            default  => 'bg-gray-100 text-gray-500',
        };
    }
}
