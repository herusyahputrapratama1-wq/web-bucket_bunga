@extends('layouts.public')

@section('content')

<main class="max-w-4xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-lg shadow-lg overflow-hidden md:flex">
        <div class="md:w-1/2">
            <img class="h-full w-full object-cover" src="{{ asset('storage/' . $product->image) }}"
                alt="{{ $product->name }}">
        </div>

        <div class="p-8 md:w-1/2 flex flex-col">
            <div>
                <p class="text-sm text-gray-500 font-semibold">{{ $product->category->name }}</p>
                <h1 class="text-3xl font-extrabold text-gray-900 mt-1">{{ $product->name }}</h1>

                <div class="mt-2 flex items-center">
                    <x-star-rating :rating="$product->rating_avg" />
                    <span class="ml-2 text-sm text-gray-500">({{ $product->review_count }} ulasan)</span>
                </div>

                <p class="mt-4 text-3xl font-bold text-rose-500">
                    Rp {{ number_format($product->price, 0, ',', '.') }}
                </p>

                <div class="mt-6">
                    <h2 class="text-lg font-semibold text-gray-800">Deskripsi</h2>
                    <p class="mt-2 text-gray-600">
                        {{ $product->description ?? 'Tidak ada deskripsi untuk produk ini.' }}
                    </p>
                </div>

                <p class="mt-4 text-sm text-gray-600">
                    Stok: <span class="font-bold">{{ $product->stock }}</span>
                </p>
            </div>

            <div class="mt-8 flex-grow flex items-end">
                <form action="{{ route('cart.add') }}" method="POST" class="w-full">
                    @csrf
                    <input type="hidden" name="id" value="{{ $product->id }}">
                    <div class="flex items-center mb-4">
                        <label for="quantity" class="mr-4 font-semibold">Jumlah:</label>
                        <input type="number" name="quantity" id="quantity" value="1" min="1" max="{{ $product->stock }}"
                            class="w-20 rounded-md border-gray-300 shadow-sm text-center">
                    </div>
                    <button type="submit"
                        class="w-full bg-rose-500 hover:bg-rose-600 text-white text-center font-bold py-3 px-4 rounded-lg text-lg">
                        Tambahkan ke Keranjang
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="mt-12">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Ulasan Pelanggan</h2>
        <div class="space-y-8">
            @forelse ($product->reviews as $review)
            <div class="flex space-x-4">
                <div class="flex-shrink-0">
                    <img class="h-10 w-10 rounded-full"
                        src="https://ui-avatars.com/api/?name={{ urlencode($review->user->name) }}&color=7F9CF5&background=EBF4FF"
                        alt="{{ $review->user->name }}">
                </div>
                <div>
                    <div class="flex items-center">
                        <p class="font-semibold">{{ $review->user->name }}</p>
                        <p class="text-sm text-gray-500 ml-2">{{ $review->created_at->diffForHumans() }}</p>
                    </div>
                    <x-star-rating :rating="$review->rating" :size="4" />
                    <p class="mt-2 text-gray-600">{{ $review->comment }}</p>
                </div>
            </div>
            @empty
            <div class="bg-white p-6 rounded-lg shadow-sm">
                <p class="text-gray-500">Belum ada ulasan untuk produk ini.</p>
            </div>
            @endforelse
        </div>
    </div>
</main>

@endsection