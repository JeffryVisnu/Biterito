<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Order - Biterito Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Poppins', sans-serif; }
        .alert-success {
            background: #dcfce7;
            border: 1px solid #86efac;
            color: #15803d;
            padding: 0.75rem 1rem;
            border-radius: 0.75rem;
            margin-bottom: 1rem;
            font-size: 0.875rem;
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen">

{{-- Navbar --}}
<nav class="bg-gray-900 text-white px-6 py-4 flex items-center justify-between">
    <a href="/admin/dashboard" class="flex items-center gap-3 hover:opacity-80 transition">
        <span class="text-2xl">🌯</span>
        <span class="font-bold text-lg">Biterito Admin</span>
    </a>
    <form method="POST" action="/admin/logout" style="display:inline;">
        @csrf
        <button type="submit" class="text-gray-400 hover:text-white text-sm transition" style="background:none;border:none;cursor:pointer;">Logout →</button>
    </form>
</nav>

<div class="max-w-2xl mx-auto px-4 py-8">

    {{-- Back --}}
    <a href="/admin/dashboard" class="text-gray-500 hover:text-red-600 text-sm mb-6 inline-block">← Kembali ke Dashboard</a>

    @if(session('success'))
    <div class="alert-success">✅ {{ session('success') }}</div>
    @endif

    {{-- Order Info --}}
    <div class="bg-white rounded-2xl shadow p-6 mb-4">
        <div class="flex justify-between items-start mb-4">
            <div>
                <p class="font-mono text-sm text-red-600 font-bold">{{ $order->order_code }}</p>
                <p class="text-gray-400 text-xs mt-1">{{ $order->created_at->format('d M Y, H:i') }}</p>
            </div>
            <div class="text-right">
                <span class="px-3 py-1 rounded-full text-sm font-semibold
                    {{ $order->payment_status == 'paid' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                    {{ $order->payment_status === 'unchecked' ? 'Unchecked' : 'Paid' }}
                </span>
            </div>
        </div>

        {{-- Update Payment Status --}}
        <div class="border-t pt-4 mb-2">
            <h3 class="font-bold text-gray-700 mb-3">💳 Status Pembayaran</h3>
            <form method="POST" action="/admin/order/{{ $order->id }}/payment-status" class="flex items-center gap-3 flex-wrap">
                @csrf
                <select name="payment_status" class="border border-gray-300 rounded-lg px-3 py-2 text-sm text-gray-700 focus:outline-none focus:border-indigo-400">
                    <option value="unchecked" {{ $order->payment_status == 'unchecked' ? 'selected' : '' }}>Unchecked</option>
                    <option value="paid"      {{ $order->payment_status == 'paid'      ? 'selected' : '' }}>Paid</option>
                </select>
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white text-sm font-semibold px-4 py-2 rounded-lg transition">
                    Simpan
                </button>
            </form>
        </div>

        {{-- Customer Info --}}
        <div class="border-t pt-4 space-y-2">
            <h3 class="font-bold text-gray-700 mb-2">👤 Data Pelanggan</h3>
            <div class="flex justify-between text-sm">
                <span class="text-gray-500">Nama</span>
                <span class="font-semibold">{{ $order->customer_name }}</span>
            </div>
            <div class="flex justify-between text-sm">
                <span class="text-gray-500">WhatsApp</span>
                <a href="https://wa.me/{{ $order->customer_phone }}" target="_blank" class="font-semibold text-green-600">{{ $order->customer_phone }}</a>
            </div>
            <div class="flex justify-between text-sm">
                <span class="text-gray-500">Alamat</span>
                <span class="font-semibold text-right max-w-xs">{{ $order->delivery_address }}</span>
            </div>
            @if($order->delivery_session)
            <div class="flex justify-between text-sm">
                <span class="text-gray-500">Sesi Pengiriman</span>
                <span class="font-semibold">
                    {{ $order->delivery_session === 'sesi1' ? 'Sesi 1 (10:00–12:00)' : 'Sesi 2 (15:00–17:00)' }}
                    &nbsp;· {{ $order->delivery_date ?? 'Minggu, 10 Mei 2026' }}
                </span>
            </div>
            @endif
        </div>
    </div>

    {{-- Order Items --}}
    <div class="bg-white rounded-2xl shadow p-6 mb-4">
        <h3 class="font-bold text-gray-700 mb-4">🌯 Item Pesanan</h3>
        <div class="space-y-3">
            @foreach($order->items as $item)
            <div class="flex justify-between items-start text-sm border-b pb-3">
                <div>
                    <p class="font-semibold text-gray-800">{{ $item->product->name }}</p>
                    <p class="text-gray-400">x{{ $item->quantity }}</p>
                    @if($item->notes)
                    <p class="text-yellow-600 text-xs mt-1">📝 {{ $item->notes }}</p>
                    @endif
                </div>
                <span class="font-bold text-gray-800">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</span>
            </div>
            @endforeach
        </div>
        <div class="flex justify-between font-bold text-lg mt-4">
            <span>Total</span>
            <span class="text-red-600">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
        </div>
    </div>

    {{-- Bukti Pembayaran --}}
    <div class="bg-white rounded-2xl shadow p-6">
        <h3 class="font-bold text-gray-700 mb-4">📎 Bukti Pembayaran</h3>
        @if($order->payment_proof)
            @php
                $proofUrl = str_starts_with($order->payment_proof, 'http')
                    ? $order->payment_proof
                    : asset('storage/' . $order->payment_proof);
                $isPdf = str_contains(strtolower($proofUrl), '.pdf');
            @endphp
            @if($isPdf)
            <div class="flex items-center gap-3">
                <a href="{{ $proofUrl }}" target="_blank"
                   class="inline-flex items-center gap-2 bg-red-50 hover:bg-red-100 text-red-700 font-semibold text-sm px-4 py-2 rounded-lg border border-red-200 transition">
                    📄 Lihat Bukti Bayar (PDF)
                </a>
            </div>
            @else
            <div class="space-y-3">
                <img src="{{ $proofUrl }}"
                     alt="Bukti Pembayaran"
                     class="rounded-xl border border-gray-200 max-w-full"
                     style="max-height: 400px; object-fit: contain;">
                <div>
                    <a href="{{ $proofUrl }}" target="_blank"
                       class="inline-flex items-center gap-2 bg-blue-50 hover:bg-blue-100 text-blue-700 font-semibold text-sm px-4 py-2 rounded-lg border border-blue-200 transition">
                        🔍 Lihat Bukti Bayar (Ukuran Penuh)
                    </a>
                </div>
            </div>
            @endif
        @else
        <p class="text-gray-400 text-sm">Belum ada bukti pembayaran yang diunggah.</p>
        @endif
    </div>

</div>

</body>
</html>
