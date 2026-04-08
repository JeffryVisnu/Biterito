<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Order - Biterito Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen" style="font-family: 'Poppins', sans-serif;">

{{-- Navbar --}}
<nav class="bg-gray-900 text-white px-6 py-4 flex items-center justify-between">
    <div class="flex items-center gap-3">
        <span class="text-2xl">🌯</span>
        <span class="font-bold text-lg">Biterito Admin</span>
    </div>
    <a href="/admin/logout" class="text-gray-400 hover:text-white text-sm transition">Logout →</a>
</nav>

<div class="max-w-2xl mx-auto px-4 py-8">

    {{-- Back --}}
    <a href="/admin/dashboard" class="text-gray-500 hover:text-red-600 text-sm mb-6 inline-block">← Kembali ke Dashboard</a>

    {{-- Order Info --}}
    <div class="bg-white rounded-2xl shadow p-6 mb-4">
        <div class="flex justify-between items-start mb-4">
            <div>
                <p class="font-mono text-sm text-red-600 font-bold">{{ $order->order_code }}</p>
                <p class="text-gray-400 text-xs mt-1">{{ $order->created_at->format('d M Y, H:i') }}</p>
            </div>
            <div class="text-right">
                <span class="px-3 py-1 rounded-full text-sm font-semibold
                    {{ $order->payment_status == 'paid' ? 'bg-green-100 text-green-700' : ($order->payment_status == 'failed' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') }}">
                    {{ ucfirst($order->payment_status) }}
                </span>
            </div>
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
            @if($order->customer_email)
            <div class="flex justify-between text-sm">
                <span class="text-gray-500">Email</span>
                <span class="font-semibold">{{ $order->customer_email }}</span>
            </div>
            @endif
            <div class="flex justify-between text-sm">
                <span class="text-gray-500">Alamat</span>
                <span class="font-semibold text-right max-w-xs">{{ $order->delivery_address }}</span>
            </div>
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

    {{-- Update Status --}}
    <div class="bg-white rounded-2xl shadow p-6">
        <h3 class="font-bold text-gray-700 mb-4">🔄 Update Status Order</h3>
        <form method="POST" action="/admin/order/{{ $order->id }}/status">
            @csrf
            <select name="order_status" class="w-full border border-gray-300 rounded-xl px-4 py-3 mb-4 focus:outline-none focus:ring-2 focus:ring-red-400">
                <option value="waiting" {{ $order->order_status == 'waiting' ? 'selected' : '' }}>⏳ Waiting</option>
                <option value="process" {{ $order->order_status == 'process' ? 'selected' : '' }}>🔧 Process</option>
                <option value="ready" {{ $order->order_status == 'ready' ? 'selected' : '' }}>✅ Ready</option>
                <option value="delivered" {{ $order->order_status == 'delivered' ? 'selected' : '' }}>🚚 Delivered</option>
            </select>
            <button type="submit" class="w-full bg-gray-900 text-white py-3 rounded-xl font-semibold hover:bg-gray-700 transition">
                Update Status
            </button>
        </form>
    </div>

</div>

</body>
</html>