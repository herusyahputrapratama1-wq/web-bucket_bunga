<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Pengguna') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gradient-to-br from-purple-50 to-rose-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white rounded-lg shadow-xl p-8 mb-10 text-center relative overflow-hidden">
                <div class="absolute inset-0 bg-cover bg-center opacity-20"
                    style="background-image: url('https://images.unsplash.com/photo-1544061555-e41a3c773a4b?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D');">
                </div>
                <div class="relative z-10">
                    <h3 class="text-4xl font-extrabold text-gray-900 mb-2">Halo, {{ $user->name }}!</h3>
                    <p class="text-lg text-gray-700 max-w-2xl mx-auto">
                        Selamat datang di Toko Bunga Sejahtera. Temukan keindahan dan keceriaan dalam setiap pilihan
                        bunga kami.
                    </p>
                    <a href="{{ route('home') }}"
                        class="mt-6 inline-flex items-center px-8 py-3 border border-transparent text-base font-medium rounded-full shadow-sm text-white bg-rose-600 hover:bg-rose-700 transition duration-300 ease-in-out">
                        Mulai Belanja Sekarang
                        <svg class="ml-3 -mr-1 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>
            </div>

            <div class="mb-12">
                <h3 class="text-3xl font-extrabold text-gray-900 mb-8 text-center">
                    Buket Bunga Pilihan untuk Anda
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                    @forelse ($featuredProducts as $product)
                    <div
                        class="bg-white rounded-xl shadow-lg hover:shadow-2xl transition duration-300 ease-in-out overflow-hidden flex flex-col transform hover:-translate-y-1">
                        <a href="{{ route('product.detail', $product->slug) }}" class="block">
                            <img class="h-64 w-full object-cover transform hover:scale-105 transition-transform duration-300"
                                src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/400x300/f0f4f8/9ca3af?text=Bunga' }}"
                                alt="{{ $product->name }}">
                        </a>
                        <div class="p-5 flex flex-col flex-grow text-center">
                            <h4 class="font-bold text-xl text-gray-800 mb-2 flex-grow">{{ $product->name }}</h4>
                            <p class="text-2xl font-extrabold text-rose-600 mb-4">Rp
                                {{ number_format($product->price, 0, ',', '.') }}</p>
                            <div class="mt-auto">
                                <form action="{{ route('cart.add') }}" method="POST" class="inline-block">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $product->id }}">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit"
                                        class="w-full bg-gradient-to-r from-rose-500 to-pink-500 hover:from-rose-600 hover:to-pink-600 text-white font-semibold py-3 px-6 rounded-full transition duration-300 ease-in-out shadow-md hover:shadow-lg">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-2"
                                            viewBox="0 0 20 20" fill="currentColor">
                                            <path
                                                d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.5 14 6.333 14H15a1 1 0 000-2H6.333c-.391 0-.641-.149-.91-.29l-1.155-1.156kT3a1 1 0 00-.7-.205.997.997 0 00-.01.042L1.05 4.72C.668 4.07.69 3.29.986 2.68zM7 18a2 2 0 11-4 0 2 2 0 014 0zm8 0a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                        Tambah ke Keranjang
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @empty
                    <p class="col-span-full text-center text-gray-600 text-xl py-8">Belum ada produk unggulan saat ini.
                    </p>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</x-app-layout>