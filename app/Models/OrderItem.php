<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    // Izinkan pengisian massal untuk semua kolom
    protected $guarded = ['id'];

    /**
     * Mendefinisikan relasi bahwa satu OrderItem dimiliki oleh satu Product.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}