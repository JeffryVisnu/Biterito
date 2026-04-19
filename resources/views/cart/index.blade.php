@extends('layouts.app')

@section('content')

<style>
    .cart-section {
        max-width: 42rem;
        margin: 0 auto;
        padding: 1.5rem 1rem 2rem;
    }
    .cart-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #400a0f;
        margin: 0 0 1.25rem;
        font-family: 'Fredoka', sans-serif;
    }
    .cart-card {
        background: white;
        border-radius: 1rem;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        padding: 1rem;
        margin-bottom: 0.85rem;
        border: 1px solid #e4dec4;
    }
    .cart-item {
        display: flex;
        align-items: center;
        gap: 0.85rem;
    }
    .cart-item-info { flex: 1; min-width: 0; }
    .cart-item-name {
        font-weight: 600;
        color: #400a0f;
        font-size: 0.95rem;
        margin: 0 0 0.2rem;
        font-family: 'Fredoka', sans-serif;
    }
    .cart-item-price {
        font-weight: 700;
        color: #b73f2e;
        font-size: 0.9rem;
        margin: 0 0 0.3rem;
    }
    .cart-note-input {
        width: 100%;
        font-size: 0.8rem;
        border: 1px solid #e0d8cc;
        border-radius: 0.5rem;
        padding: 0.3rem 0.6rem;
        outline: none;
        font-family: 'Fredoka', sans-serif;
        box-sizing: border-box;
    }
    .cart-note-input:focus { border-color: #f69304; }
    .qty-controls {
        display: flex;
        align-items: center;
        gap: 0.4rem;
        flex-shrink: 0;
    }
    .qty-btn {
        width: 2rem;
        height: 2rem;
        border-radius: 9999px;
        border: none;
        background: #f0ebe0;
        color: #400a0f;
        font-weight: 700;
        font-size: 1rem;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .qty-btn:hover { background: #e4dec4; }
    .qty-num {
        font-weight: 700;
        color: #400a0f;
        min-width: 1.2rem;
        text-align: center;
        font-size: 0.95rem;
    }
    .summary-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        color: #7a5a5a;
        font-size: 0.9rem;
        margin-bottom: 0.5rem;
    }
    .summary-divider {
        border: none;
        border-top: 1px solid #e4dec4;
        margin: 0.6rem 0;
    }
    .summary-total {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-weight: 700;
        font-size: 1.05rem;
        color: #400a0f;
    }
    .form-group { margin-bottom: 0.85rem; }
    .form-label {
        display: block;
        font-size: 0.85rem;
        color: #7a5a5a;
        font-weight: 600;
        margin-bottom: 0.3rem;
    }
    .form-input {
        width: 100%;
        border: 1.5px solid #d6cfc2;
        border-radius: 0.75rem;
        padding: 0.55rem 0.9rem;
        font-size: 0.9rem;
        font-family: 'Fredoka', sans-serif;
        outline: none;
        box-sizing: border-box;
        background: white;
        color: #400a0f;
    }
    .form-input:focus { border-color: #f69304; box-shadow: 0 0 0 2px rgba(246,147,4,0.15); }
    .checkout-btn {
        width: 100%;
        padding: 0.9rem;
        border-radius: 1rem;
        border: none;
        background-color: #b73f2e;
        color: white;
        font-size: 1.1rem;
        font-weight: 700;
        font-family: 'Fredoka', sans-serif;
        cursor: pointer;
        transition: background-color 0.15s;
        margin-top: 0.5rem;
    }
    .checkout-btn:hover { background-color: #993623; }
    .checkout-btn:disabled { opacity: 0.7; cursor: not-allowed; }
    .empty-cart-box {
        text-align: center;
        padding: 3rem 1rem;
        display: none;
    }
    .empty-cart-emoji { font-size: 4rem; margin-bottom: 0.75rem; }
    .empty-cart-text {
        color: #7a5a5a;
        font-size: 1.05rem;
        font-weight: 600;
        margin-bottom: 1rem;
    }
    .back-btn {
        display: inline-block;
        padding: 0.6rem 1.5rem;
        border-radius: 9999px;
        background-color: #b73f2e;
        color: white;
        font-weight: 600;
        text-decoration: none;
        font-family: 'Fredoka', sans-serif;
    }
    .back-btn:hover { background-color: #993623; }
    #cart-summary { display: none; }
    #toast-cart {
        position: fixed;
        bottom: 1.5rem;
        left: 50%;
        transform: translateX(-50%);
        background-color: #4d9518;
        color: white;
        padding: 0.7rem 1.4rem;
        border-radius: 9999px;
        font-weight: 600;
        font-family: 'Fredoka', sans-serif;
        z-index: 50;
        display: none;
        white-space: nowrap;
        box-shadow: 0 4px 16px rgba(0,0,0,0.2);
    }
</style>

<div class="cart-section">
    <a href="/" style="display: inline-flex; align-items: center; gap: 0.3rem; font-size: 0.85rem; color: #7a5a5a; text-decoration: none; margin-bottom: 1rem;"
       onmouseover="this.style.color='#b73f2e'" onmouseout="this.style.color='#7a5a5a'">
        ← Kembali ke Menu
    </a>
    <h1 class="cart-title">🛒 Keranjang Belanja</h1>

    {{-- Cart Items --}}
    <div id="cart-container"></div>

    {{-- Empty Cart --}}
    <div id="empty-cart" class="empty-cart-box">
        <div class="empty-cart-emoji">🛒</div>
        <p class="empty-cart-text">Keranjang kamu kosong!</p>
        <a href="/" class="back-btn">Lihat Menu</a>
    </div>

    {{-- Summary + Form --}}
    <div id="cart-summary">
        {{-- Ringkasan Harga --}}
        <div class="cart-card">
            <div class="summary-row">
                <span>Subtotal</span>
                <span id="subtotal">Rp 0</span>
            </div>
            <div class="summary-row">
                <span>Ongkir</span>
                <span style="color: #4d9518; font-weight: 600;">Gratis 🎉</span>
            </div>
            <hr class="summary-divider">
            <div class="summary-total">
                <span>Total</span>
                <span id="total" style="color: #b73f2e;">Rp 0</span>
            </div>
        </div>

        {{-- Data Pemesan --}}
        <div class="cart-card">
            <h2 style="font-family:'Fredoka',sans-serif; font-weight:700; color:#400a0f; margin:0 0 1rem; font-size:1.1rem;">
                📋 Data Pemesan
            </h2>
            <div class="form-group">
                <label class="form-label">Nama Lengkap *</label>
                <input type="text" id="customer_name" placeholder="Masukkan nama kamu" class="form-input">
            </div>
            <div class="form-group">
                <label class="form-label">Nomor WhatsApp *</label>
                <input type="text" id="customer_phone" placeholder="08xxxxxxxxxx" class="form-input">
            </div>
            <div class="form-group">
                <label class="form-label">Email (opsional)</label>
                <input type="email" id="customer_email" placeholder="email@kamu.com" class="form-input">
            </div>
            <div class="form-group">
                <label class="form-label">Alamat Pengiriman *</label>
                <textarea id="delivery_address" placeholder="Masukkan alamat lengkap kamu" rows="3" class="form-input" style="resize: vertical;"></textarea>
            </div>
        </div>

        <button onclick="checkout()" class="checkout-btn">💳 Bayar Sekarang</button>
    </div>
</div>

<div id="toast-cart"></div>

@endsection

@push('scripts')
<script>
    let cart = JSON.parse(localStorage.getItem('biterito_cart')) || [];

    function formatRupiah(amount) {
        return 'Rp ' + amount.toLocaleString('id-ID');
    }

    function updateCartCount() {
        const total = cart.reduce((sum, item) => sum + item.qty, 0);
        document.getElementById('cart-count').textContent = total;
    }

    function renderCart() {
        const container = document.getElementById('cart-container');
        const emptyCart = document.getElementById('empty-cart');
        const summary = document.getElementById('cart-summary');

        if (cart.length === 0) {
            emptyCart.style.display = 'block';
            summary.style.display = 'none';
            container.innerHTML = '';
            return;
        }

        emptyCart.style.display = 'none';
        summary.style.display = 'block';

        container.innerHTML = cart.map((item, index) => `
            <div class="cart-card">
                <div class="cart-item">
                    <div style="font-size:2.2rem; flex-shrink:0;">🌯</div>
                    <div class="cart-item-info">
                        <p class="cart-item-name">${item.name}</p>
                        <p class="cart-item-price">${formatRupiah(item.price)}</p>
                        <input type="text" placeholder="Catatan (opsional)"
                            value="${item.notes || ''}"
                            onchange="updateNotes(${index}, this.value)"
                            class="cart-note-input">
                    </div>
                    <div class="qty-controls">
                        <button class="qty-btn" onclick="changeQty(${index}, -1)">−</button>
                        <span class="qty-num">${item.qty}</span>
                        <button class="qty-btn" onclick="changeQty(${index}, 1)">+</button>
                    </div>
                </div>
            </div>
        `).join('');

        const total = cart.reduce((sum, item) => sum + (item.price * item.qty), 0);
        document.getElementById('subtotal').textContent = formatRupiah(total);
        document.getElementById('total').textContent = formatRupiah(total);
    }

    function changeQty(index, delta) {
        cart[index].qty += delta;
        if (cart[index].qty <= 0) cart.splice(index, 1);
        localStorage.setItem('biterito_cart', JSON.stringify(cart));
        updateCartCount();
        renderCart();
    }

    function updateNotes(index, value) {
        cart[index].notes = value;
        localStorage.setItem('biterito_cart', JSON.stringify(cart));
    }

    function showToast(message) {
        const toast = document.getElementById('toast-cart');
        toast.textContent = message;
        toast.style.display = 'block';
        setTimeout(() => toast.style.display = 'none', 2500);
    }

    async function checkout() {
        const name = document.getElementById('customer_name').value.trim();
        const phone = document.getElementById('customer_phone').value.trim();
        const address = document.getElementById('delivery_address').value.trim();
        const email = document.getElementById('customer_email').value.trim();

        if (!name || !phone || !address) {
            showToast('⚠️ Nama, WhatsApp, dan alamat wajib diisi!');
            return;
        }
        if (cart.length === 0) {
            showToast('⚠️ Keranjang kamu kosong!');
            return;
        }

        const btn = document.querySelector('.checkout-btn');
        btn.textContent = '⏳ Memproses...';
        btn.disabled = true;

        try {
            const response = await fetch('/checkout', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    customer_name: name,
                    customer_phone: phone,
                    customer_email: email,
                    delivery_address: address,
                    items: cart
                })
            });

            const data = await response.json();

            if (data.success) {
                localStorage.removeItem('biterito_cart');
                window.location.href = '/payment/' + data.order_code;
            } else {
                showToast('❌ Gagal membuat order, coba lagi!');
                btn.textContent = '💳 Bayar Sekarang';
                btn.disabled = false;
            }
        } catch (error) {
            showToast('❌ Terjadi kesalahan, coba lagi!');
            btn.textContent = '💳 Bayar Sekarang';
            btn.disabled = false;
        }
    }

    updateCartCount();
    renderCart();
</script>
@endpush
