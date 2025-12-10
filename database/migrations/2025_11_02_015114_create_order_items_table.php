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
        $table->uuid('id')->primary(); 
        $table->uuid('order_id');
        $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
        $table->uuid('product_id')->nullable();
        $table->foreign('product_id')->references('id')->on('products')->nullOnDelete(); 
        $table->string('product_name'); 
        $table->integer('quantity'); 
        $table->decimal('price_at_purchase', 10, 2);
        $table->timestamps();
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
