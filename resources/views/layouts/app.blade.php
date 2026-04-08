<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Biterito' }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 min-h-screen flex flex-col" style="font-family: 'Poppins', sans-serif;">

    {{-- Navbar --}}
    <nav class="bg-red-600 shadow-lg sticky top-0 z-50">
        <div class="max-w-6xl mx-auto px-4 py-3 flex items-center justify-between">
            {{-- Logo --}}
            <a href="/" class="flex items-center gap-2">
                <img src="{{ asset('images/logo.png') }}" alt="Biterito" class="h-10 w-auto"
                    onerror="this.style.display='none'; document.getElementById('logo-text').style.display='block'">
                <span id="logo-text" class="text-white font-bold text-2xl">🌯 Biterito</span>
            </a>

            {{-- Cart Button --}}
            <a href="/cart" class="relative bg-yellow-500 text-white px-4 py-2 rounded-full font-semibold flex items-center gap-2 hover:bg-yellow-400 transition">
                🛒 <span class="hidden sm:inline">Keranjang</span>
                <span id="cart-count" class="bg-white text-red-600 text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center">0</span>
            </a>
        </div>
    </nav>

    {{-- Main Content --}}
    <main class="flex-1">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="bg-green-800 text-white text-center py-6">
        <p class="font-semibold text-lg">🌯 Biterito</p>
        <p class="text-sm text-green-200 mt-1">Burrito dengan cita rasa Nusantara</p>
    </footer>

    @stack('scripts')
</body>
</html>