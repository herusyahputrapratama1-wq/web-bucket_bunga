<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Darryldecode\Cart\Facades\CartFacade as Cart;


class CheckoutController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('checkout', compact('user'));
    }

    public function store(Request $request)
    {
        // 1. Validasi
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'shipping_address' => 'required|string',
            'city' => 'required|string',
            'postal_code' => 'required|string',
            'shipping_service' => 'required|string',
        ]);

        // Gabungkan alamat menjadi satu string untuk disimpan
        $fullAddress = $request->shipping_address . ', ' . $request->city . ', ' . $request->postal_code;

        // Buat nomor resi acak otomatis
        $resi = strtoupper($request->shipping_service) . time();

        // 2. Simpan pesanan ke database (HANYA SATU KALI)
        $order = Order::create([
            'user_id' => Auth::id(),
            'customer_name' => $request->customer_name,
            'customer_email' => Auth::user()->email,
            'customer_phone' => $request->customer_phone,
            'shipping_address' => $fullAddress,
            'total_amount' => Cart::getTotal(),
            'status' => 'pending', // Anda bisa ganti jadi 'unpaid' jika pakai Midtrans
            'shipping_service' => $request->shipping_service,
            'shipping_resi' => $resi,
        ]);

        // 3. Simpan setiap item pesanan & kurangi stok
        foreach (Cart::getContent() as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->id,
                'quantity' => $item->quantity,
                'price' => $item->price,
            ]);

            $product = Product::find($item->id);
            if ($product) {
                $product->decrement('stock', $item->quantity);
            }
        }

        // 4. Kosongkan keranjang
        Cart::clear();

        // 5. Redirect ke halaman sukses
        return redirect()->route('checkout.success');
    }

    public function success()
    {
        return view('success');
    }
}