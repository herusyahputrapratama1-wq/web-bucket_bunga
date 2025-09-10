<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order; // <-- Jangan lupa import Order
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Menampilkan daftar semua pesanan.
     */
    public function index(Request $request)
    {
        // 1. Hitung jumlah pesanan untuk setiap status
        $statusCounts = Order::select('status', DB::raw('count(*) as total'))
                             ->groupBy('status')
                             ->pluck('total', 'status');
    
        // 2. Mulai query builder
        $query = Order::latest();
    
        // 3. Filter berdasarkan status jika ada di URL (?status=pending)
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }
    
        // 4. Ambil data dengan paginasi
        $orders = $query->paginate(15);
        
        // 5. Kirim data pesanan dan jumlah status ke view
        return view('admin.orders.index', compact('orders', 'statusCounts'));
    }
    /**
     * Menampilkan detail satu pesanan beserta item-itemnya.
     */
    public function show(Order $order)
    {
        // Memuat relasi 'items' dan 'product' agar bisa diakses di view
        $order->load('items.product'); 
        
        return view('admin.orders.show', compact('order'));
    }
public function updateStatus(Request $request, Order $order)
{
    // Validasi input
    $request->validate([
        'status' => 'required|in:pending,processing,shipped,completed,cancelled',
    ]);

    // Update status di database
    $order->status = $request->status;
    $order->save();

    // Kembali ke halaman detail dengan pesan sukses
    return redirect()->route('admin.orders.show', $order->id)->with('success', 'Status pesanan berhasil diperbarui.');
}
}