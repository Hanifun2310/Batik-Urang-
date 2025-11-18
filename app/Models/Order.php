<?php

namespace App\Models; 

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\User;
use App\Models\OrderItem; 

class Order extends Model
{
    use HasFactory;

    // Kolom yang boleh diisi massal
    protected $fillable = [
        'user_id',
        'recipient_name',
        'phone_number',
        'shipping_address',
        'total_amount',
        'payment_method',
        'status',
        'payment_proof_path',
    ];

    /**
     * Relasi: Pesanan ini milik satu User.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class); // Sekarang 'User' dikenali
    }

    /**
     * Relasi: Pesanan ini memiliki banyak Item.
     */
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class); // Sekarang 'OrderItem' dikenali
    }
}