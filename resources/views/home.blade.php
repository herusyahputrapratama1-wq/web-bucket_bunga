@extends('layouts.public')

@section('content')

<div class="py-12 bg-gradient-to-br from-rose-50 to-purple-50">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        <div class="relative h-[60vh] bg-cover bg-center rounded-xl overflow-hidden mb-12 flex items-center justify-center text-center"
            style="background-image: url('https://images.unsplash.com/photo-1525310072745-f49212b5ac6d?q=80&w=1965&auto=format&fit=crop');">

            <div class="absolute inset-0 bg-black opacity-40"></div>

            <div class="relative z-10 p-8">
                <h1 class="text-5xl lg:text-6xl font-extrabold text-white leading-tight shadow-md">
                    Keindahan Bunga untuk Setiap Momen
                </h1>
                <p class="mt-4 text-xl text-gray-200 max-w-2xl mx-auto">
                    Temukan rangkaian bunga yang sempurna untuk orang terkasih.
                </p>
                <form action="{{ route('home') }}" method="GET" class="mt-8 max-w-lg mx-auto flex gap-2">
                    <input type="text" name="search" placeholder="Contoh: Buket Mawar"
                        class="flex-grow p-4 border border-gray-300 rounded-full shadow-sm focus:outline-none focus:ring-2 focus:ring-rose-400"
                        value="{{ request('search') }}">
                    <button type="submit"
                        class="bg-rose-600 hover:bg-rose-700 text-white font-bold py-3 px-6 rounded-full shadow-md transition duration-300 ease-in-out">
                        Cari
                    </button>
                </form>
            </div>
        </div>

        <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
            <h2 class="text-4xl font-extrabold text-gray-900">
                {{ request('search') ? 'Hasil Pencarian' : 'Semua Produk Kami' }}
            </h2>

            <form action="{{ route('home') }}" method="GET">
                @if (request('search'))
                <input type="hidden" name="search" value="{{ request('search') }}">
                @endif

                <select name="sort" onchange="this.form.submit()"
                    class="rounded-full border-gray-300 shadow-sm focus:border-rose-300 focus:ring focus:ring-rose-200 focus:ring-opacity-50">
                    <option value="latest" @selected(request('sort')=='latest' )>Urutkan: Terbaru</option>
                    <option value="price_asc" @selected(request('sort')=='price_asc' )>Harga: Termurah</option>
                    <option value="price_desc" @selected(request('sort')=='price_desc' )>Harga: Termahal</option>
                </select>
            </form>
        </div>
        @if ($products->isEmpty())
        <div class="text-center py-10">
            <p class="text-2xl text-gray-600 mb-4">Maaf, tidak ada buket yang ditemukan.</p>
            <a href="{{ route('home') }}"
                class="mt-6 inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-full shadow-sm text-white bg-rose-600 hover:bg-rose-700 transition duration-300 ease-in-out">
                Lihat Semua Produk
            </a>
        </div>
        @else
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
            @foreach ($products as $product)
            <div
                class="bg-white rounded-xl shadow-lg hover:shadow-2xl transition duration-300 ease-in-out overflow-hidden flex flex-col transform hover:-translate-y-1">
                <a href="{{ route('product.detail', $product->slug) }}" class="block">
                    <img class="h-64 w-full object-cover transform hover:scale-105 transition-transform duration-300"
                        src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/400x300' }}"
                        alt="{{ $product->name }}">
                </a>
                <div class="p-5 flex flex-col flex-grow text-center">
                    <h3 class="font-bold text-xl text-gray-800 mb-2 flex-grow">{{ $product->name }}</h3>
                    <p class="text-2xl font-extrabold text-rose-600 mb-4">Rp
                        {{ number_format($product->price, 0, ',', '.') }}</p>
                    <div class="mt-auto flex justify-center gap-2">
                        <a href="{{ route('product.detail', $product->slug) }}"
                            class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-800 font-semibold py-3 px-4 rounded-full transition duration-300 ease-in-out">
                            Detail
                        </a>
                        <form action="{{ route('cart.add') }}" method="POST" class="flex-1">
                            @csrf
                            <input type="hidden" name="id" value="{{ $product->id }}">
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit"
                                class="w-full bg-gradient-to-r from-rose-500 to-pink-500 hover:from-rose-600 hover:to-pink-600 text-white font-semibold py-3 px-4 rounded-full transition duration-300 ease-in-out shadow-md hover:shadow-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-1"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path
                                        d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.5 14 6.333 14H15a1 1 0 000-2H6.333c-.391 0-.641-.149-.91-.29l-1.155-1.156a.997.997 0 00-.7-.205L1.05 4.72C.668 4.07.69 3.29.986 2.68zM7 18a2 2 0 11-4 0 2 2 0 014 0zm8 0a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                Keranjang
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-10">
            {{ $products->links() }}
        </div>
        @endif
    </div>
</div>

@endsection