<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    /**
 * Run the migrations.
 */
public function up(): void
{
    Schema::create('cart_items', function (Blueprint $table) {
        $table->uuid('id')->primary(); 
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
        $table->uuid('product_id');
        $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        $table->integer('quantity')->default(1); 
        $table->timestamps(); 
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_items');
    }
};
