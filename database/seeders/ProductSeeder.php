<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product; // <-- Impor model Product
use App\Models\Category; // <-- Impor model Category
use Illuminate\Support\Facades\DB; // <-- Impor DB untuk truncate

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Kosongkan tabel
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Product::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Ambil ID kategori yang sudah dibuat oleh CategorySeeder
        $kemejaPria = Category::where('slug', 'kemeja-batik-pria')->first();
        $dressWanita = Category::where('slug', 'dress-batik-wanita')->first();
        $batikAnak = Category::where('slug', 'batik-anak')->first();
        $kainTulis = Category::where('slug', 'kain-batik-tulis')->first();

        // Buat data produk contoh
        Product::create([
            'name' => 'Kemeja Batik Parang Modern',
            'description' => 'Kemeja batik pria lengan panjang dengan motif Parang modern. Bahan katun primisima, adem dan nyaman dipakai.',
            'price' => 175000.00,
            'stock_quantity' => 25,
            'main_image_url' => 'https://via.placeholder.com/600x400.png?text=Kemeja+Parang',
            'size_chart_note' => "Size M: LD 104cm, P 70cm.\nSize L: LD 108cm, P 72cm.", // Gunakan \n untuk baris baru
            'category_id' => $kemejaPria->id ?? null // Hubungkan ke kategori Kemeja Pria
        ]);

        Product::create([
            'name' => 'Dress Batik Kawung Elegan',
            'description' => 'Dress batik wanita motif Kawung klasik. Cocok untuk acara formal maupun santai.',
            'price' => 250000.00,
            'stock_quantity' => 15,
            'main_image_url' => 'https://via.placeholder.com/600x400.png?text=Dress+Kawung',
            'size_chart_note' => "All Size Fit to L.\nLD 100cm, P 95cm.",
            'category_id' => $dressWanita->id ?? null // Hubungkan ke kategori Dress Wanita
        ]);

         Product::create([
            'name' => 'Kemeja Batik Anak Ceria',
            'description' => 'Kemeja batik anak lengan pendek motif cerah. Bahan katun nyaman untuk si kecil.',
            'price' => 85000.00,
            'stock_quantity' => 30,
            'main_image_url' => 'https://via.placeholder.com/600x400.png?text=Batik+Anak',
            'size_chart_note' => "Size 2: LD 60cm.\nSize 4: LD 68cm.",
            'category_id' => $batikAnak->id ?? null // Hubungkan ke kategori Batik Anak
        ]);

         Product::create([
            'name' => 'Kain Batik Tulis Halus Motif Klasik',
            'description' => 'Kain batik tulis asli dengan motif klasik yang detail. Ukuran 2.5m x 1.15m.',
            'price' => 750000.00,
            'stock_quantity' => 5,
            'main_image_url' => 'https://via.placeholder.com/600x400.png?text=Kain+Tulis',
            // Size chart note dikosongkan untuk kain
            'category_id' => $kainTulis->id ?? null // Hubungkan ke kategori Kain Tulis
        ]);
    }
}