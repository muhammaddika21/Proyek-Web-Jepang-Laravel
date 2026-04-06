<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Buat akun admin default jika belum ada
        if (!User::where('username', 'adminukm123')->exists()) {
            User::create([
                'name'     => 'Admin NihonLearn',
                'username' => 'adminukm123',
                'password' => bcrypt('watashikakkoii'),
            ]);
        }

        // Seed kategori
        $this->call(CategorySeeder::class);
    }
}
