@extends('layouts.public')

@section('content')
<div class="flex items-center justify-center h-[60vh]">
    <div class="text-center">
        <h1 class="text-4xl font-extrabold text-green-500 mb-4">Terima Kasih!</h1>
        <p class="text-lg text-gray-700">Pesanan Anda telah kami terima dan akan segera diproses.</p>
        <a href="{{ route('home') }}" class="mt-8 inline-block bg-rose-500 text-white font-bold py-3 px-6 rounded-lg">
            Kembali ke Beranda
        </a>
    </div>
</div>
@endsection