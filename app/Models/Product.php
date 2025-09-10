<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    
    protected $guarded = ['id']; // Memperbolehkan semua kolom diisi

    // Satu Produk MILIK SATU Kategori
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function reviews() { return $this->hasMany(Review::class); }
}