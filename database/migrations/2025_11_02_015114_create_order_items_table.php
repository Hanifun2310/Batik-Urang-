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
        $table->id(); // ID item pesanan

        // Menghubungkan ke tabel 
        $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');

        // Menghubungkan ke tabel 'products'
        // Kita pakai nullable() dan nullOnDelete() agar jika produk dihapus, data pesanan tetap ada
        $table->foreignId('product_id')->nullable()->constrained('products')->nullOnDelete(); 

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
