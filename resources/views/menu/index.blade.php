@extends('layouts.app')

@section('content')

{{-- Hero Section --}}
<section class="text-white py-10 px-4 relative overflow-hidden" style="background: linear-gradient(135deg, #B71C1C 0%, #7a1010 60%, #4a0a0a 100%);">
    {{-- Decorative food emojis background --}}
    <div class="absolute inset-0 pointer-events-none select-none overflow-hidden" style="opacity: 0.08; font-size: 3rem; line-height: 1;">
        <span class="absolute" style="top: 8%; left: 4%;">🌯</span>
        <span class="absolute" style="top: 55%; left: 2%;">🥤</span>
        <span class="absolute" style="top: 20%; left: 14%;">🍟</span>
        <span class="absolute" style="top: 65%; left: 12%;">🌶️</span>
        <span class="absolute" style="top: 10%; right: 5%;">🧆</span>
        <span class="absolute" style="top: 60%; right: 3%;">🥙</span>
        <span class="absolute" style="top: 30%; right: 14%;">🍗</span>
        <span class="absolute" style="top: 72%; right: 12%;">🧃</span>
    </div>

    <div class="max-w-6xl mx-auto text-center relative z-10">
        {{-- Logo lebih kecil --}}
        <img src="{{ asset('logo_biterito.png') }}" alt="Biterito" class="h-28 md:h-36 mx-auto mb-3 object-contain drop-shadow-xl">

        {{-- Tagline --}}
        <h1 class="text-2xl md:text-3xl font-bold mb-1" style="font-family: 'Fredoka', sans-serif; color: #fff; letter-spacing: 0.5px;">
            Rasa Lokal dalam Setiap Gigitan
        </h1>
        <p class="text-sm md:text-base mb-5" style="color: #fcd5d5;">
            Pesan makanan & minuman favoritmu langsung dari dapur Biterito
        </p>

        {{-- Badges --}}
        <div class="flex items-center justify-center gap-3 flex-wrap mb-5">
            <span class="text-white px-4 py-1.5 rounded-full text-sm font-semibold shadow" style="background-color: #F9A825;">
                🔥 Pre-Order Sekarang!
            </span>
            <span class="text-white px-4 py-1.5 rounded-full text-sm font-semibold shadow" style="background-color: rgba(255,255,255,0.15); border: 1px solid rgba(255,255,255,0.3);">
                🚀 Cepat & Segar
            </span>
            <span class="text-white px-4 py-1.5 rounded-full text-sm font-semibold shadow" style="background-color: rgba(255,255,255,0.15); border: 1px solid rgba(255,255,255,0.3);">
                💚 Bahan Lokal
            </span>
        </div>

        {{-- Scroll to menu button --}}
        <a href="#menu-section" class="inline-flex items-center gap-2 text-sm font-semibold transition"
           style="color: #F9A825;" onmouseover="this.style.color='#ffd54f'" onmouseout="this.style.color='#F9A825'">
            Lihat Menu
            <svg class="w-4 h-4 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
            </svg>
        </a>
    </div>
</section>

{{-- Menu Section --}}
<section id="menu-section" class="max-w-6xl mx-auto px-4 py-10">

    {{-- Makanan --}}
    <h2 class="text-2xl font-bold mb-6 flex items-center gap-2" style="color: #B71C1C; font-family: 'Fredoka', sans-serif; font-size: 1.6rem; margin-left: 20px;">
        <span>Makanan</span>
    </h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
        @foreach($products->where('category', 'makanan') as $product)
        <div class="bg-white rounded-2xl shadow-md overflow-hidden hover:shadow-xl transition flex flex-col" style="border: 2px solid #fde8e8;">
            <div class="h-48 flex items-center justify-center" style="background: linear-gradient(135deg, #F9A825 0%, #e53935 100%);">
                @if($product->image)
                    <img src="{{ asset('images/products/'.$product->image) }}" class="h-full w-full object-cover">
                @else
                    <span class="text-7xl">🌯</span>
                @endif
            </div>
            <div class="p-4 flex flex-col flex-1">
                <h3 class="font-bold text-lg" style="color: #3a0a0a; font-family: 'Fredoka', sans-serif; font-size: 1.1rem;">{{ $product->name }}</h3>
                <p class="text-sm mt-1" style="color: #7a5a5a;">{{ $product->description }}</p>
                <div class="flex items-center justify-between mt-auto pt-4">
                    <span class="font-extrabold text-xl" style="color: #B71C1C;">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </span>
                    <button onclick="addToCart({{ $product->id }}, '{{ $product->name }}', {{ $product->price }})"
                        class="text-white px-4 py-2 rounded-full font-semibold transition active:scale-95"
                        style="background-color: #B71C1C; font-family: 'Fredoka', sans-serif;"
                        onmouseover="this.style.backgroundColor='#7a1010'" onmouseout="this.style.backgroundColor='#B71C1C'">
                        + Tambah
                    </button>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Minuman --}}
    <h2 class="text-2xl font-bold mb-6 flex items-center gap-2" style="color: #B71C1C; font-family: 'Fredoka', sans-serif; font-size: 1.6rem; margin-left: 20px">
        <span>Minuman</span>
    </h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($products->where('category', 'minuman') as $product)
        <div class="bg-white rounded-2xl shadow-md overflow-hidden hover:shadow-xl transition flex flex-col" style="border: 2px solid #fde8e8;">
            <div class="h-48 flex items-center justify-center" style="background: linear-gradient(135deg, #F9A825 0%, #c97a00 100%);">
                @if($product->image)
                    <img src="{{ asset('images/products/'.$product->image) }}" class="h-full w-full object-cover">
                @else
                    <span class="text-7xl">🥤</span>
                @endif
            </div>
            <div class="p-4 flex flex-col flex-1">
                <h3 class="font-bold text-lg" style="color: #3a0a0a; font-family: 'Fredoka', sans-serif; font-size: 1.1rem;">{{ $product->name }}</h3>
                <p class="text-sm mt-1" style="color: #7a5a5a;">{{ $product->description }}</p>
                <div class="flex items-center justify-between mt-auto pt-4">
                    <span class="font-extrabold text-xl" style="color: #c97a00;">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </span>
                    <button onclick="addToCart({{ $product->id }}, '{{ $product->name }}', {{ $product->price }})"
                        class="text-white px-4 py-2 rounded-full font-semibold transition active:scale-95"
                        style="background-color: #c97a00; font-family: 'Fredoka', sans-serif;"
                        onmouseover="this.style.backgroundColor='#9a5a00'" onmouseout="this.style.backgroundColor='#c97a00'">
                        + Tambah
                    </button>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</section>

{{-- Toast Notification --}}
<div id="toast" class="fixed bottom-6 left-1/2 -translate-x-1/2 text-white px-6 py-3 rounded-full shadow-lg font-semibold z-50 hidden transition-all" style="background-color: #B71C1C; font-family: 'Fredoka', sans-serif; border: 2px solid #F9A825;">
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
        toast.classList.remove('hidden');
        setTimeout(() => toast.classList.add('hidden'), 2500);
    }

    updateCartCount();
</script>
@endpush