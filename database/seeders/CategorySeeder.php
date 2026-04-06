<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            // Kategori Bahasa Jepang
            ['name' => 'Writing (Hiragana/Katakana)', 'slug' => 'writing',      'type' => 'bahasa'],
            ['name' => 'Kanji',                        'slug' => 'kanji',        'type' => 'bahasa'],
            ['name' => 'Grammar',                      'slug' => 'grammar',      'type' => 'bahasa'],
            ['name' => 'Vocabulary',                   'slug' => 'vocabulary',   'type' => 'bahasa'],
            ['name' => 'Conversation',                 'slug' => 'conversation', 'type' => 'bahasa'],
            ['name' => 'Reading Comprehension',        'slug' => 'reading',      'type' => 'bahasa'],

            // Kategori Umum
            ['name' => 'Budaya',            'slug' => 'budaya',       'type' => 'umum'],
            ['name' => 'Event',             'slug' => 'event',        'type' => 'umum'],
            ['name' => 'Kuliner',           'slug' => 'kuliner',      'type' => 'umum'],
            ['name' => 'Kesenian',          'slug' => 'kesenian',     'type' => 'umum'],
            ['name' => 'Pengetahuan Umum',  'slug' => 'pengetahuan',  'type' => 'umum'],
        ];

        foreach ($categories as $cat) {
            Category::firstOrCreate(['slug' => $cat['slug']], $cat);
        }
    }
}
