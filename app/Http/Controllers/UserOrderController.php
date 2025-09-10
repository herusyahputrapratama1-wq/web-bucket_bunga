<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserOrderController extends Controller
{
    /**
     * Menampilkan riwayat pesanan milik pengguna yang sedang login.
     */
    public function index()
    {
        // Ambil ID pengguna yang sedang login
        $userId = Auth::id();

        // Ambil semua pesanan milik pengguna tersebut, urutkan dari yang terbaru
        $orders = \App\Models\Order::where('user_id', $userId)
                                   ->latest()
                                   ->paginate(10);

        return view('orders.my-index', compact('orders'));
    }
}