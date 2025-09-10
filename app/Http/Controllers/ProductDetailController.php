<?php

// app/Http/Controllers/ProductDetailController.php
namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductDetailController extends Controller
{
    public function show(Product $product)
    {
        // Memuat relasi reviews beserta data user yang memberi review
        $product->load('reviews.user');
        
        return view('product-detail', compact('product'));
    }
}