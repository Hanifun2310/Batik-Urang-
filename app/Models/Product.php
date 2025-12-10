<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; 
use Illuminate\Support\Str; 

class Product extends Model
{
    use HasFactory;

    public $incrementing = false; 
    protected $keyType = 'string'; 

    protected $fillable = [
        'id',
        'name',
        'description',
        'price',
        'stock_quantity',
        'main_image_url',
        'size_chart_note',
        'category_id', 
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

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}