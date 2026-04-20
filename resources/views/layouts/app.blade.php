<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Biterito' }}</title>
    <link rel="icon" type="image/png" href="{{ asset('Logo_title.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        html { scroll-behavior: smooth; }
        * { box-sizing: border-box; }
        body {
            font-family: 'Fredoka', sans-serif;
            background-color: #e4dec4;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            margin: 0;
        }
        main { flex: 1; }
        #navbar {
            background-color: #b73f2e;
            border-bottom: 3px solid #f69304;
            position: sticky;
            top: 0;
            z-index: 50;
            box-shadow: 0 2px 8px rgba(0,0,0,0.2);
        }
        #navbar-inner {
            max-width: 72rem;
            margin: 0 auto;
            padding: 0.4rem 1rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        #navbar-logo-box {
            background-color: #e4dec4;
            border-radius: 12px;
            padding: 4px 12px;
            display: inline-flex;
            align-items: center;
        }
        #navbar-logo-img {
            height: 3rem;
            width: auto;
            object-fit: contain;
            display: block;
        }
        #logo-text {
            display: none;
            font-family: 'Fredoka', sans-serif;
            font-weight: 700;
            font-size: 1.4rem;
            color: #b73f2e;
            letter-spacing: 1px;
        }
        #cart-btn {
            background-color: #f69304;
            color: white;
            padding: 0.45rem 0.9rem;
            border-radius: 9999px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.4rem;
            text-decoration: none;
            font-size: 0.9rem;
            transition: background-color 0.15s;
        }
        #cart-count {
            background: white;
            color: #b73f2e;
            font-size: 0.7rem;
            font-weight: 700;
            border-radius: 9999px;
            width: 1.2rem;
            height: 1.2rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        #site-footer {
            background-color: #993623;
            border-top: 3px solid #f69304;
            color: white;
            text-align: center;
            padding: 0.75rem 1rem;
        }
        #footer-inner {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1rem;
            flex-wrap: wrap;
        }
        #ig-link {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.35rem 0.85rem;
            border-radius: 9999px;
            font-size: 0.875rem;
            font-weight: 600;
            color: white;
            text-decoration: none;
            background: linear-gradient(135deg, #f09433, #e6683c, #dc2743, #cc2366, #bc1888);
            transition: opacity 0.15s;
        }
        #ig-link:hover { opacity: 0.85; }
    </style>
</head>
<body>

    {{-- Navbar --}}
    <nav id="navbar">
        <div id="navbar-inner">
            {{-- Logo --}}
            <div style="display: flex; align-items: center; gap: 1.5rem;">
                <a href="/" style="text-decoration: none; display: inline-flex; align-items: center;">
                    <div id="navbar-logo-box">
                        <img id="navbar-logo-img" src="{{ asset('Logo_transparan.png') }}" alt="Biterito"
                            onerror="this.style.display='none'; document.getElementById('logo-text').style.display='inline-block'">
                        <span id="logo-text">Biterito</span>
                    </div>
                </a>
                <a href="/#menu-section" style="color: white; text-decoration: none; font-weight: 600; font-size: 0.95rem;"
                   onmouseover="this.style.color='#f69304'" onmouseout="this.style.color='white'">Menu</a>
                <a href="#tentang" style="color: white; text-decoration: none; font-weight: 600; font-size: 0.95rem;"
                   onmouseover="this.style.color='#f69304'" onmouseout="this.style.color='white'">Tentang</a>
                <a href="#site-footer" style="color: white; text-decoration: none; font-weight: 600; font-size: 0.95rem;"
                   onmouseover="this.style.color='#f69304'" onmouseout="this.style.color='white'">Kontak</a>
            </div>

            {{-- Cart Button --}}
            <a href="/cart" id="cart-btn"
               onmouseover="this.style.backgroundColor='#f4a738'"
               onmouseout="this.style.backgroundColor='#f69304'">
                🛒 Keranjang
                <span id="cart-count">0</span>
            </a>
        </div>
    </nav>

    {{-- Main Content --}}
    <main>
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer id="site-footer">
        <div id="footer-inner">
            <a href="https://www.instagram.com/biteritoo/" id="ig-link" target="_blank" rel="noopener noreferrer">
                <svg style="width: 1rem; height: 1rem; flex-shrink: 0;" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 1 0 0 12.324 6.162 6.162 0 0 0 0-12.324zM12 16a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm6.406-11.845a1.44 1.44 0 1 0 0 2.881 1.44 1.44 0 0 0 0-2.881z"/>
                </svg>
                @biteritoo
            </a>
            <p style="font-size: 0.75rem; color: #e4dec4; margin: 0;">© {{ date('Y') }} Biterito. All rights reserved.</p>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
