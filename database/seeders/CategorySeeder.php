<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category; // <-- Impor model Category
use Illuminate\Support\Str; // <-- Impor Str untuk membuat slug
use Illuminate\Support\Facades\DB; // <-- Impor DB untuk truncate

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Kosongkan tabel sebelum mengisi (cara aman untuk tabel berelasi)
        DB::statement('SET FOREIGN_KEY_CHECKS=0;'); // Matikan cek foreign key
        Category::truncate();                      // Kosongkan tabel
        DB::statement('SET FOREIGN_KEY_CHECKS=1;'); // Hidupkan lagi

        // Buat data kategori contoh
        $categories = [
            'Kemeja Batik Pria',
            'Dress Batik Wanita',
            'Batik Anak',
            'Kain Batik Tulis',
        ];

        foreach ($categories as $categoryName) {
            Category::create([
                'name' => $categoryName,
                'slug' => Str::slug($categoryName) // Membuat slug otomatis
            ]);
        }
    }
}