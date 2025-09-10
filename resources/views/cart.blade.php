<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja - Toko Bunga</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

    <nav class="bg-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="text-xl font-bold text-rose-500">💐 Toko Bunga</a>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('cart.index') }}" class="relative text-gray-600 hover:text-rose-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <span
                            class="absolute -top-2 -right-2 bg-rose-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">{{ Cart::getTotalQuantity() }}</span>
                    </a>
                    @auth
                    <a href="{{ url('/dashboard') }}" class="text-sm text-gray-700 underline">Dashboard</a>
                    @else
                    <a href="{{ route('login') }}" class="text-sm text-gray-700 underline">Log in</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-4xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-extrabold text-gray-900 mb-8">Keranjang Belanja Anda</h1>

        @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            {{ session('success') }}
        </div>
        @endif

        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            @if(count($cartItems) > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Produk</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Harga</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jumlah</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Subtotal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($cartItems as $item)
                        <tr>
                            <td class="px-6 py-4 flex items-center">
                                <img src="{{ asset('storage/' . $item->attributes->image) }}" alt="{{ $item->name }}"
                                    class="w-16 h-16 object-cover rounded mr-4">
                                <span class="font-medium">{{ $item->name }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">Rp {{ number_format($item->price) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <form action="{{ route('cart.update') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $item->id }}">
                                    <input type="number" name="quantity" value="{{ $item->quantity }}"
                                        class="w-16 text-center border-gray-300 rounded">
                                    <button type="submit"
                                        class="ml-2 text-indigo-600 hover:text-indigo-900 text-xs">Update</button>
                                </form>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">Rp
                                {{ number_format($item->price * $item->quantity) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <form action="{{ route('cart.remove') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $item->id }}">
                                    <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="p-6 border-t border-gray-200 flex justify-between items-center">
                <a href="{{ route('home') }}" class="text-sm text-indigo-600 hover:text-indigo-900 font-semibold">
                    &larr; Kembali Berbelanja
                </a>
                <div class="text-right">
                    <p class="text-2xl font-bold">Total: <span class="text-rose-500">Rp
                            {{ number_format($total) }}</span></p>
                    <a href="{{ route('checkout.index') }}"
                        class="mt-4 inline-block bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">
                        Lanjut ke Checkout
                    </a>
                </div>
            </div>
            @else
            <div class="p-8 text-center">
                <p class="text-gray-500 mb-6">Keranjang belanja Anda kosong.</p>
                <a href="{{ route('home') }}"
                    class="bg-rose-500 hover:bg-rose-600 text-white font-bold py-3 px-6 rounded-lg">
                    Mulai Belanja
                </a>
            </div>
            @endif
        </div>
    </main>
</body>

</html>