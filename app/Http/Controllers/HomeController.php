<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();
    
        // Logika untuk pencarian (search)
        if ($request->has('search') && $request->input('search') != '') {
            $searchTerm = $request->input('search');
            $query->where('name', 'like', '%' . $searchTerm . '%');
        }
    
        // Logika baru untuk pengurutan (sort)
        $sort = $request->input('sort', 'latest'); // Defaultnya 'latest'
    
        switch ($sort) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            default:
                $query->latest(); // 'latest' akan mengurutkan berdasarkan created_at desc
                break;
        }
    
        $products = $query->paginate(12);
    
        return view('home', compact('products'));
    }
}