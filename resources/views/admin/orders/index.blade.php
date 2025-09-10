<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Pesanan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="border-b border-gray-200 mb-6">
                        <nav class="-mb-px flex space-x-6">
                            @php
                            $statuses = [
                            '' => 'Semua',
                            'pending' => 'Baru',
                            'processing' => 'Diproses',
                            'shipped' => 'Dikirim',
                            'completed' => 'Selesai',
                            'cancelled' => 'Dibatalkan'
                            ];
                            @endphp

                            @foreach ($statuses as $statusCode => $statusName)
                            @php
                            $isActive = (request('status') == $statusCode);
                            $activeClasses = 'border-rose-500 text-rose-600';
                            $inactiveClasses = 'border-transparent text-gray-500 hover:text-gray-700
                            hover:border-gray-300';
                            @endphp
                            <a href="{{ route('admin.orders.index', ['status' => $statusCode]) }}"
                                class="whitespace-nowrap pb-4 px-1 border-b-2 font-medium text-sm {{ $isActive ? $activeClasses : $inactiveClasses }}">
                                {{ $statusName }}
                                <span
                                    class="ml-1 inline-block py-0.5 px-2.5 leading-none text-center whitespace-nowrap align-baseline font-bold {{ $isActive ? 'bg-rose-600 text-white' : 'bg-gray-200 text-gray-600' }} rounded-full">
                                    {{ $statusCode == '' ? $statusCounts->sum() : ($statusCounts[$statusCode] ?? 0) }}
                                </span>
                            </a>
                            @endforeach
                        </nav>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID
                                        Pesanan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama
                                        Pelanggan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal
                                    </th>
                                    <th class="relative px-6 py-3"></th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($orders as $order)
                                <tr>
                                    <td class="px-6 py-4">#{{ $order->id }}</td>
                                    <td class="px-6 py-4">{{ $order->customer_name }}</td>
                                    <td class="px-6 py-4">Rp {{ number_format($order->total_amount) }}</td>
                                    <td class="px-6 py-4">
                                        @php
                                        $statusColor = [
                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                        'processing' => 'bg-blue-100 text-blue-800',
                                        'shipped' => 'bg-indigo-100 text-indigo-800',
                                        'completed' => 'bg-green-100 text-green-800',
                                        'cancelled' => 'bg-red-100 text-red-800',
                                        ][$order->status] ?? 'bg-gray-100 text-gray-800';
                                        @endphp
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusColor }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">{{ $order->created_at->format('d M Y') }}</td>
                                    <td class="px-6 py-4 text-right">
                                        <a href="{{ route('admin.orders.show', $order->id) }}"
                                            class="text-indigo-600 hover:text-indigo-900">Lihat Detail</a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">Tidak ada pesanan dengan status ini.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $orders->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>