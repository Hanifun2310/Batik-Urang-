<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash; // Tambahkan ini jika ingin membuat user contoh

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Panggil semua seeder dalam urutan yang benar
        $this->call([
            CategorySeeder::class, // 1. Buat kategori dulu
            ProductSeeder::class,  // 2. Baru buat produk (butuh kategori)
            ArticleSeeder::class, // 3. Buat artikel
        ]);
    }
}