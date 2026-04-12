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
            ['name' => 'Complete Guide',  'slug' => 'complete-guide', 'type' => 'bahasa'],
            ['name' => 'Kanji',           'slug' => 'kanji',          'type' => 'bahasa'],
            ['name' => 'Kotoba',          'slug' => 'kotoba',         'type' => 'bahasa'],
            ['name' => 'Bunpou',          'slug' => 'bunpou',         'type' => 'bahasa'],
            ['name' => 'Kaiwa',           'slug' => 'kaiwa',          'type' => 'bahasa'],

            // Kategori Umum
            ['name' => 'Budaya',   'slug' => 'budaya',  'type' => 'umum'],
            ['name' => 'Event',    'slug' => 'event',   'type' => 'umum'],
            ['name' => 'Kuliner',  'slug' => 'kuliner', 'type' => 'umum'],
        ];

        foreach ($categories as $cat) {
            Category::firstOrCreate(['slug' => $cat['slug']], $cat);
        }
    }
}
