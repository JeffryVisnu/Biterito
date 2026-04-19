@extends('layouts.app')

@section('content')

<style>
    .payment-section {
        max-width: 36rem;
        margin: 0 auto;
        padding: 1.5rem 1rem 2rem;
    }
    .payment-title {
        font-size: 1.4rem;
        font-weight: 700;
        color: #400a0f;
        margin: 0 0 0.25rem;
        font-family: 'Fredoka', sans-serif;
        text-align: center;
    }
    .payment-subtitle {
        color: #7a5a5a;
        font-size: 0.875rem;
        margin: 0 0 1.5rem;
        text-align: center;
    }
    .pay-card {
        background: white;
        border-radius: 1rem;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        padding: 1rem;
        margin-bottom: 1rem;
        border: 1px solid #e4dec4;
    }
    .pay-card-title {
        font-weight: 700;
        color: #400a0f;
        font-family: 'Fredoka', sans-serif;
        font-size: 1rem;
        margin: 0 0 0.75rem;
    }
    .pay-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 0.875rem;
        color: #7a5a5a;
        margin-bottom: 0.4rem;
    }
    .pay-divider {
        border: none;
        border-top: 1px solid #e4dec4;
        margin: 0.6rem 0;
    }
    .pay-total {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-weight: 700;
        font-size: 1.05rem;
        color: #400a0f;
    }
    .pay-btn {
        width: 100%;
        padding: 0.9rem;
        border-radius: 1rem;
        border: none;
        background-color: #b73f2e;
        color: white;
        font-size: 1.05rem;
        font-weight: 700;
        font-family: 'Fredoka', sans-serif;
        cursor: pointer;
        transition: background-color 0.15s;
    }
    .pay-btn:hover { background-color: #993623; }
    .success-box {
        background: #f0fdf4;
        border: 1.5px solid #86efac;
        border-radius: 1rem;
        padding: 1.5rem;
        text-align: center;
        margin-bottom: 1rem;
    }
    .info-box {
        background: #fffbeb;
        border: 1.5px solid #fde68a;
        border-radius: 1rem;
        padding: 1rem;
        font-size: 0.85rem;
        color: #92400e;
    }
    .info-box ol {
        margin: 0.4rem 0 0 1rem;
        padding: 0;
        line-height: 1.8;
    }
    .back-link {
        display: block;
        text-align: center;
        margin-top: 1.25rem;
        font-size: 0.875rem;
        color: #7a5a5a;
        text-decoration: none;
    }
    .back-link:hover { color: #b73f2e; }
</style>

<div class="payment-section">

    <h1 class="payment-title">💳 Pembayaran</h1>
    <p class="payment-subtitle">
        Order <strong style="color: #b73f2e;">{{ $order->order_code }}</strong>
    </p>

    {{-- Ringkasan Order --}}
    <div class="pay-card">
        <p class="pay-card-title">📋 Ringkasan Order</p>
        @foreach($order->items as $item)
        <div class="pay-row">
            <span>{{ $item->product->name }} x{{ $item->quantity }}</span>
            <span>Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</span>
        </div>
        @endforeach
        <hr class="pay-divider">
        <div class="pay-total">
            <span>Total</span>
            <span style="color: #b73f2e;">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
        </div>
    </div>

    {{-- Status Pembayaran --}}
    @if($order->payment_status === 'paid')
    <div class="success-box">
        <div style="font-size: 3rem; margin-bottom: 0.5rem;">✅</div>
        <p style="color: #15803d; font-weight: 700; font-size: 1.2rem; margin: 0 0 0.3rem;">Pembayaran Berhasil!</p>
        <p style="color: #16a34a; font-size: 0.875rem; margin: 0;">Terima kasih, order kamu sedang diproses.</p>
    </div>
    @else
    {{-- Tombol Bayar --}}
    <div class="pay-card" style="text-align: center;">
        <p style="font-weight: 600; color: #400a0f; margin: 0 0 0.75rem; font-family:'Fredoka',sans-serif;">
            Scan QRIS untuk Membayar
        </p>
        <button id="pay-button" class="pay-btn"
            onmouseover="this.style.backgroundColor='#993623'"
            onmouseout="this.style.backgroundColor='#b73f2e'">
            🔍 Tampilkan QR Code
        </button>
        <p style="color: #aaa; font-size: 0.75rem; margin: 0.75rem 0 0;">
            Selesaikan pembayaran sebelum waktu habis
        </p>
    </div>

    {{-- Cara Bayar --}}
    <div class="info-box">
        <p style="font-weight: 600; margin: 0 0 0.3rem;">📌 Cara Bayar:</p>
        <ol>
            <li>Klik tombol "Tampilkan QR Code"</li>
            <li>Scan QR dengan e-wallet atau m-banking</li>
            <li>Nominal sudah otomatis terisi</li>
            <li>Konfirmasi pembayaran di aplikasi kamu</li>
        </ol>
    </div>
    @endif

    <a href="/" class="back-link">← Kembali ke Menu</a>

</div>

@endsection

@push('scripts')
<script src="https://app.sandbox.midtrans.com/snap/snap.js"
    data-client-key="{{ config('midtrans.client_key') }}"></script>

<script>
    @if($order->payment_status !== 'paid')
    const snapToken = "{{ $order->midtrans_snap_token }}";

    document.getElementById('pay-button').addEventListener('click', function() {
        window.snap.pay(snapToken, {
            onSuccess: function(result) { window.location.reload(); },
            onPending: function(result) { console.log('pending', result); },
            onError: function(result) { alert('Pembayaran gagal, silakan coba lagi.'); },
            onClose: function() { console.log('popup ditutup'); }
        });
    });

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
