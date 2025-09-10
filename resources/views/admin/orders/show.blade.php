<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Pesanan #{{ $order->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-3 gap-8">

            <div class="md:col-span-2">
                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-bold mb-4">Item Pesanan</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="py-2 px-4 text-left">Produk</th>
                                    <th class="py-2 px-4 text-center">Jumlah</th>
                                    <th class="py-2 px-4 text-right">Harga</th>
                                    <th class="py-2 px-4 text-right">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->items as $item)
                                <tr>
                                    <td class="py-2 px-4 font-medium">{{ $item->product->name }}</td>
                                    <td class="py-2 px-4 text-center">{{ $item->quantity }}</td>
                                    <td class="py-2 px-4 text-right">Rp {{ number_format($item->price) }}</td>
                                    <td class="py-2 px-4 text-right">Rp
                                        {{ number_format($item->price * $item->quantity) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="py-4 px-4 text-right font-bold border-t-2">Total Pesanan:
                                    </td>
                                    <td class="py-4 px-4 text-right font-bold text-lg border-t-2">Rp
                                        {{ number_format($order->total_amount) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <div class="md:col-span-1">
                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-bold mb-4">Informasi & Status</h3>

                    @if(session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                        <p>{{ session('success') }}</p>
                    </div>
                    @endif

                    <p><strong>Nama:</strong><br>{{ $order->customer_name }}</p>
                    <p class="mt-2"><strong>Email:</strong><br>{{ $order->customer_email }}</p>
                    <p class="mt-2"><strong>Telepon:</strong><br>{{ $order->customer_phone }}</p>
                    <p class="mt-4"><strong>Alamat Pengiriman:</strong><br>{{ nl2br(e($order->shipping_address)) }}
                    <p class="mt-4"><strong>Alamat Pengiriman:</strong><br>{{ $order->shipping_address }}</p>

                    <hr class="my-4">
                    <p><strong>Jasa Pengiriman:</strong><br>{{ $order->shipping_service }}</p>
                    <p class="mt-2"><strong>Nomor Resi:</strong><br><span
                            class="font-mono bg-gray-100 p-1 rounded">{{ $order->shipping_resi }}</span></p>
                    </p>

                    <hr class="my-6">

                    <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
                        @csrf
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2"><strong>Update Status
                                Pesanan</strong></label>
                        <select id="status" name="status"
                            class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="pending" @selected($order->status == 'pending')>Pending</option>
                            <option value="processing" @selected($order->status == 'processing')>Processing</option>
                            <option value="shipped" @selected($order->status == 'shipped')>Shipped</option>
                            <option value="completed" @selected($order->status == 'completed')>Completed</option>
                            <option value="cancelled" @selected($order->status == 'cancelled')>Cancelled</option>
                        </select>
                        <button type="submit"
                            class="mt-4 w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                            Update Status
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>