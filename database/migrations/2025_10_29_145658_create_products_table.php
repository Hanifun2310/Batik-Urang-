<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
Schema::create('products', function (Blueprint $table) {
        $table->uuid('id')->primary(); // Kolom ID menggunakan UUID

        $table->string('name'); // Nama produk
        $table->text('description')->nullable(); // Deskripsi 
        $table->decimal('price', 10, 2); // 
        $table->integer('stock_quantity')->default(0); // Stok 
        $table->string('main_image_url')->nullable(); // URL gambar
        $table->text('size_chart_note')->nullable(); // Info ukuran

        // Kolom Foreign Key untuk Kategori (UUID)
        $table->uuid('category_id')->nullable(); // Menggunakan UUID
        $table->foreign('category_id')
              ->references('id')->on('categories') // Menghubungkan ke tabel 'categories'
              ->nullOnDelete(); // Jika kategori dihapus, kolom ini jadi NULL

        $table->timestamps(); // Kolom created_at & updated_at
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
