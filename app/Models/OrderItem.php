<?php

namespace App\Models; // <-- [FIX] Namespace harusnya App\Models

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Order; // <-- [TAMBAH] Impor model Order
use App\Models\Product; // <-- [TAMBAH] Impor model Product

class OrderItem extends Model
{
    use HasFactory;

    // Kolom yang boleh diisi massal
    protected $fillable = [
        'order_id',
        'product_id',
        'product_name',
        'quantity',
        'price_at_purchase',
    ];

    /**
     * Relasi: Item ini milik satu Order.
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class); // Sekarang 'Order' dikenali
    }

    /**
     * Relasi: Item ini merujuk ke satu Product.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class); // Sekarang 'Product' dikenali
    }
}