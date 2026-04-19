<style>
.pag-wrap { display: flex; align-items: center; gap: 0.3rem; flex-wrap: wrap; }
.pag-btn {
    min-width: 2rem;
    height: 2rem;
    padding: 0 0.5rem;
    border-radius: 0.4rem;
    border: 1.5px solid #e5e7eb;
    background: white;
    color: #374151;
    font-size: 0.8rem;
    font-weight: 500;
    font-family: 'Poppins', sans-serif;
    cursor: pointer;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    transition: all 0.15s;
}
.pag-btn:hover { border-color: #dc2626; color: #dc2626; }
.pag-btn.active { background: #dc2626; border-color: #dc2626; color: white; font-weight: 700; }
.pag-btn.disabled { opacity: 0.4; cursor: not-allowed; pointer-events: none; }
.pag-dots { color: #9ca3af; font-size: 0.8rem; padding: 0 0.2rem; }
</style>

<div class="pag-wrap">
    {{-- Prev --}}
    @if($paginator->onFirstPage())
        <span class="pag-btn disabled">‹</span>
    @else
        <a href="{{ $paginator->previousPageUrl() }}" class="pag-btn">‹</a>
    @endif

    {{-- Page numbers --}}
    @php
        $current = $paginator->currentPage();
        $last    = $paginator->lastPage();
        $window  = 2; // pages around current
        $pages   = [];

        for ($i = 1; $i <= $last; $i++) {
            if ($i == 1 || $i == $last || abs($i - $current) <= $window) {
                $pages[] = $i;
            }
        }
        $pages = array_unique($pages);
        sort($pages);
    @endphp

    @php $prev = null; @endphp
    @foreach($pages as $page)
        @if($prev !== null && $page - $prev > 1)
            <span class="pag-dots">…</span>
        @endif

        @if($page == $current)
            <span class="pag-btn active">{{ $page }}</span>
        @else
            <a href="{{ $paginator->url($page) }}" class="pag-btn">{{ $page }}</a>
        @endif

        @php $prev = $page; @endphp
    @endforeach

    {{-- Next --}}
    @if($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}" class="pag-btn">›</a>
    @else
        <span class="pag-btn disabled">›</span>
    @endif
</div>
