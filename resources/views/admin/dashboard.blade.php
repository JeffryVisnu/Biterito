<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Biterito</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { box-sizing: border-box; }
        body { background: #f3f4f6; font-family: 'Poppins', sans-serif; margin: 0; min-height: 100vh; }

        /* Navbar */
        .admin-nav {
            background: #111827;
            color: white;
            padding: 1rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .admin-nav a { color: inherit; text-decoration: none; }
        .admin-nav-brand { display: flex; align-items: center; gap: 0.6rem; font-weight: 700; font-size: 1.05rem; }
        .admin-nav-brand:hover { opacity: 0.8; }
        .admin-nav-logout { color: #9ca3af; font-size: 0.875rem; }
        .admin-nav-logout:hover { color: white; }

        /* Container */
        .admin-container { max-width: 72rem; margin: 0 auto; padding: 2rem 1rem; }

        /* Stats */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
            margin-bottom: 2rem;
        }
        @media (min-width: 640px) {
            .stats-grid { grid-template-columns: repeat(4, 1fr); }
        }
        .stat-card {
            background: white;
            border-radius: 1rem;
            box-shadow: 0 1px 4px rgba(0,0,0,0.08);
            padding: 1rem;
            text-align: center;
        }
        .stat-number { font-size: 1.75rem; font-weight: 800; margin: 0 0 0.2rem; }
        .stat-label { color: #6b7280; font-size: 0.8rem; margin: 0; }

        /* Card */
        .admin-card {
            background: white;
            border-radius: 1rem;
            box-shadow: 0 1px 4px rgba(0,0,0,0.08);
            padding: 1.5rem;
        }
        .admin-card-title {
            font-weight: 700;
            color: #1f2937;
            font-size: 1rem;
            margin: 0 0 1rem;
        }

        /* Filter tabs */
        .filter-bar {
            display: flex;
            gap: 0.4rem;
            flex-wrap: wrap;
            margin-bottom: 1.25rem;
        }
        .filter-tab {
            padding: 0.35rem 0.85rem;
            border-radius: 9999px;
            font-size: 0.78rem;
            font-weight: 600;
            text-decoration: none;
            border: 1.5px solid transparent;
            transition: all 0.15s;
        }
        .filter-tab.active-all       { background: #dc2626; color: white; }
        .filter-tab.active-pending   { background: #f59e0b; color: white; }
        .filter-tab.active-paid      { background: #16a34a; color: white; }
        .filter-tab.active-waiting   { background: #d97706; color: white; }
        .filter-tab.active-process   { background: #2563eb; color: white; }
        .filter-tab.active-ready     { background: #7c3aed; color: white; }
        .filter-tab.active-delivered { background: #374151; color: white; }
        .filter-tab.active-failed    { background: #dc2626; color: white; }
        .filter-tab.inactive { background: #f3f4f6; color: #6b7280; border-color: #e5e7eb; }
        .filter-tab.inactive:hover { background: #e5e7eb; }

        /* Badge */
        .badge {
            display: inline-block;
            padding: 0.2rem 0.55rem;
            border-radius: 9999px;
            font-size: 0.7rem;
            font-weight: 600;
        }
        .badge-pending   { background: #fef3c7; color: #92400e; }
        .badge-paid      { background: #dcfce7; color: #15803d; }
        .badge-failed    { background: #fee2e2; color: #991b1b; }
        .badge-waiting   { background: #fef9c3; color: #854d0e; }
        .badge-process   { background: #dbeafe; color: #1d4ed8; }
        .badge-ready     { background: #ede9fe; color: #6d28d9; }
        .badge-delivered { background: #f3f4f6; color: #374151; }

        /* Status select inline */
        .status-select {
            border: 1.5px solid #e5e7eb;
            border-radius: 0.5rem;
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
            font-family: 'Poppins', sans-serif;
            color: #374151;
            background: white;
            cursor: pointer;
            outline: none;
        }
        .status-select:focus { border-color: #6366f1; }

        /* Table */
        .orders-table { width: 100%; border-collapse: collapse; font-size: 0.85rem; }
        .orders-table th {
            text-align: left;
            color: #6b7280;
            font-weight: 600;
            font-size: 0.78rem;
            padding-bottom: 0.75rem;
            border-bottom: 1px solid #e5e7eb;
        }
        .orders-table td { padding: 0.75rem 0; border-bottom: 1px solid #f3f4f6; vertical-align: middle; }
        .orders-table tr:last-child td { border-bottom: none; }
        .orders-table tr:hover td { background: #fafafa; }
        .order-code { font-family: monospace; font-size: 0.75rem; color: #dc2626; font-weight: 600; }
        .customer-name { font-weight: 600; color: #1f2937; font-size: 0.85rem; }
        .customer-phone { color: #9ca3af; font-size: 0.75rem; margin-top: 0.1rem; }
        .detail-link { color: #dc2626; font-size: 0.78rem; font-weight: 600; text-decoration: none; }
        .detail-link:hover { text-decoration: underline; }

        /* Mobile cards */
        .mobile-order-card {
            border: 1px solid #e5e7eb;
            border-radius: 0.75rem;
            padding: 1rem;
            margin-bottom: 0.75rem;
        }
        .mobile-order-card-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 0.5rem;
        }
        .mobile-order-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 0.75rem;
            flex-wrap: wrap;
            gap: 0.5rem;
        }
        .mobile-price { font-weight: 700; color: #dc2626; }

        /* Success alert */
        .alert-success {
            background: #dcfce7;
            border: 1px solid #86efac;
            color: #15803d;
            padding: 0.75rem 1rem;
            border-radius: 0.75rem;
            margin-bottom: 1rem;
            font-size: 0.875rem;
        }

        /* Desktop/mobile visibility */
        .desktop-only { display: none; }
        .mobile-only { display: block; }
        @media (min-width: 768px) {
            .desktop-only { display: block; }
            .mobile-only { display: none; }
        }
    </style>
</head>
<body>

{{-- Navbar --}}
<nav class="admin-nav">
    <a href="/admin/dashboard" class="admin-nav-brand">
        <span>🌯</span>
        <span>Biterito Admin</span>
    </a>
    <a href="/admin/logout" class="admin-nav-logout">Logout →</a>
</nav>

<div class="admin-container">

    @if(session('success'))
    <div class="alert-success">✅ {{ session('success') }}</div>
    @endif

    {{-- Stats Row 1 --}}
    <div class="stats-grid" style="margin-bottom: 1rem;">
        <div class="stat-card">
            <p class="stat-number" style="color: #dc2626;">{{ $totalOrders }}</p>
            <p class="stat-label">Total Order</p>
        </div>
        <div class="stat-card">
            <p class="stat-number" style="color: #16a34a;">{{ $paidOrders }}</p>
            <p class="stat-label">Paid</p>
        </div>
        <div class="stat-card">
            <p class="stat-number" style="color: #f59e0b;">{{ $pendingOrders }}</p>
            <p class="stat-label">Pending</p>
        </div>
        <div class="stat-card" style="grid-column: span 1;">
            <p class="stat-label" style="margin: 0 0 0.2rem;">Total Revenue</p>
            <p style="font-size: 1.1rem; font-weight: 800; color: #2563eb; margin: 0; word-break: break-all;">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
        </div>
    </div>

    {{-- Stats Row 2: Order Status --}}
    <div class="stats-grid" style="margin-bottom: 2rem;">
        <div class="stat-card">
            <p class="stat-number" style="color: #d97706;">{{ $waitingOrders }}</p>
            <p class="stat-label">⏳ Waiting</p>
        </div>
        <div class="stat-card">
            <p class="stat-number" style="color: #2563eb;">{{ $processOrders }}</p>
            <p class="stat-label">🔧 Process</p>
        </div>
        <div class="stat-card">
            <p class="stat-number" style="color: #7c3aed;">{{ $readyOrders }}</p>
            <p class="stat-label">✅ Ready</p>
        </div>
        <div class="stat-card">
            <p class="stat-number" style="color: #374151;">{{ $deliveredOrders }}</p>
            <p class="stat-label">🚚 Delivered</p>
        </div>
    </div>

    {{-- Order List --}}
    <div class="admin-card">
        <h2 class="admin-card-title">📋 Daftar Order</h2>

        {{-- Filter Tabs --}}
        <div class="filter-bar">
            <a href="/admin/dashboard"
               class="filter-tab {{ !request('status') ? 'active-all' : 'inactive' }}">Semua</a>
            <a href="/admin/dashboard?status=pending"
               class="filter-tab {{ request('status') == 'pending' ? 'active-pending' : 'inactive' }}">Pending</a>
            <a href="/admin/dashboard?status=paid"
               class="filter-tab {{ request('status') == 'paid' ? 'active-paid' : 'inactive' }}">Paid</a>
            <a href="/admin/dashboard?status=failed"
               class="filter-tab {{ request('status') == 'failed' ? 'active-failed' : 'inactive' }}">❌ Failed</a>
            <a href="/admin/dashboard?status=waiting"
               class="filter-tab {{ request('status') == 'waiting' ? 'active-waiting' : 'inactive' }}">⏳ Waiting</a>
            <a href="/admin/dashboard?status=process"
               class="filter-tab {{ request('status') == 'process' ? 'active-process' : 'inactive' }}">🔧 Process</a>
            <a href="/admin/dashboard?status=ready"
               class="filter-tab {{ request('status') == 'ready' ? 'active-ready' : 'inactive' }}">✅ Ready</a>
            <a href="/admin/dashboard?status=delivered"
               class="filter-tab {{ request('status') == 'delivered' ? 'active-delivered' : 'inactive' }}">🚚 Delivered</a>
        </div>

        {{-- Desktop Table --}}
        <div class="desktop-only">
            <div style="overflow-x: auto;">
                <table class="orders-table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Pelanggan</th>
                            <th>Total</th>
                            <th>Status Bayar</th>
                            <th>Status Order</th>
                            <th>Waktu</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                        <tr>
                            <td><span class="order-code">{{ $order->order_code }}</span></td>
                            <td>
                                <p class="customer-name">{{ $order->customer_name }}</p>
                                <p class="customer-phone">{{ $order->customer_phone }}</p>
                            </td>
                            <td style="font-weight: 600;">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                            <td>
                                <span class="badge badge-{{ $order->payment_status }}">
                                    {{ ucfirst($order->payment_status) }}
                                </span>
                            </td>
                            <td>
                                {{-- Inline status update --}}
                                <form method="POST" action="/admin/order/{{ $order->id }}/status">
                                    @csrf
                                    <select name="order_status" class="status-select" onchange="this.form.submit()">
                                        <option value="waiting"   {{ $order->order_status == 'waiting'   ? 'selected' : '' }}>⏳ Waiting</option>
                                        <option value="process"   {{ $order->order_status == 'process'   ? 'selected' : '' }}>🔧 Process</option>
                                        <option value="ready"     {{ $order->order_status == 'ready'     ? 'selected' : '' }}>✅ Ready</option>
                                        <option value="delivered" {{ $order->order_status == 'delivered' ? 'selected' : '' }}>🚚 Delivered</option>
                                    </select>
                                </form>
                            </td>
                            <td style="color: #9ca3af; font-size: 0.75rem;">{{ $order->created_at->format('d M, H:i') }}</td>
                            <td>
                                <a href="/admin/order/{{ $order->id }}" class="detail-link">Detail</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" style="text-align: center; color: #9ca3af; padding: 2rem 0;">Belum ada order</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination Desktop --}}
        @if($orders->lastPage() > 1)
        <div class="desktop-only" style="margin-top: 1.25rem; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 0.5rem;">
            <p style="font-size: 0.8rem; color: #6b7280; margin: 0;">
                Menampilkan {{ $orders->firstItem() }}–{{ $orders->lastItem() }} dari {{ $orders->total() }} order
            </p>
            @include('admin.partials.pagination', ['paginator' => $orders])
        </div>
        @endif

        {{-- Mobile Cards --}}
        <div class="mobile-only">
            @forelse($orders as $order)
            <div class="mobile-order-card">
                <div class="mobile-order-card-header">
                    <span class="order-code">{{ $order->order_code }}</span>
                    <span class="badge badge-{{ $order->payment_status }}">{{ ucfirst($order->payment_status) }}</span>
                </div>
                <p class="customer-name">{{ $order->customer_name }}</p>
                <p class="customer-phone">{{ $order->customer_phone }}</p>
                <p style="font-size: 0.75rem; color: #9ca3af; margin: 0.25rem 0 0;">{{ $order->created_at->format('d M Y, H:i') }}</p>

                {{-- Inline status mobile --}}
                <form method="POST" action="/admin/order/{{ $order->id }}/status" style="margin-top: 0.6rem;">
                    @csrf
                    <select name="order_status" class="status-select" onchange="this.form.submit()" style="width: 100%;">
                        <option value="waiting"   {{ $order->order_status == 'waiting'   ? 'selected' : '' }}>⏳ Waiting</option>
                        <option value="process"   {{ $order->order_status == 'process'   ? 'selected' : '' }}>🔧 Process</option>
                        <option value="ready"     {{ $order->order_status == 'ready'     ? 'selected' : '' }}>✅ Ready</option>
                        <option value="delivered" {{ $order->order_status == 'delivered' ? 'selected' : '' }}>🚚 Delivered</option>
                    </select>
                </form>

                <div class="mobile-order-footer">
                    <span class="mobile-price">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                    <a href="/admin/order/{{ $order->id }}" class="detail-link">Detail →</a>
                </div>
            </div>
            @empty
            <p style="text-align: center; color: #9ca3af; padding: 2rem 0;">Belum ada order</p>
            @endforelse

            {{-- Pagination Mobile --}}
            @if($orders->lastPage() > 1)
            <div style="margin-top: 1rem;">
                <p style="font-size: 0.75rem; color: #6b7280; margin: 0 0 0.5rem; text-align: center;">
                    {{ $orders->firstItem() }}–{{ $orders->lastItem() }} dari {{ $orders->total() }} order
                </p>
                @include('admin.partials.pagination', ['paginator' => $orders])
            </div>
            @endif
        </div>
    </div>
</div>

</body>
</html>
