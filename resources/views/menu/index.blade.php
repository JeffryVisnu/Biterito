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
            <div style="background-color: #e4dec4; border-radius: 18px; padding: 0; display: inline-flex; align-items: center; overflow: hidden; height: 9rem;">
                <img src="{{ asset('Logo_transparan.png') }}" alt="Biterito"
                     style="height: 13rem; width: auto; object-fit: cover; object-position: center; margin-top: 1rem;"
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

{{-- About Section --}}
<section id="tentang" style="background: #fffaf4; border-bottom: 2px solid #f0ebe0; padding: 2rem 1rem;">
    <div style="max-width: 72rem; margin: 0 auto;">

        {{-- Intro --}}
        <div style="text-align: center; margin-bottom: 1.5rem;">
            <h2 style="font-family: 'Fredoka', sans-serif; font-size: 1.5rem; font-weight: 700; color: #b73f2e; margin: 0 0 0.5rem;">
                Tentang Biterito
            </h2>
            <p style="font-size: 0.9rem; color: #5c3a2e; max-width: 36rem; margin: 0 auto; line-height: 1.65;">
                Inovasi kuliner yang memadukan <strong>konsep burrito Meksiko</strong> dengan <strong>bumbu legendaris Nusantara</strong> — sensasi nasi rames &amp; nasi Padang dalam satu genggaman, hanya Rp&nbsp;17.000.
            </p>
        </div>

        {{-- Highlight Cards --}}
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-bottom: 1.25rem;">
            <div style="background: white; border-radius: 1rem; padding: 1.1rem 1rem; text-align: center; border: 2px solid #f0ebe0; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                <div style="font-size: 2rem; margin-bottom: 0.4rem;">📦</div>
                <div style="font-family: 'Fredoka', sans-serif; font-size: 1rem; font-weight: 700; color: #b73f2e; margin-bottom: 0.25rem;">Praktis & Anti-Ribet</div>
                <p style="font-size: 0.8rem; color: #7a5a5a; margin: 0; line-height: 1.5;">Wrap format — bisa dinikmati sambil bekerja, meeting, atau di perjalanan tanpa pusing soal piring dan sendok.</p>
            </div>
            <div style="background: white; border-radius: 1rem; padding: 1.1rem 1rem; text-align: center; border: 2px solid #f0ebe0; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                <div style="font-size: 2rem; margin-bottom: 0.4rem;">🌶️</div>
                <div style="font-family: 'Fredoka', sans-serif; font-size: 1rem; font-weight: 700; color: #b73f2e; margin-bottom: 0.25rem;">Rasa 100% Autentik</div>
                <p style="font-size: 0.8rem; color: #7a5a5a; margin: 0; line-height: 1.5;">Bumbu rempah pilihan diracik dengan dedikasi — tersedia varian <strong>Gulai</strong>, <strong>Balado</strong>, dan primadona <strong>Rendang</strong>.</p>
            </div>
            <div style="background: white; border-radius: 1rem; padding: 1.1rem 1rem; text-align: center; border: 2px solid #f0ebe0; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                <div style="font-size: 2rem; margin-bottom: 0.4rem;">💪</div>
                <div style="font-family: 'Fredoka', sans-serif; font-size: 1rem; font-weight: 700; color: #b73f2e; margin-bottom: 0.25rem;">Bergizi & Mengenyangkan</div>
                <p style="font-size: 0.8rem; color: #7a5a5a; margin: 0; line-height: 1.5;">Karbohidrat dari nasi &amp; tortila, protein ayam tanpa tulang, ditambah sayuran segar — energi seimbang untuk hari sibukmu.</p>
            </div>
        </div>

        {{-- Expandable full story --}}
        <div style="text-align: center;">
            <button onclick="toggleStory(this)"
                style="background: none; border: 1.5px solid #b73f2e; color: #b73f2e; padding: 0.4rem 1.2rem; border-radius: 9999px; font-size: 0.82rem; font-weight: 600; cursor: pointer; font-family: 'Fredoka', sans-serif; transition: all 0.2s;"
                onmouseover="this.style.background='#b73f2e'; this.style.color='white';"
                onmouseout="this.style.background='none'; this.style.color='#b73f2e';">
                Baca cerita kami ▾
            </button>
            <div id="full-story" style="display: none; text-align: left; margin-top: 1.25rem; max-width: 48rem; margin-left: auto; margin-right: auto;">
                <p style="font-size: 0.85rem; color: #5c3a2e; line-height: 1.75; margin: 0 0 0.9rem; text-align: justify;">
                    Biterito adalah inovasi kuliner yang lahir dari sebuah perpaduan brilian: menggabungkan konsep burrito khas Meksiko yang mengedepankan kepraktisan, dengan kekayaan bumbu legendaris khas Nusantara. Bayangkan sebuah kulit tortila yang di-toast hangat dan bertekstur lembut, membungkus sempurna porsi ideal dari nasi putih yang pulen, potongan daging ayam tanpa tulang yang empuk, serta irisan tomat dan timun segar. Dengan memadukan bahan-bahan tersebut dan bumbu masakan tradisional yang medok serta kaya rempah, Biterito sukses membawa sensasi makan "nasi rames" atau "nasi Padang" ke dalam satu genggaman tangan yang rapi dan bersih.
                </p>
                <p style="font-size: 0.85rem; color: #5c3a2e; line-height: 1.75; margin: 0 0 0.9rem; text-align: justify;">
                    Kami percaya bahwa menikmati makanan lezat dan bergizi tidak seharusnya merepotkan. Didesain dengan konsep wrap yang praktis dan anti-ribet, Anda tidak perlu lagi menyiapkan piring, sendok, atau khawatir tangan menjadi kotor. Biterito memungkinkan Anda menyantap hidangan berat dengan nyaman sambil bekerja di depan laptop, melakukan pertemuan, atau bahkan saat sedang sibuk di perjalanan.
                </p>
                <p style="font-size: 0.85rem; color: #5c3a2e; line-height: 1.75; margin: 0 0 0.9rem; text-align: justify;">
                    Meski dikemas dalam format yang sangat modern, kami menjaga komitmen penuh pada urusan cita rasa. Bumbu kami diracik dengan dedikasi menggunakan rempah-rempah pilihan untuk memastikan 100% sensasi rasa autentiknya tetap utuh di setiap gigitan. Lebih dari sekadar camilan, Biterito adalah hidangan dengan gizi seimbang yang mengenyangkan — kombinasi karbohidrat, protein tinggi, serta vitamin dari sayuran segar, hanya dengan Rp&nbsp;17.000.
                </p>
                <p style="font-size: 0.85rem; color: #5c3a2e; line-height: 1.75; margin: 0; text-align: justify;">
                    Apa pun selera Anda, kami selalu memiliki jawabannya melalui tiga pilihan rasa legendaris: kehangatan varian <strong>Gulai</strong> yang gurih dan creamy, sengatan pedas varian <strong>Balado</strong> yang menggugah selera, hingga primadona kebanggaan kita semua: varian <strong>Rendang</strong> dengan bumbu rempahnya yang pekat dan meresap sempurna.
                </p>
            </div>
        </div>

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
                <div style="flex: 1;">
                    <p id="desc-makanan-{{ $product->id }}" style="font-size: 0.85rem; color: #7a5a5a; margin: 0; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-align: justify;">{{ $product->description }}</p>
                    <button onclick="toggleDesc('desc-makanan-{{ $product->id }}', this)" style="background: none; border: none; color: #b73f2e; font-size: 0.78rem; font-weight: 600; cursor: pointer; padding: 0.15rem 0 0; font-family: 'Fredoka', sans-serif;">Baca selengkapnya</button>
                </div>
                <div style="display: flex; align-items: center; justify-content: space-between; margin-top: 1rem; padding-top: 0.75rem; border-top: 1px solid #f0ebe0;">
                    <span style="font-weight: 800; font-size: 1.15rem; color: #b73f2e;">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </span>
                    <button onclick="addToCart({{ $product->id }}, '{{ addslashes($product->name) }}', {{ $product->price }}, '{{ $product->image ? asset('images/products/'.$product->image) : '' }}')"
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
                <div style="flex: 1;">
                    <p id="desc-minuman-{{ $product->id }}" style="font-size: 0.85rem; color: #7a5a5a; margin: 0; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-align: justify;">{{ $product->description }}</p>
                    <button onclick="toggleDesc('desc-minuman-{{ $product->id }}', this)" style="background: none; border: none; color: #db5c26; font-size: 0.78rem; font-weight: 600; cursor: pointer; padding: 0.15rem 0 0; font-family: 'Fredoka', sans-serif;">Baca selengkapnya</button>
                </div>
                <div style="display: flex; align-items: center; justify-content: space-between; margin-top: 1rem; padding-top: 0.75rem; border-top: 1px solid #f0ebe0;">
                    <span style="font-weight: 800; font-size: 1.15rem; color: #db5c26;">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </span>
                    <button onclick="addToCart({{ $product->id }}, '{{ addslashes($product->name) }}', {{ $product->price }}, '{{ $product->image ? asset('images/products/'.$product->image) : '' }}')"
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

    function addToCart(id, name, price, image) {
        const existing = cart.find(item => item.id === id);
        if (existing) {
            existing.qty += 1;
        } else {
            cart.push({ id, name, price, image: image || '', qty: 1, notes: '' });
        }
        localStorage.setItem('biterito_cart', JSON.stringify(cart));
        updateCartCount();
        showToast('✅ ' + name + ' ditambahkan!');
    }

    function toggleDesc(id, btn) {
        const p = document.getElementById(id);
        const isCollapsed = p.style.webkitLineClamp !== 'unset' && p.style.webkitLineClamp !== '';
        if (isCollapsed || p.style.webkitLineClamp === '') {
            p.style.webkitLineClamp = 'unset';
            p.style.webkitBoxOrient = 'unset';
            p.style.display = 'block';
            p.style.overflow = 'visible';
            btn.textContent = 'Sembunyikan';
        } else {
            p.style.display = '-webkit-box';
            p.style.webkitLineClamp = '2';
            p.style.webkitBoxOrient = 'vertical';
            p.style.overflow = 'hidden';
            btn.textContent = 'Baca selengkapnya';
        }
    }

    function showToast(message) {
        const toast = document.getElementById('toast');
        toast.textContent = message;
        toast.style.display = 'block';
        setTimeout(() => toast.style.display = 'none', 2500);
    }

    updateCartCount();

    function toggleStory(btn) {
        const story = document.getElementById('full-story');
        const isHidden = story.style.display === 'none';
        story.style.display = isHidden ? 'block' : 'none';
        btn.innerHTML = isHidden ? 'Sembunyikan ▴' : 'Baca cerita kami ▾';
    }

    function openStoryIfHash() {
        if (window.location.hash === '#tentang') {
            const story = document.getElementById('full-story');
            const btn = document.querySelector('[onclick="toggleStory(this)"]');
            if (story && story.style.display === 'none') {
                story.style.display = 'block';
                if (btn) btn.innerHTML = 'Sembunyikan ▴';
            }
        }
    }

    window.addEventListener('load', openStoryIfHash);
    window.addEventListener('hashchange', openStoryIfHash);
</script>
@endpush
