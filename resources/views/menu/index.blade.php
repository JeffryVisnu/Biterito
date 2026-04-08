@extends('layouts.app')

@section('content')

{{-- Hero Section --}}
<section class="bg-gradient-to-br from-red-600 to-red-900 text-white py-12 px-4">
    <div class="max-w-6xl mx-auto text-center">
        <h1 class="text-4xl md:text-6xl font-extrabold mb-3">🌯 Biterito</h1>
        <p class="text-lg md:text-xl text-red-100 mb-4">Burrito dengan cita rasa Nusantara</p>
        <div class="inline-block bg-yellow-500 text-white px-5 py-2 rounded-full text-sm font-semibold">
            🔥 Pre-Order Sekarang!
        </div>
    </div>
</section>

{{-- Menu Section --}}
<section class="max-w-6xl mx-auto px-4 py-10">

    {{-- Makanan --}}
    <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center gap-2">
        🌯 <span>Menu Burrito</span>
    </h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
        @foreach($products->where('category', 'makanan') as $product)
        <div class="bg-white rounded-2xl shadow-md overflow-hidden hover:shadow-xl transition flex flex-col">
            <div class="bg-gradient-to-br from-yellow-400 to-red-500 h-48 flex items-center justify-center">
                @if($product->image)
                    <img src="{{ asset('images/products/'.$product->image) }}" class="h-full w-full object-cover">
                @else
                    <span class="text-7xl">🌯</span>
                @endif
            </div>
            <div class="p-4 flex flex-col flex-1">
                <h3 class="font-bold text-lg text-gray-800">{{ $product->name }}</h3>
                <p class="text-gray-500 text-sm mt-1">{{ $product->description }}</p>
                <div class="flex items-center justify-between mt-auto pt-4">
                    <span class="text-red-600 font-extrabold text-xl">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </span>
                    <button onclick="addToCart({{ $product->id }}, '{{ $product->name }}', {{ $product->price }})"
                        class="bg-red-600 text-white px-4 py-2 rounded-full font-semibold hover:bg-red-700 transition active:scale-95">
                        + Tambah
                    </button>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Minuman --}}
    <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center gap-2">
        🥤 <span>Minuman</span>
    </h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($products->where('category', 'minuman') as $product)
        <div class="bg-white rounded-2xl shadow-md overflow-hidden hover:shadow-xl transition flex flex-col">
            <div class="bg-gradient-to-br from-green-400 to-green-700 h-48 flex items-center justify-center">
                @if($product->image)
                    <img src="{{ asset('images/products/'.$product->image) }}" class="h-full w-full object-cover">
                @else
                    <span class="text-7xl">🥤</span>
                @endif
            </div>
            <div class="p-4 flex flex-col flex-1">
                <h3 class="font-bold text-lg text-gray-800">{{ $product->name }}</h3>
                <p class="text-gray-500 text-sm mt-1">{{ $product->description }}</p>
                <div class="flex items-center justify-between mt-auto pt-4">
                    <span class="text-green-700 font-extrabold text-xl">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </span>
                    <button onclick="addToCart({{ $product->id }}, '{{ $product->name }}', {{ $product->price }})"
                        class="bg-green-700 text-white px-4 py-2 rounded-full font-semibold hover:bg-green-800 transition active:scale-95">
                        + Tambah
                    </button>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</section>

{{-- Toast Notification --}}
<div id="toast" class="fixed bottom-6 left-1/2 -translate-x-1/2 bg-green-700 text-white px-6 py-3 rounded-full shadow-lg font-semibold z-50 hidden transition-all">
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