<?php

namespace App\Models; 

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str; 
use App\Models\Order; 
use App\Models\Product; 

class OrderItem extends Model
{
    use HasFactory;

    public $incrementing = false; 
    protected $keyType = 'string'; 


    protected $fillable = [
        'id',
        'order_id',
        'product_id',
        'product_name',
        'quantity',
        'price_at_purchase',
    ];


    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }

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