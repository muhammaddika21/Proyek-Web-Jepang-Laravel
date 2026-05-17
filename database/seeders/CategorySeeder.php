<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        // ======= Kategori Bahasa Jepang (flat, tanpa parent) =======
        $bahasaCategories = [
            ['name' => 'Complete Guide',  'slug' => 'complete-guide', 'type' => 'bahasa'],
            ['name' => 'Kanji',           'slug' => 'kanji',          'type' => 'bahasa'],
            ['name' => 'Kotoba',          'slug' => 'kotoba',         'type' => 'bahasa'],
            ['name' => 'Bunpou',          'slug' => 'bunpou',         'type' => 'bahasa'],
            ['name' => 'Kaiwa',           'slug' => 'kaiwa',          'type' => 'bahasa'],
        ];

        foreach ($bahasaCategories as $cat) {
            Category::firstOrCreate(['slug' => $cat['slug']], $cat);
        }

        // ======= Kategori Budaya (parent → children) =======
        $budayaParent = Category::firstOrCreate(
            ['slug' => 'budaya'],
            ['name' => 'Budaya', 'slug' => 'budaya', 'type' => 'umum']
        );

        $budayaChildren = [
            ['name' => 'Pop Culture',        'slug' => 'pop-culture',        'type' => 'umum'],
            ['name' => 'Budaya Tradisional',  'slug' => 'budaya-tradisional', 'type' => 'umum'],
            ['name' => 'Everyday Life',       'slug' => 'everyday-life',      'type' => 'umum'],
        ];

        foreach ($budayaChildren as $child) {
            Category::firstOrCreate(
                ['slug' => $child['slug']],
                array_merge($child, ['parent_id' => $budayaParent->id])
            );
        }

        // ======= Kategori Kegiatan (parent → children) =======
        $kegiatanParent = Category::firstOrCreate(
            ['slug' => 'kegiatan'],
            ['name' => 'Kegiatan', 'slug' => 'kegiatan', 'type' => 'umum']
        );

        $kegiatanChildren = [
            ['name' => 'Event',             'slug' => 'event',             'type' => 'umum'],
            ['name' => 'Kegiatan Terbaru',  'slug' => 'kegiatan-terbaru',  'type' => 'umum'],
        ];

        foreach ($kegiatanChildren as $child) {
            Category::firstOrCreate(
                ['slug' => $child['slug']],
                array_merge($child, ['parent_id' => $kegiatanParent->id])
            );
        }

        // ======= Cleanup: hapus kategori lama yang sudah diganti =======
        $oldSlugs = ['tradisi', 'kuliner', 'seni-hiburan', 'kehidupan', 'workshop', 'kompetisi'];
        Category::whereIn('slug', $oldSlugs)->delete();
    }
}
