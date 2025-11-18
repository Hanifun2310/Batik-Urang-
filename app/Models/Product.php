<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // Impor BelongsTo

class Product extends Model
{
    use HasFactory;

    // Kolom yang boleh diisi massal
    protected $fillable = [
        'name',
        'description',
        'price',
        'stock_quantity',
        'main_image_url',
        'size_chart_note',
        'category_id', // Jangan lupa tambahkan category_id
    ];

    // Definisikan relasi ke Category (opsional tapi bagus)
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}