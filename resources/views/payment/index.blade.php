@extends('layouts.app')

@section('content')

<section class="max-w-lg mx-auto px-4 py-10">

    {{-- Header --}}
    <div class="text-center mb-8">
        <h1 class="text-2xl font-bold text-gray-800">💳 Pembayaran</h1>
        <p class="text-gray-500 mt-1">Order <span class="font-semibold text-red-600">{{ $order->order_code }}</span></p>
    </div>

    {{-- Order Summary --}}
    <div class="bg-white rounded-2xl shadow-md p-4 mb-6">
        <h2 class="font-bold text-gray-800 mb-3">📋 Ringkasan Order</h2>
        <div class="space-y-2">
            @foreach($order->items as $item)
            <div class="flex justify-between text-sm text-gray-600">
                <span>{{ $item->product->name }} x{{ $item->quantity }}</span>
                <span>Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</span>
            </div>
            @endforeach
        </div>
        <hr class="my-3">
        <div class="flex justify-between font-bold text-gray-800">
            <span>Total</span>
            <span class="text-red-600">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
        </div>
    </div>

    {{-- Payment Status --}}
    @if($order->payment_status === 'paid')
    <div class="bg-green-50 border border-green-200 rounded-2xl p-6 text-center mb-6">
        <p class="text-5xl mb-3">✅</p>
        <p class="text-green-700 font-bold text-xl">Pembayaran Berhasil!</p>
        <p class="text-green-600 text-sm mt-1">Terima kasih, order kamu sedang diproses.</p>
    </div>
    @else
    {{-- QRIS Payment --}}
    <div class="bg-white rounded-2xl shadow-md p-6 text-center mb-6">
        <p class="font-bold text-gray-800 mb-2">Scan QRIS untuk Membayar</p>

        <button id="pay-button"
            class="w-full bg-red-600 text-white py-4 rounded-2xl font-bold text-lg hover:bg-red-700 transition active:scale-95">
            🔍 Tampilkan QR Code
        </button>

        <p class="text-gray-400 text-xs mt-4">Selesaikan pembayaran sebelum waktu habis</p>
    </div>

    {{-- Info --}}
    <div class="bg-yellow-50 border border-yellow-200 rounded-2xl p-4 text-sm text-yellow-800">
        <p class="font-semibold mb-1">📌 Cara Bayar:</p>
        <ol class="list-decimal list-inside space-y-1">
            <li>Klik tombol "Tampilkan QR Code"</li>
            <li>Scan QR dengan aplikasi e-wallet atau m-banking</li>
            <li>Nominal sudah otomatis terisi</li>
            <li>Konfirmasi pembayaran di aplikasi kamu</li>
        </ol>
    </div>
    @endif

    {{-- Back Button --}}
    <a href="/" class="block text-center mt-6 text-gray-500 hover:text-red-600 transition text-sm">
        ← Kembali ke Menu
    </a>

</section>

@endsection

@push('scripts')
<script src="https://app.sandbox.midtrans.com/snap/snap.js"
    data-client-key="{{ config('midtrans.client_key') }}"></script>

<script>
    @if($order->payment_status !== 'paid')
    const snapToken = "{{ $order->midtrans_snap_token }}";

    document.getElementById('pay-button').addEventListener('click', function() {
        window.snap.pay(snapToken, {
            onSuccess: function(result) {
                window.location.reload();
            },
            onPending: function(result) {
                console.log('pending', result);
            },
            onError: function(result) {
                alert('Pembayaran gagal, silakan coba lagi.');
            },
            onClose: function() {
                console.log('popup ditutup');
            }
        });
    });

    // Polling setiap 5 detik sebagai backup
    const checkInterval = setInterval(async () => {
        const res = await fetch('/payment/check/{{ $order->order_code }}');
        const data = await res.json();
        if (data.status === 'paid') {
            clearInterval(checkInterval);
            window.location.reload();
        }
    }, 5000);
    @endif
</script>
@endpush