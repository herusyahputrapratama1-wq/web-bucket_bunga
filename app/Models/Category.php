<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $guarded = ['id']; // Memperbolehkan semua kolom diisi

    // Satu Kategori memiliki BANYAK Produk
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}