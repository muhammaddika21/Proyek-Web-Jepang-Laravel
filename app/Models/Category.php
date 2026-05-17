<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'type', 'parent_id'];

    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    /**
     * Parent category (for subcategories of Budaya/Kegiatan)
     */
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    /**
     * Children subcategories
     */
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }
}
