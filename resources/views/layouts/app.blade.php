<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Biterito' }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-amber-50 min-h-screen flex flex-col" style="font-family: 'Fredoka', sans-serif;">

    {{-- Navbar --}}
    <nav class="bg-red-700 shadow-lg sticky top-0 z-50" style="border-bottom: 3px solid #F9A825;">
        <div class="max-w-6xl mx-auto px-4 py-1 flex items-center justify-between">
            {{-- Logo --}}
            <a href="/" class="flex items-center gap-1">
                <img src="{{ asset('logo_biterito.png') }}" alt="Biterito" class="h-20 w-auto object-contain"
                    onerror="this.style.display='none'; document.getElementById('logo-text').style.display='block'">
                <span id="logo-text" class="text-white font-bold text-2xl hidden" style="font-family: 'Fredoka', sans-serif; letter-spacing: 1px;">Biterito</span>
            </a>

            {{-- Cart Button --}}
            <a href="/cart" class="relative text-white px-4 py-2 rounded-full font-semibold flex items-center gap-2 transition" style="background-color: #F9A825;" onmouseover="this.style.backgroundColor='#e09000'" onmouseout="this.style.backgroundColor='#F9A825'">
                🛒 <span class="hidden sm:inline">Keranjang</span>
                <span id="cart-count" class="bg-white text-red-700 text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center">0</span>
            </a>
        </div>
    </nav>

    {{-- Main Content --}}
    <main class="flex-1">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="text-white text-center py-3 px-4" style="background-color: #7a1010; border-top: 3px solid #F9A825;">
        <div class="flex items-center justify-center gap-4 flex-wrap">
            <a href="https://www.instagram.com/biteritoo/" target="_blank" rel="noopener noreferrer"
               class="flex items-center gap-1.5 px-3 py-1.5 rounded-full transition text-sm"
               style="background: linear-gradient(135deg, #f09433, #e6683c, #dc2743, #cc2366, #bc1888); color: white; font-family: 'Fredoka', sans-serif;"
               onmouseover="this.style.opacity='0.85'" onmouseout="this.style.opacity='1'">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 1 0 0 12.324 6.162 6.162 0 0 0 0-12.324zM12 16a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm6.406-11.845a1.44 1.44 0 1 0 0 2.881 1.44 1.44 0 0 0 0-2.881z"/>
                </svg>
                @biteritoo
            </a>
            <p class="text-xs" style="color: #c07070;">© {{ date('Y') }} Biterito. All rights reserved.</p>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>