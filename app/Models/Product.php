<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // Impor BelongsTo
use Illuminate\Support\Str; // Import Str untuk UUID

class Product extends Model
{
    use HasFactory;

    // Konfigurasi UUID
    public $incrementing = false; // Non auto-increment
    protected $keyType = 'string'; // Tipe primary key adalah string

    // Kolom yang boleh diisi massal
    protected $fillable = [
        'id',
        'name',
        'description',
        'price',
        'stock_quantity',
        'main_image_url',
        'size_chart_note',
        'category_id', // Jangan lupa tambahkan category_id
    ];

    // Auto-generate UUID saat create
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    // Definisikan relasi ke Category (opsional tapi bagus)
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}