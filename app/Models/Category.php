<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str; // <-- PENTING: Import class Str

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug']; 
    
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Mutator: Dijalankan setiap kali  mengatur nilai 'name'.
     * 
     */
    protected function setNameAttribute(string $value): void
    {
        // Set kolom 'name'
        $this->attributes['name'] = $value;
        
        // Set kolom 'slug' berdasarkan nilai 'name'
        $this->attributes['slug'] = Str::slug($value);
    }
}