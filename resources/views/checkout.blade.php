@extends('layouts.public')

@section('content')
<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <h1 class="text-3xl font-extrabold text-gray-900 mb-8 text-center">Checkout</h1>
        <div class="bg-white p-8 rounded-lg shadow-lg">
            <form action="{{ route('checkout.store') }}" method="POST">
                @csrf
                <h2 class="text-xl font-bold mb-6">Detail Pengiriman</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="customer_name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                        <input type="text" name="customer_name" id="customer_name" value="{{ $user->name }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                    </div>
                    <div>
                        <label for="customer_phone" class="block text-sm font-medium text-gray-700">Nomor
                            Telepon</label>
                        <input type="text" name="customer_phone" id="customer_phone"
                            value="{{ old('customer_phone', $user->phone) }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                    </div>
                </div>

                <div class="mt-6">
                    <label for="street_address" class="block text-sm font-medium text-gray-700">Alamat Lengkap (Jalan,
                        No. Rumah)</label>
                    <textarea name="shipping_address" id="street_address" rows="3"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                        required>{{ old('shipping_address', $user->street_address) }}</textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                    <div>
                        <label for="city" class="block text-sm font-medium text-gray-700">Kota</label>
                        <input type="text" name="city" id="city" value="{{ old('city', $user->city) }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                    </div>
                    <div>
                        <label for="postal_code" class="block text-sm font-medium text-gray-700">Kode Pos</label>
                        <input type="text" name="postal_code" id="postal_code"
                            value="{{ old('postal_code', $user->postal_code) }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                    </div>
                </div>

                <hr class="my-8">

                <h2 class="text-xl font-bold mb-4">Jasa Pengiriman</h2>
                <div>
                    <select name="shipping_service" class="block w-full mt-1 rounded-md border-gray-300 shadow-sm"
                        required>
                        <option value="">Pilih Jasa Pengiriman</option>
                        <option value="JNE">JNE</option>
                        <option value="J&T Express">J&T Express</option>
                        <option value="SiCepat">SiCepat</option>
                        <option value="GoSend">GoSend</option>
                    </select>
                </div>

                <div class="mt-8 border-t pt-6">
                    <button type="submit"
                        class="w-full bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-4 rounded-lg text-lg">
                        Buat Pesanan & Lanjutkan Pembayaran
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection