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
    .pay-btn:disabled { background-color: #ccc; cursor: not-allowed; }
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
    .qris-img {
        display: block;
        margin: 0.75rem auto;
        max-width: 260px;
        width: 100%;
        border-radius: 0.75rem;
        border: 1px solid #e4dec4;
    }
    .upload-label {
        display: block;
        font-size: 0.85rem;
        font-weight: 600;
        color: #400a0f;
        margin-bottom: 0.4rem;
    }
    .upload-input {
        display: block;
        width: 100%;
        font-size: 0.85rem;
        color: #374151;
        border: 1.5px solid #e4dec4;
        border-radius: 0.75rem;
        padding: 0.5rem 0.75rem;
        background: #faf9f7;
        margin-bottom: 0.75rem;
        box-sizing: border-box;
    }
    .upload-hint {
        font-size: 0.75rem;
        color: #9ca3af;
        margin: -0.4rem 0 0.75rem;
    }
    .alert-success {
        background: #dcfce7;
        border: 1px solid #86efac;
        color: #15803d;
        padding: 0.75rem 1rem;
        border-radius: 0.75rem;
        margin-bottom: 1rem;
        font-size: 0.875rem;
        text-align: center;
    }
    .proof-sent-box {
        background: #eff6ff;
        border: 1.5px solid #bfdbfe;
        border-radius: 1rem;
        padding: 1rem;
        font-size: 0.85rem;
        color: #1e40af;
        text-align: center;
        margin-bottom: 1rem;
    }
</style>

<div class="payment-section">

    <h1 class="payment-title">💳 Pembayaran</h1>
    <p class="payment-subtitle">
        @if($order)
            Order <strong style="color: #b73f2e;">{{ $order->order_code }}</strong>
        @else
            Selesaikan pembayaran untuk konfirmasi pesananmu
        @endif
    </p>

    @if(session('success'))
    <div class="alert-success">✅ {{ session('success') }}</div>
    @endif

    {{-- Ringkasan Order --}}
    <div class="pay-card">
        <p class="pay-card-title">📋 Ringkasan Order</p>
        @if($pending)
            @foreach($pending['items'] as $item)
            <div class="pay-row">
                <span>{{ $item['product_name'] }} x{{ $item['quantity'] }}</span>
                <span>Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</span>
            </div>
            @endforeach
            <hr class="pay-divider">
            <div class="pay-total">
                <span>Total</span>
                <span style="color: #b73f2e;">Rp {{ number_format($pending['total'], 0, ',', '.') }}</span>
            </div>
        @else
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
        @endif
    </div>

    {{-- Status: hanya untuk order yang sudah ada di DB --}}
    @if($order && $order->payment_status === 'paid')
    <div class="success-box">
        <div style="font-size: 3rem; margin-bottom: 0.5rem;">✅</div>
        <p style="color: #15803d; font-weight: 700; font-size: 1.2rem; margin: 0 0 0.3rem;">Pembayaran Dikonfirmasi!</p>
        <p style="color: #16a34a; font-size: 0.875rem; margin: 0;">Terima kasih, order kamu sedang diproses.</p>
    </div>
    @elseif($order && $order->payment_proof)
    <div class="proof-sent-box">
        <p style="font-weight: 700; margin: 0 0 0.3rem;">📎 Bukti pembayaran sudah dikirim</p>
        <p style="margin: 0; font-size: 0.8rem;">Sedang menunggu verifikasi admin. Terima kasih!</p>
    </div>
    @else

    {{-- QRIS --}}
    <div class="pay-card" style="text-align: center;">
        <p class="pay-card-title" style="text-align: center;">📱 Scan QRIS untuk Membayar</p>
        <img src="{{ asset('images/qris.png') }}" alt="QRIS Biterito" class="qris-img">
        <p style="color: #7a5a5a; font-size: 0.8rem; margin: 0.5rem 0 0;">
            Total: <strong style="color: #b73f2e;">
                Rp {{ number_format($pending ? $pending['total'] : $order->total_amount, 0, ',', '.') }}
            </strong>
        </p>
    </div>

    {{-- Upload Bukti Bayar --}}
    <div class="pay-card">
        <p class="pay-card-title">📎 Upload Bukti Pembayaran</p>
        <form method="POST" action="{{ route('payment.upload-proof') }}" enctype="multipart/form-data">
            @csrf
            <label class="upload-label">Pilih file bukti transfer / screenshot pembayaran</label>
            <input type="file" name="proof" accept=".jpg,.jpeg,.png,.pdf" class="upload-input" required>
            <p class="upload-hint">Format: JPG, PNG, atau PDF. Maksimal 1 MB.</p>
            @error('proof')
            <p style="color: #dc2626; font-size: 0.8rem; margin: -0.4rem 0 0.6rem;">{{ $message }}</p>
            @enderror
            <button type="submit" class="pay-btn">
                📤 Kirim Bukti Bayar
            </button>
        </form>
    </div>

    {{-- Cara Bayar --}}
    <div class="info-box">
        <p style="font-weight: 600; margin: 0 0 0.3rem;">📌 Cara Bayar:</p>
        <ol>
            <li>Scan QR di atas dengan e-wallet atau m-banking</li>
            <li>Masukkan nominal: <strong>
                Rp {{ number_format($pending ? $pending['total'] : $order->total_amount, 0, ',', '.') }}
            </strong></li>
            <li>Selesaikan pembayaran</li>
            <li>Screenshot/foto bukti pembayaran</li>
            <li>Upload bukti di atas, lalu klik "Kirim Bukti Bayar"</li>
        </ol>
    </div>
    @endif

    <a href="/" class="back-link">← Kembali ke Menu</a>

</div>

@endsection
