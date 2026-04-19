@extends('layouts.app')

@section('content')

<style>
@keyframes bounce {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-6px); }
}
@media (min-width: 640px) {
    .menu-grid { grid-template-columns: repeat(2, 1fr) !important; }
}
@media (min-width: 1024px) {
    .menu-grid { grid-template-columns: repeat(3, 1fr) !important; }
}
</style>

{{-- Hero Section --}}
<section style="color: white; padding: 2rem 1rem 2.5rem; position: relative; overflow: hidden; background: linear-gradient(135deg, #f4a738 0%, #db5c26 45%, #b73f2e 100%);">

    {{-- Decorative food emojis background --}}
    <div style="position: absolute; inset: 0; pointer-events: none; overflow: hidden; opacity: 0.08; font-size: 3rem; line-height: 1;">
        <span style="position: absolute; top: 8%; left: 4%;">🌯</span>
        <span style="position: absolute; top: 55%; left: 2%;">🥤</span>
        <span style="position: absolute; top: 20%; left: 14%;">🍟</span>
        <span style="position: absolute; top: 65%; left: 12%;">🌶️</span>
        <span style="position: absolute; top: 10%; right: 5%;">🧆</span>
        <span style="position: absolute; top: 60%; right: 3%;">🥙</span>
        <span style="position: absolute; top: 30%; right: 14%;">🍗</span>
        <span style="position: absolute; top: 72%; right: 12%;">🧃</span>
    </div>

    <div style="max-width: 72rem; margin: 0 auto; text-align: center; position: relative; z-index: 10;">

        {{-- Logo --}}
        <div style="display: flex; justify-content: center; margin-bottom: 0.75rem;">
            <div style="background-color: #e4dec4; border-radius: 18px; padding: 8px 20px; display: inline-flex; align-items: center;">
                <img src="{{ asset('logoasli.PNG') }}" alt="Biterito"
                     style="height: 5.5rem; width: auto; object-fit: contain;"
                     onerror="this.style.display='none'; document.getElementById('hero-logo-text').style.display='block'">
                <span id="hero-logo-text" style="display:none; font-family:'Fredoka',sans-serif; font-size:1.75rem; font-weight:700; color:#b73f2e;">Biterito</span>
            </div>
        </div>

        {{-- Tagline --}}
        <h1 style="font-family: 'Fredoka', sans-serif; color: #fff; letter-spacing: 0.5px; font-size: 1.5rem; font-weight: 700; margin: 0 0 0.3rem;">
            Rasa Lokal dalam Setiap Gigitan
        </h1>
        <p style="color: #fcd5d5; font-size: 0.875rem; margin: 0 0 1.25rem;">
            Pesan makanan & minuman favoritmu langsung dari dapur Biterito
        </p>

        {{-- Badges --}}
        <div style="display: flex; align-items: center; justify-content: center; gap: 0.5rem; flex-wrap: wrap; margin-bottom: 1.25rem;">
            <span style="color: white; padding: 0.35rem 0.9rem; border-radius: 9999px; font-size: 0.8rem; font-weight: 600; background-color: #f69304; display: inline-block;">
                💰 Harga Terjangkau
            </span>
            <span style="color: white; padding: 0.35rem 0.9rem; border-radius: 9999px; font-size: 0.8rem; font-weight: 600; background-color: rgba(255,255,255,0.18); border: 1px solid rgba(255,255,255,0.35); display: inline-block;">
                🌶️ Cita Rasa Nusantara
            </span>
            <span style="color: white; padding: 0.35rem 0.9rem; border-radius: 9999px; font-size: 0.8rem; font-weight: 600; background-color: rgba(255,255,255,0.18); border: 1px solid rgba(255,255,255,0.35); display: inline-block;">
                📦 Fresh & Pre-Order
            </span>
        </div>

        {{-- Scroll to menu button --}}
        <a href="#menu-section"
           style="display: inline-flex; align-items: center; gap: 0.4rem; font-size: 0.875rem; font-weight: 600; color: #f69304; text-decoration: none;"
           onmouseover="this.style.color='#f7b93c'" onmouseout="this.style.color='#f69304'">
            Lihat Menu
            <svg style="width: 1rem; height: 1rem; animation: bounce 1s infinite;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
            </svg>
        </a>
    </div>
</section>

{{-- Menu Section --}}
<section id="menu-section" style="max-width: 72rem; margin: 0 auto; padding: 2rem 1rem 2.5rem;">

    {{-- Makanan --}}
    <h2 style="color: #b73f2e; font-family: 'Fredoka', sans-serif; font-size: 1.6rem; font-weight: 700; margin: 0 0 1.5rem 4px;">
        Makanan
    </h2>
    <div class="menu-grid" style="display: grid; grid-template-columns: repeat(1, 1fr); gap: 1.25rem; margin-bottom: 2.5rem;">
        @foreach($products->where('category', 'makanan') as $product)
        <div style="background: white; border-radius: 1rem; box-shadow: 0 4px 12px rgba(0,0,0,0.08); overflow: hidden; display: flex; flex-direction: column; border: 2px solid #e4dec4;">
            <div style="height: 12rem; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #f4a738 0%, #b73f2e 100%); overflow: hidden; flex-shrink: 0;">
                @if($product->image)
                    <img src="{{ asset('images/products/'.$product->image) }}" style="height: 100%; width: 100%; object-fit: cover; display: block;">
                @else
                    <span style="font-size: 4.5rem; line-height: 1;">🌯</span>
                @endif
            </div>
            <div style="padding: 1rem; display: flex; flex-direction: column; flex: 1;">
                <h3 style="font-weight: 700; font-size: 1.05rem; color: #400a0f; font-family: 'Fredoka', sans-serif; margin: 0 0 0.2rem;">{{ $product->name }}</h3>
                <p style="font-size: 0.85rem; color: #7a5a5a; margin: 0; flex: 1;">{{ $product->description }}</p>
                <div style="display: flex; align-items: center; justify-content: space-between; margin-top: 1rem; padding-top: 0.75rem; border-top: 1px solid #f0ebe0;">
                    <span style="font-weight: 800; font-size: 1.15rem; color: #b73f2e;">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </span>
                    <button onclick="addToCart({{ $product->id }}, '{{ $product->name }}', {{ $product->price }})"
                        style="background-color: #b73f2e; color: white; padding: 0.45rem 1rem; border-radius: 9999px; font-weight: 600; font-family: 'Fredoka', sans-serif; border: none; cursor: pointer; font-size: 0.9rem; transition: background-color 0.15s;"
                        onmouseover="this.style.backgroundColor='#993623'" onmouseout="this.style.backgroundColor='#b73f2e'">
                        + Tambah
                    </button>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Minuman --}}
    <h2 style="color: #b73f2e; font-family: 'Fredoka', sans-serif; font-size: 1.6rem; font-weight: 700; margin: 0 0 1.5rem 4px;">
        Minuman
    </h2>
    <div class="menu-grid" style="display: grid; grid-template-columns: repeat(1, 1fr); gap: 1.25rem;">
        @foreach($products->where('category', 'minuman') as $product)
        <div style="background: white; border-radius: 1rem; box-shadow: 0 4px 12px rgba(0,0,0,0.08); overflow: hidden; display: flex; flex-direction: column; border: 2px solid #e4dec4;">
            <div style="height: 12rem; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #f7b93c 0%, #db5c26 100%); overflow: hidden; flex-shrink: 0;">
                @if($product->image)
                    <img src="{{ asset('images/products/'.$product->image) }}" style="height: 100%; width: 100%; object-fit: cover; display: block;">
                @else
                    <span style="font-size: 4.5rem; line-height: 1;">🥤</span>
                @endif
            </div>
            <div style="padding: 1rem; display: flex; flex-direction: column; flex: 1;">
                <h3 style="font-weight: 700; font-size: 1.05rem; color: #400a0f; font-family: 'Fredoka', sans-serif; margin: 0 0 0.2rem;">{{ $product->name }}</h3>
                <p style="font-size: 0.85rem; color: #7a5a5a; margin: 0; flex: 1;">{{ $product->description }}</p>
                <div style="display: flex; align-items: center; justify-content: space-between; margin-top: 1rem; padding-top: 0.75rem; border-top: 1px solid #f0ebe0;">
                    <span style="font-weight: 800; font-size: 1.15rem; color: #db5c26;">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </span>
                    <button onclick="addToCart({{ $product->id }}, '{{ $product->name }}', {{ $product->price }})"
                        style="background-color: #db5c26; color: white; padding: 0.45rem 1rem; border-radius: 9999px; font-weight: 600; font-family: 'Fredoka', sans-serif; border: none; cursor: pointer; font-size: 0.9rem; transition: background-color 0.15s;"
                        onmouseover="this.style.backgroundColor='#b5402c'" onmouseout="this.style.backgroundColor='#db5c26'">
                        + Tambah
                    </button>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</section>

{{-- Toast Notification --}}
<div id="toast"
     style="position: fixed; bottom: 1.5rem; left: 50%; transform: translateX(-50%); color: white; padding: 0.75rem 1.5rem; border-radius: 9999px; box-shadow: 0 4px 16px rgba(0,0,0,0.2); font-weight: 600; z-index: 50; display: none; background-color: #b73f2e; font-family: 'Fredoka', sans-serif; border: 2px solid #f69304; white-space: nowrap;">
</div>

@endsection

@push('scripts')
<script>
    let cart = JSON.parse(localStorage.getItem('biterito_cart')) || [];

    function updateCartCount() {
        const total = cart.reduce((sum, item) => sum + item.qty, 0);
        document.getElementById('cart-count').textContent = total;
    }

    function addToCart(id, name, price) {
        const existing = cart.find(item => item.id === id);
        if (existing) {
            existing.qty += 1;
        } else {
            cart.push({ id, name, price, qty: 1, notes: '' });
        }
        localStorage.setItem('biterito_cart', JSON.stringify(cart));
        updateCartCount();
        showToast('✅ ' + name + ' ditambahkan!');
    }

    function showToast(message) {
        const toast = document.getElementById('toast');
        toast.textContent = message;
        toast.style.display = 'block';
        setTimeout(() => toast.style.display = 'none', 2500);
    }

    updateCartCount();
</script>
@endpush
