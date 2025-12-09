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
    Schema::create('order_items', function (Blueprint $table) {
        $table->uuid('id')->primary(); // ID item pesanan menggunakan UUID
        $table->uuid('order_id');
        $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');

        // Menghubungkan ke tabel 'products' (UUID)
        // Kita pakai nullable() dan nullOnDelete() agar jika produk dihapus, data pesanan tetap ada
        $table->uuid('product_id')->nullable();
        $table->foreign('product_id')->references('id')->on('products')->nullOnDelete(); 

        // Info Produk (Snapshot saat checkout)
        $table->string('product_name'); // Simpan nama pro
        $table->integer('quantity'); // Jumlah yang dibeli
        $table->decimal('price_at_purchase', 10, 2); // Harga produk saat dibeli

        $table->timestamps(); // (Tidak wajib, tapi oke)
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
