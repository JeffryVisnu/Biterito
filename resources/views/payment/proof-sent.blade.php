@extends('layouts.app')

@section('content')

<style>
    .success-section {
        max-width: 36rem;
        margin: 0 auto;
        padding: 2.5rem 1rem 3rem;
        text-align: center;
    }
    .success-icon {
        font-size: 5rem;
        margin-bottom: 1rem;
        animation: pop 0.4s ease;
    }
    @keyframes pop {
        0%   { transform: scale(0.5); opacity: 0; }
        80%  { transform: scale(1.1); }
        100% { transform: scale(1);   opacity: 1; }
    }
    .success-title {
        font-size: 1.6rem;
        font-weight: 700;
        color: #15803d;
        font-family: 'Fredoka', sans-serif;
        margin: 0 0 0.5rem;
    }
    .success-subtitle {
        color: #4b7a5a;
        font-size: 0.95rem;
        margin: 0 0 2rem;
        line-height: 1.6;
    }
    .info-card {
        background: white;
        border-radius: 1rem;
        box-shadow: 0 2px 10px rgba(0,0,0,0.07);
        padding: 1.25rem 1.5rem;
        margin-bottom: 1rem;
        border: 1px solid #e4dec4;
        text-align: left;
    }
    .info-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 0.875rem;
        margin-bottom: 0.5rem;
        color: #7a5a5a;
    }
    .info-row:last-child { margin-bottom: 0; }
    .info-row strong { color: #400a0f; }
    .steps-card {
        background: #fffbeb;
        border: 1.5px solid #fde68a;
        border-radius: 1rem;
        padding: 1rem 1.25rem;
        text-align: left;
        margin-bottom: 1.5rem;
        font-size: 0.85rem;
        color: #92400e;
    }
    .steps-card p { margin: 0 0 0.4rem; font-weight: 600; }
    .steps-card ul {
        margin: 0;
        padding-left: 1.2rem;
        line-height: 1.9;
    }
    .btn-home {
        display: inline-block;
        padding: 0.85rem 2rem;
        border-radius: 1rem;
        background-color: #b73f2e;
        color: white;
        font-size: 1rem;
        font-weight: 700;
        font-family: 'Fredoka', sans-serif;
        text-decoration: none;
        transition: background-color 0.15s;
    }
    .btn-home:hover { background-color: #993623; }
    .order-code-badge {
        display: inline-block;
        background: #fee2e2;
        color: #b91c1c;
        font-family: monospace;
        font-size: 0.85rem;
        font-weight: 700;
        padding: 0.2rem 0.75rem;
        border-radius: 9999px;
        margin-bottom: 1.5rem;
    }
</style>

<div class="success-section">

    <div class="success-icon">🎉</div>

    <h1 class="success-title">Bukti Bayar Terkirim!</h1>
    <p class="success-subtitle">
        Terima kasih, bukti pembayaran kamu sudah kami terima.<br>
        Admin akan segera memverifikasi pembayaran.
    </p>

    <div class="order-code-badge">{{ $order->order_code }}</div>

    <div class="info-card">
        <div class="info-row">
            <span>Nama</span>
            <strong>{{ $order->customer_name }}</strong>
        </div>
        <div class="info-row">
            <span>Total Pembayaran</span>
            <strong style="color: #b73f2e;">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</strong>
        </div>
        <div class="info-row">
            <span>Status</span>
            <strong style="color: #f59e0b;">⏳ Menunggu Verifikasi</strong>
        </div>
    </div>

    <div class="steps-card">
        <p>📌 Langkah selanjutnya:</p>
        <ul>
            <li>Admin akan mengecek bukti pembayaran kamu</li>
            <li>Setelah dikonfirmasi, pesanan mulai diproses</li>
            <li>Hubungi kami via WhatsApp jika ada pertanyaan</li>
        </ul>
    </div>

    <a href="/" class="btn-home">🏠 Kembali ke Menu</a>

</div>

@endsection
