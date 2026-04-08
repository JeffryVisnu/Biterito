<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Biterito</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen" style="font-family: 'Poppins', sans-serif;">

{{-- Navbar Admin --}}
<nav class="bg-gray-900 text-white px-6 py-4 flex items-center justify-between">
    <div class="flex items-center gap-3">
        <span class="text-2xl">🌯</span>
        <span class="font-bold text-lg">Biterito Admin</span>
    </div>
    <a href="/admin/logout" class="text-gray-400 hover:text-white text-sm transition">Logout →</a>
</nav>

<div class="max-w-6xl mx-auto px-4 py-8">

    {{-- Stats --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-white rounded-2xl shadow p-4 text-center">
            <p class="text-3xl font-extrabold text-red-600">{{ $totalOrders }}</p>
            <p class="text-gray-500 text-sm mt-1">Total Order</p>
        </div>
        <div class="bg-white rounded-2xl shadow p-4 text-center">
            <p class="text-3xl font-extrabold text-green-600">{{ $paidOrders }}</p>
            <p class="text-gray-500 text-sm mt-1">Sudah Bayar</p>
        </div>
        <div class="bg-white rounded-2xl shadow p-4 text-center">
            <p class="text-3xl font-extrabold text-yellow-500">{{ $pendingOrders }}</p>
            <p class="text-gray-500 text-sm mt-1">Pending</p>
        </div>
        <div class="bg-white rounded-2xl shadow p-4 text-center">
            <p class="text-2xl font-extrabold text-blue-600">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
            <p class="text-gray-500 text-sm mt-1">Total Revenue</p>
        </div>
    </div>

    {{-- Order List --}}
    <div class="bg-white rounded-2xl shadow p-6">
        <h2 class="font-bold text-gray-800 text-lg mb-4">📋 Daftar Order</h2>

        {{-- Filter --}}
        <div class="flex gap-2 mb-4 flex-wrap">
            <a href="/admin/dashboard" class="px-4 py-2 rounded-full text-sm font-semibold {{ !request('status') ? 'bg-red-600 text-white' : 'bg-gray-100 text-gray-600' }}">Semua</a>
            <a href="/admin/dashboard?status=pending" class="px-4 py-2 rounded-full text-sm font-semibold {{ request('status') == 'pending' ? 'bg-yellow-500 text-white' : 'bg-gray-100 text-gray-600' }}">Pending</a>
            <a href="/admin/dashboard?status=paid" class="px-4 py-2 rounded-full text-sm font-semibold {{ request('status') == 'paid' ? 'bg-green-600 text-white' : 'bg-gray-100 text-gray-600' }}">Sudah Bayar</a>
            <a href="/admin/dashboard?status=process" class="px-4 py-2 rounded-full text-sm font-semibold {{ request('status') == 'process' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-600' }}">Diproses</a>
        </div>

        {{-- Table Desktop --}}
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-gray-500 border-b">
                        <th class="pb-3">Order ID</th>
                        <th class="pb-3">Pelanggan</th>
                        <th class="pb-3">Total</th>
                        <th class="pb-3">Status Bayar</th>
                        <th class="pb-3">Status Order</th>
                        <th class="pb-3">Waktu</th>
                        <th class="pb-3">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($orders as $order)
                    <tr class="hover:bg-gray-50">
                        <td class="py-3 font-mono text-xs text-red-600">{{ $order->order_code }}</td>
                        <td class="py-3">
                            <p class="font-semibold">{{ $order->customer_name }}</p>
                            <p class="text-gray-400 text-xs">{{ $order->customer_phone }}</p>
                        </td>
                        <td class="py-3 font-semibold">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                        <td class="py-3">
                            <span class="px-2 py-1 rounded-full text-xs font-semibold
                                {{ $order->payment_status == 'paid' ? 'bg-green-100 text-green-700' : ($order->payment_status == 'failed' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') }}">
                                {{ ucfirst($order->payment_status) }}
                            </span>
                        </td>
                        <td class="py-3">
                            <span class="px-2 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">
                                {{ ucfirst($order->order_status) }}
                            </span>
                        </td>
                        <td class="py-3 text-gray-400 text-xs">{{ $order->created_at->format('d M, H:i') }}</td>
                        <td class="py-3">
                            <a href="/admin/order/{{ $order->id }}" class="text-red-600 hover:underline text-xs font-semibold">Detail</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="py-8 text-center text-gray-400">Belum ada order</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Card Mobile --}}
        <div class="md:hidden space-y-3">
            @forelse($orders as $order)
            <div class="border border-gray-200 rounded-xl p-4">
                <div class="flex justify-between items-start mb-2">
                    <p class="font-mono text-xs text-red-600">{{ $order->order_code }}</p>
                    <span class="px-2 py-1 rounded-full text-xs font-semibold
                        {{ $order->payment_status == 'paid' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                        {{ ucfirst($order->payment_status) }}
                    </span>
                </div>
                <p class="font-semibold text-gray-800">{{ $order->customer_name }}</p>
                <p class="text-gray-400 text-sm">{{ $order->customer_phone }}</p>
                <div class="flex justify-between items-center mt-3">
                    <p class="font-bold text-red-600">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                    <a href="/admin/order/{{ $order->id }}" class="text-red-600 text-sm font-semibold">Detail →</a>
                </div>
            </div>
            @empty
            <p class="text-center text-gray-400 py-8">Belum ada order</p>
            @endforelse
        </div>
    </div>
</div>

</body>
</html>