<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
        $table->id(); // ID Pesanan 

        // Info Pembeli
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Terhubung ke tabel users

        // Info Alamat (Snapshot saat checkout)
        $table->string('recipient_name'); // Nama penerima
        $table->string('phone_number');   // No. HP penerima
        $table->text('shipping_address'); // Alamat lengkap penerima

        // Info Pembayaran
        $table->decimal('total_amount', 12, 2); // Total harga pesanan
        $table->string('payment_method')->default('Transfer Bank Manual'); // Metode pembayaran

        // Info Status Pesanan
        $table->string('status')->default('pending'); // pending, processing, shipped, completed, cancelled

        $table->timestamps(); // waktu pemesanan
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
