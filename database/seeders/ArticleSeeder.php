<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Article; // <-- Impor model Article
use Illuminate\Support\Str; // <-- Impor Str untuk slug
use Illuminate\Support\Facades\DB; // <-- Impor DB untuk truncate

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Kosongkan tabel
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Article::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Buat data artikel contoh
        Article::create([
            'title' => 'Sejarah Batik Indonesia',
            'slug' => Str::slug('Sejarah Batik Indonesia'),
            'content' => 'Batik adalah seni tradisional yang telah berkembang di Indonesia selama berabad-abad. Teknik pembuatan batik menggunakan lilin (malam) untuk menciptakan pola yang indah pada kain. Proses ini memerlukan keahlian dan kesabaran yang tinggi dari para pengrajin batik. Batik telah diakui oleh UNESCO sebagai Masterpiece of Oral and Intangible Heritage of Humanity pada tahun 2009, menjadikannya warisan budaya dunia yang berharga.',
            'featured_image_url' => 'images/sejarah batik.jpg', // Path relatif di folder public
            'status' => 'published'
        ]);

        Article::create([
            'title' => 'Proses Pembuatan Batik',
            'slug' => Str::slug('Proses Pembuatan Batik'),
            'content' => 'Pembuatan batik melibatkan beberapa tahap yang kompleks. Pertama, kain dipersiapkan dan dibersihkan. Kemudian, desain digambar di atas kain menggunakan canting (alat tradisional) yang diisi dengan lilin panas. Setelah lilin mengering, kain dicelupkan ke dalam pewarna. Lilin melindungi bagian kain dari pewarna, menciptakan pola yang unik. Proses ini diulang untuk warna-warna berbeda hingga menghasilkan karya batik yang indah.',
            'featured_image_url' => 'images/proses pembuatan batik.jpg',
            'status' => 'published'
        ]);

        Article::create([
            'title' => 'Filosofi Motif Batik',
            'slug' => Str::slug('Filosofi Motif Batik'),
            'content' => 'Setiap motif batik memiliki makna dan filosofi yang mendalam. Motif-motif ini sering terinspirasi dari alam, kehidupan sehari-hari, dan kepercayaan spiritual masyarakat Indonesia. Misalnya, motif parang melambangkan kekuatan dan keteguhan, sementara motif kawung melambangkan kesucian. Pemahaman tentang filosofi ini membuat batik bukan hanya sekadar kain indah, tetapi juga pembawa pesan budaya yang kaya.',
            'featured_image_url' => 'images/filosofi batik.jpg',
            'status' => 'published'
        ]);

        Article::create([
            'title' => 'Batik di Era Modern',
            'slug' => Str::slug('Batik di Era Modern'),
            'content' => 'Batik terus berkembang dan beradaptasi dengan zaman modern. Desainer kontemporer menggabungkan motif tradisional dengan gaya modern, menciptakan produk batik yang relevan untuk generasi muda. Dari pakaian hingga aksesori, batik kini hadir dalam berbagai bentuk. Inovasi ini membantu melestarikan warisan budaya sambil tetap menarik bagi konsumen modern yang menghargai keunikan dan keaslian.',
            'featured_image_url' => 'images/product batik moderen.jpg',
            'status' => 'published'
        ]);
    }
}