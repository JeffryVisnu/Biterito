@extends('layouts.app')

@section('content')

<section class="max-w-2xl mx-auto px-4 py-10">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">🛒 Keranjang Belanja</h1>

    {{-- Cart Items --}}
    <div id="cart-container" class="space-y-4 mb-6">
        {{-- Diisi oleh JavaScript --}}
    </div>

    {{-- Empty Cart --}}
    <div id="empty-cart" class="hidden text-center py-32">
        <p class="text-6xl mb-4">🛒</p>
        <p class="text-gray-500 font-semibold text-lg">Keranjang kamu kosong!</p>
        <a href="/" class="mt-4 inline-block bg-red-600 text-white px-6 py-3 rounded-full font-semibold hover:bg-red-700 transition">
            Lihat Menu
        </a>
    </div>

    {{-- Summary --}}
    <div id="cart-summary" class="hidden">
        <div class="bg-white rounded-2xl shadow-md p-4 mb-4">
            <div class="flex justify-between items-center text-gray-600 mb-2">
                <span>Subtotal</span>
                <span id="subtotal">Rp 0</span>
            </div>
            <div class="flex justify-between items-center text-gray-600 mb-2">
                <span>Ongkir</span>
                <span class="text-green-600 font-semibold">Gratis 🎉</span>
            </div>
            <hr class="my-2">
            <div class="flex justify-between items-center font-bold text-lg text-gray-800">
                <span>Total</span>
                <span id="total" class="text-red-600">Rp 0</span>
            </div>
        </div>

        {{-- Checkout Form --}}
        <div class="bg-white rounded-2xl shadow-md p-4 mb-4">
            <h2 class="font-bold text-gray-800 mb-4">📋 Data Pemesan</h2>
            <div class="space-y-3">
                <div>
                    <label class="text-sm text-gray-600 font-medium">Nama Lengkap *</label>
                    <input type="text" id="customer_name" placeholder="Masukkan nama kamu"
                        class="w-full mt-1 border border-gray-300 rounded-xl px-4 py-2 focus:outline-none focus:ring-2 focus:ring-red-400">
                </div>
                <div>
                    <label class="text-sm text-gray-600 font-medium">Nomor WhatsApp *</label>
                    <input type="text" id="customer_phone" placeholder="08xxxxxxxxxx"
                        class="w-full mt-1 border border-gray-300 rounded-xl px-4 py-2 focus:outline-none focus:ring-2 focus:ring-red-400">
                </div>
                <div>
                    <label class="text-sm text-gray-600 font-medium">Email (opsional)</label>
                    <input type="email" id="customer_email" placeholder="email@kamu.com"
                        class="w-full mt-1 border border-gray-300 rounded-xl px-4 py-2 focus:outline-none focus:ring-2 focus:ring-red-400">
                </div>
                <div>
                    <label class="text-sm text-gray-600 font-medium">Alamat Pengiriman *</label>
                    <textarea id="delivery_address" placeholder="Masukkan alamat lengkap kamu" rows="3"
                        class="w-full mt-1 border border-gray-300 rounded-xl px-4 py-2 focus:outline-none focus:ring-2 focus:ring-red-400"></textarea>
                </div>
            </div>
        </div>

        {{-- Checkout Button --}}
        <button onclick="checkout()"
            class="w-full bg-red-600 text-white py-4 rounded-2xl font-bold text-lg hover:bg-red-700 transition active:scale-95">
            💳 Bayar Sekarang
        </button>
    </div>
</section>

{{-- Toast --}}
<div id="toast" class="fixed bottom-6 left-1/2 -translate-x-1/2 bg-green-700 text-white px-6 py-3 rounded-full shadow-lg font-semibold z-50 hidden">
</div>

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
            emptyCart.classList.remove('hidden');
            summary.classList.add('hidden');
            container.innerHTML = '';
            return;
        }

        emptyCart.classList.add('hidden');
        summary.classList.remove('hidden');

        container.innerHTML = cart.map((item, index) => `
            <div class="bg-white rounded-2xl shadow-md p-4 flex items-center gap-4">
                <div class="text-4xl">🌯</div>
                <div class="flex-1">
                    <p class="font-semibold text-gray-800">${item.name}</p>
                    <p class="text-red-600 font-bold">${formatRupiah(item.price)}</p>
                    <input type="text" placeholder="Catatan (opsional)"
                        value="${item.notes}"
                        onchange="updateNotes(${index}, this.value)"
                        class="mt-1 w-full text-sm border border-gray-200 rounded-lg px-3 py-1 focus:outline-none focus:ring-1 focus:ring-red-400">
                </div>
                <div class="flex items-center gap-2">
                    <button onclick="changeQty(${index}, -1)"
                        class="w-8 h-8 bg-gray-100 rounded-full font-bold text-gray-600 hover:bg-red-100 transition">-</button>
                    <span class="font-bold text-gray-800 w-4 text-center">${item.qty}</span>
                    <button onclick="changeQty(${index}, 1)"
                        class="w-8 h-8 bg-gray-100 rounded-full font-bold text-gray-600 hover:bg-green-100 transition">+</button>
                </div>
            </div>
        `).join('');

        // Update total
        const total = cart.reduce((sum, item) => sum + (item.price * item.qty), 0);
        document.getElementById('subtotal').textContent = formatRupiah(total);
        document.getElementById('total').textContent = formatRupiah(total);
    }

    function changeQty(index, delta) {
        cart[index].qty += delta;
        if (cart[index].qty <= 0) {
            cart.splice(index, 1);
        }
        localStorage.setItem('biterito_cart', JSON.stringify(cart));
        updateCartCount();
        renderCart();
    }

    function updateNotes(index, value) {
        cart[index].notes = value;
        localStorage.setItem('biterito_cart', JSON.stringify(cart));
    }

    function showToast(message) {
        const toast = document.getElementById('toast');
        toast.textContent = message;
        toast.classList.remove('hidden');
        setTimeout(() => toast.classList.add('hidden'), 2500);
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

        const btn = document.querySelector('button[onclick="checkout()"]');
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