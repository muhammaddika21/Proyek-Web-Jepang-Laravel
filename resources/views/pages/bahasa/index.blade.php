@extends('layouts.app')

@section('title', 'Materi Bahasa Jepang')
@section('meta_description', 'Kurasi artikel dan materi belajar bahasa Jepang yang mendalam — dari dasar hingga mahir.')

@push('styles')
<style>
    .line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }

    /* ===== FILTER BAR ===== */
    .filter-bar {
        width: 95%; max-width: 1200px;
        margin: 0 auto;
        background: rgba(255,255,255,0.97);
        border: 1px solid rgba(229,224,216,0.8);
        border-radius: 16px;
        box-shadow: 0 4px 24px rgba(41,103,81,0.06);
        padding: 12px 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
    }

    /* Search */
    .filter-search {
        flex: 0 1 240px;
        position: relative;
    }
    .search-input {
        border: 1.5px solid #E5E0D8;
        border-radius: 10px;
        padding: 8px 12px 8px 36px;
        font-size: 0.85rem;
        font-family: 'Noto Sans JP', sans-serif;
        background: #faf9f5;
        color: #1A1A2E;
        width: 100%;
        transition: border-color 0.2s, box-shadow 0.2s;
        outline: none;
    }
    .search-input:focus {
        border-color: #296751;
        box-shadow: 0 0 0 3px rgba(41,103,81,0.1);
        background: #fff;
    }
    .search-icon {
        position: absolute; left: 11px; top: 50%; transform: translateY(-50%);
        width: 16px; height: 16px; color: #9CA3AF; pointer-events: none;
    }

    /* Category center */
    .filter-cats {
        flex: 1 1 auto;
        display: flex;
        align-items: center; justify-content: center;
        gap: 6px; 
        overflow-x: auto;
        scrollbar-width: none;
        -ms-overflow-style: none;
    }
    .filter-cats::-webkit-scrollbar { display: none; }

    .cat-btn {
        padding: 6px 14px;
        border-radius: 999px;
        font-size: 0.82rem;
        font-family: 'Sawarabi Mincho', serif;
        border: 1.5px solid transparent;
        background: transparent;
        color: #6B7280;
        cursor: pointer;
        transition: all 0.2s;
        white-space: nowrap;
        flex-shrink: 0;
    }
    .cat-btn:hover { color: #296751; border-color: rgba(41,103,81,0.15); background: rgba(41,103,81,0.04); }
    .cat-btn.active { color: #fff; background: #296751; border-color: #296751; font-weight: 600; }

    .filter-levels {
        flex: 0 0 auto;
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 4px;
        overflow-x: auto;
        scrollbar-width: none;
        -ms-overflow-style: none;
    }
    .filter-levels::-webkit-scrollbar { display: none; }
    .level-btn {
        padding: 5px 12px;
        border-radius: 999px;
        font-size: 0.78rem;
        font-family: 'Noto Sans JP', sans-serif;
        border: 1.5px solid transparent;
        background: transparent;
        cursor: pointer;
        transition: all 0.2s;
        white-space: nowrap;
        color: #9CA3AF;
        flex-shrink: 0;
    }
    .level-btn:hover { background: #f0f4f2; }
    .level-btn.active-all,
    .level-btn.active-pemula,
    .level-btn.active-menengah,
    .level-btn.active-mahir {
        color: #296751; 
        border-color: rgba(41,103,81,0.3); 
        background: rgba(41,103,81,0.08); 
        font-weight: 600; 
    }

    /* ===== ARTICLE SECTION ===== */
    .article-section {
        width: 90%;
        max-width: 1200px;
        margin: 0 auto;
    }

    /* ===== ARTICLE CARD ===== */
    .article-card-link {
        display: block;
        position: relative;
        border-radius: 16px;
        overflow: hidden;
        aspect-ratio: 4/3;
        transition: transform 0.35s ease, box-shadow 0.35s ease;
    }
    .article-card-link:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 28px rgba(0,0,0,0.12);
    }
    .article-card-link img {
        width: 100%; height: 100%; object-fit: cover;
        transition: transform 0.6s ease;
    }
    .article-card-link:hover img { transform: scale(1.06); }
    .article-card-overlay {
        position: absolute; inset: 0;
        background: linear-gradient(to top, rgba(0,0,0,0.6) 0%, rgba(0,0,0,0.15) 50%, rgba(0,0,0,0.08) 100%);
        display: flex; flex-direction: column; justify-content: flex-end;
        padding: 20px;
    }
    .article-card-title {
        color: #fff;
        font-family: 'Noto Sans JP', sans-serif;
        font-weight: 700;
        font-size: 1.1rem;
        line-height: 1.35;
        text-shadow: 0 2px 8px rgba(0,0,0,0.35);
        margin-bottom: 6px;
    }
    .article-card-meta {
        display: flex; align-items: center; gap: 8px;
        font-size: 0.7rem; color: rgba(255,255,255,0.75);
        text-transform: uppercase; letter-spacing: 0.05em;
    }
    .article-card-badges {
        position: absolute; top: 12px; left: 12px;
        display: flex; gap: 6px;
    }
    .badge-cat {
        background: rgba(255,255,255,0.9); backdrop-filter: blur(6px);
        color: #296751; font-size: 10px; font-weight: 700;
        padding: 3px 10px; border-radius: 999px;
        text-transform: uppercase; letter-spacing: 0.06em;
    }
    .badge-level {
        font-size: 10px; font-weight: 700;
        padding: 3px 10px; border-radius: 999px;
        text-transform: uppercase; letter-spacing: 0.06em;
    }
    .badge-pemula   { background: #dcfce7; color: #166534; }
    .badge-menengah { background: #fef3c7; color: #92400e; }
    .badge-mahir    { background: #fee2e2; color: #991b1b; }
    .card-placeholder {
        width: 100%; height: 100%;
        background: linear-gradient(135deg, #296751 0%, #1c4738 40%, #102920 100%);
        display: flex; align-items: center; justify-content: center;
        position: relative;
        overflow: hidden;
    }
    .card-placeholder::before {
        content: '';
        position: absolute; inset: 0;
        background: radial-gradient(circle at 30% 70%, rgba(255,255,255,0.08) 0%, transparent 60%),
                    radial-gradient(circle at 80% 20%, rgba(255,255,255,0.06) 0%, transparent 50%);
    }
    .card-placeholder-text {
        font-family: 'Noto Sans JP', sans-serif;
        font-size: 4.5rem;
        color: rgba(255,255,255,0.15);
        font-weight: 900;
        line-height: 1;
        user-select: none;
    }
    .card-placeholder-label {
        position: absolute;
        bottom: 20px;
        left: 0; right: 0;
        text-align: center;
        font-family: 'Sawarabi Mincho', serif;
        font-size: 0.75rem;
        color: rgba(255,255,255,0.5);
        letter-spacing: 0.12em;
        text-transform: uppercase;
    }

    /* ===== PAGINATION ===== */
    .pagination-bar {
        display: flex; align-items: center; justify-content: center;
        gap: 6px; margin-top: 2rem;
    }
    .page-btn {
        width: 36px; height: 36px; border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        font-size: 0.85rem; font-weight: 600;
        border: 1.5px solid #E5E0D8;
        background: #fff; color: #6B7280;
        cursor: pointer; transition: all 0.2s;
        font-family: 'Noto Sans JP', sans-serif;
    }
    .page-btn:hover:not(.active):not(:disabled) {
        border-color: #296751; color: #296751; background: rgba(41,103,81,0.04);
    }
    .page-btn.active {
        background: #296751; color: #fff; border-color: #296751;
    }
    .page-btn:disabled { opacity: 0.4; cursor: default; }
    .page-arrow { font-size: 1rem; }

    .search-highlight { background: #FEF9C3; border-radius: 2px; padding: 0 1px; }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 1024px) {
        .article-section { width: 85%; }
        .filter-bar { padding: 10px 14px; gap: 8px; }
        .filter-search { flex: 0 1 180px; }
        .cat-btn { padding: 4px 10px; font-size: 0.76rem; }
        .level-btn { padding: 4px 10px; font-size: 0.74rem; }
    }
    @media (max-width: 768px) {
        .filter-bar {
            width: 95%;
            display: flex;
            flex-direction: column;
            gap: 10px;
            padding: 12px 14px;
        }
        .filter-search { flex: none; width: 100%; }
        .filter-cats {
            width: 100%; justify-content: center;
            flex-wrap: wrap; padding-bottom: 4px;
        }
        .filter-levels { width: 100%; justify-content: center; flex-wrap: wrap; }
        .article-section { width: 95%; }
    }
</style>
@endpush

@section('content')

@php
    $srcBahasa = base_path('gambar_subhero_bahasa.jpg');
    $destBahasa = public_path('images/gambar_subhero_bahasa.jpg');
    if (file_exists($srcBahasa) && !file_exists($destBahasa)) {
        if (!file_exists(public_path('images'))) mkdir(public_path('images'), 0755, true);
        copy($srcBahasa, $destBahasa);
    }
@endphp

{{-- Hero Section --}}
<section class="relative w-full min-h-[420px] md:min-h-[500px] overflow-hidden flex items-end p-8 md:p-12"
    style="background: linear-gradient(135deg, rgba(41,103,81,0.88), rgba(68,134,70,0.55)), url('{{ asset('images/gambar_subhero_bahasa.jpg') }}') center/cover no-repeat; background-color: #296751;">
    <div class="absolute inset-0 bg-gradient-to-t from-[#296751] via-[#296751]/30 to-transparent"></div>
    <div class="relative z-10 max-w-4xl">
        <span class="text-[#f8f7ef]/80 text-xl tracking-widest mb-4 block hero-label-slide" style="font-family: 'Noto Sans JP';">学びの道</span>
        <h1 class="text-4xl md:text-6xl lg:text-7xl font-bold text-white tracking-tight leading-tight mb-6 hero-title-slide" style="font-family: 'Zen Kurenaido', serif;">
            Menyelami Keindahan<br>Bahasa Jepang
        </h1>
        <p class="text-lg text-white/90 max-w-xl font-light hero-sub-slide" style="font-family: 'Noto Sans JP';">
            Kurasi artikel dan materi belajar yang mendalam, dirancang untuk membimbing Anda dari dasar hingga kefasihan.
        </p>
    </div>
</section>

{{-- ===== STATIC Filter Bar ===== --}}
<section class="py-8 md:py-10" style="background: #f8f7ef;">
    <div class="filter-bar filter-bar-anim">
        {{-- LEFT: Search (~28%) --}}
        <div class="filter-search">
            <svg class="search-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0"/>
            </svg>
            <input type="text" id="articleSearch" class="search-input" placeholder="Cari artikel..." autocomplete="off">
        </div>

        {{-- CENTER: Kategori --}}
        <div class="filter-cats">
            @foreach($allCategories as $category)
            <button class="cat-btn {{ $loop->first ? 'active' : '' }}" data-cat="{{ $category->slug }}" onclick="setCategory('{{ $category->slug }}')">
                {{ $category->name }}
            </button>
            @endforeach
        </div>

        {{-- RIGHT: Level --}}
        <div class="filter-levels">
            <button class="level-btn active-all" data-level="" onclick="setLevel(this, '')">Semua</button>
            <button class="level-btn" data-level="pemula" onclick="setLevel(this, 'pemula')">Pemula</button>
            <button class="level-btn" data-level="menengah" onclick="setLevel(this, 'menengah')">Menengah</button>
            <button class="level-btn" data-level="mahir" onclick="setLevel(this, 'mahir')">Mahir</button>
        </div>
    </div>
</section>

{{-- ===== Articles ===== --}}
<section class="pb-16 md:pb-24" style="background: #f8f7ef;">
    <div class="article-section">

        @foreach($allCategories as $category)
        <div id="cat-section-{{ $category->slug }}" class="cat-section {{ $loop->first ? '' : 'hidden' }}" data-cat="{{ $category->slug }}">

            <div class="flex items-center justify-between mb-8 border-b border-gray-200/40 pb-4">
                <h2 class="text-2xl text-gray-800" style="font-family: 'Sawarabi Mincho', serif;">{{ $category->name }}</h2>
                <span class="text-sm text-gray-400 visible-count"></span>
            </div>

            @php
                $catWithData = $categories->firstWhere('id', $category->id);
                $articles = $catWithData ? $catWithData->articles : collect();
            @endphp

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6 article-grid">
                @forelse($articles as $article)
                <article
                    class="article-card"
                    data-title="{{ strtolower($article->title) }}"
                    data-excerpt="{{ strtolower(strip_tags($article->excerpt ?? $article->grammar_explanation ?? $article->content ?? '')) }}"
                    data-level="{{ $article->kemahiran_level }}"
                >
                    <a href="{{ route('bahasa.show', $article->slug) }}" class="article-card-link">
                        @if($article->cover_image)
                            <img src="{{ asset('storage/' . $article->cover_image) }}" alt="{{ $article->title }}">
                        @else
                            @php
                                $kanjiMap = [
                                    'complete-guide' => '学',
                                    'kanji' => '漢',
                                    'kotoba' => '言',
                                    'bunpou' => '文',
                                    'kaiwa' => '話',
                                ];
                                $placeholderKanji = $kanjiMap[$category->slug] ?? '日';
                            @endphp
                            <div class="card-placeholder">
                                <span class="card-placeholder-text">{{ $placeholderKanji }}</span>
                                <span class="card-placeholder-label">{{ $category->name }}</span>
                            </div>
                        @endif
                        <div class="article-card-overlay">
                            <h3 class="article-card-title article-title-text">{{ $article->title }}</h3>
                            <div class="article-card-meta">
                                @if($article->user)
                                    <span>{{ $article->user->name ?? 'Admin' }}</span>
                                    <span>•</span>
                                @endif
                                @if($article->read_time)
                                    <span>{{ $article->read_time }} min</span>
                                @endif
                            </div>
                        </div>
                        <div class="article-card-badges">
                            <span class="badge-cat">{{ $category->name }}</span>
                            @if($article->kemahiran_level)
                            <span class="badge-level badge-{{ $article->kemahiran_level }}">{{ ucfirst($article->kemahiran_level) }}</span>
                            @endif
                        </div>
                    </a>
                </article>
                @empty
                <div class="col-span-full py-16 text-center bg-white/50 rounded-2xl border border-gray-100 empty-state">
                    <span class="text-5xl mb-4 block">🍃</span>
                    <h3 class="text-lg font-medium text-gray-800 mb-1" style="font-family: 'Sawarabi Mincho', serif;">Materi Sedang Disiapkan</h3>
                    <p class="text-gray-500 text-sm">Belum ada materi published untuk kategori ini.</p>
                </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            <div class="pagination-bar pagination-container" style="display:none;"></div>

            {{-- No results --}}
            <div class="no-results hidden col-span-full py-16 flex flex-col items-center justify-center text-center bg-white/50 rounded-2xl border border-gray-100 mb-8">
                <span class="text-5xl mb-4 block">🔍</span>
                <h3 class="text-lg font-medium text-gray-800 mb-1" style="font-family: 'Sawarabi Mincho', serif;">Tidak ada hasil</h3>
                <p class="text-gray-500 text-sm">Coba kata kunci lain atau ubah filter.</p>
            </div>
        </div>
        @endforeach

    </div>
</section>

@endsection

@push('scripts')
<script>
(function() {
    const PER_PAGE = 9;
    const urlParams = new URLSearchParams(window.location.search);
    let activeCategory = urlParams.get('cat') || '{{ $allCategories->first()->slug ?? '' }}';
    let activeLevel = '';
    let searchQuery = '';
    let currentPages = {}; // per-category current page

    // Pastikan tombol aktif sesuai catParam saat awal load (tanpa scroll)
    if (activeCategory) {
        setTimeout(() => {
            if (document.querySelector(`.cat-btn[data-cat="${activeCategory}"]`)) {
                window.setCategory(activeCategory);
            }
        }, 100);
    }

    // --- Category ---
    window.setCategory = function(slug) {
        activeCategory = slug;
        document.querySelectorAll('.cat-btn').forEach(b => b.classList.toggle('active', b.dataset.cat === slug));
        document.querySelectorAll('.cat-section').forEach(s => s.classList.toggle('hidden', s.dataset.cat !== slug));
        if (!currentPages[slug]) currentPages[slug] = 1;
        applyFilters();
    };

    // --- Level ---
    window.setLevel = function(btn, level) {
        activeLevel = level;
        document.querySelectorAll('.level-btn').forEach(b => b.className = 'level-btn');
        btn.className = 'level-btn ' + (level ? 'active-' + level : 'active-all');
        // reset page
        currentPages[activeCategory] = 1;
        applyFilters();
    };

    // --- Fuzzy Search ---
    function fuzzyScore(text, query) {
        if (!query) return 1;
        query = query.toLowerCase(); text = text.toLowerCase();
        if (text.includes(query)) return 3;
        const words = text.split(/\s+/);
        if (words.some(w => w.startsWith(query))) return 2;
        let qi = 0;
        for (let ci = 0; ci < text.length && qi < query.length; ci++) {
            if (text[ci] === query[qi]) qi++;
        }
        if (qi === query.length) return 1;
        if (query.length >= 4) {
            for (let skip = 0; skip < query.length; skip++) {
                const shortened = query.slice(0, skip) + query.slice(skip + 1);
                if (text.includes(shortened)) return 0.5;
            }
        }
        return 0;
    }

    // --- Apply Filters + Pagination ---
    function applyFilters() {
        const section = document.querySelector(`.cat-section[data-cat="${activeCategory}"]`);
        if (!section) return;

        const cards = Array.from(section.querySelectorAll('.article-card'));
        const noResults = section.querySelector('.no-results');
        const emptyState = section.querySelector('.empty-state');
        const pagContainer = section.querySelector('.pagination-container');
        const countEl = section.querySelector('.visible-count');

        // Filter cards
        const matchingCards = [];
        cards.forEach(card => {
            const level = card.dataset.level || '';
            const title = card.dataset.title || '';
            const excerpt = card.dataset.excerpt || '';
            const levelOk = !activeLevel || level === activeLevel;
            const searchOk = !searchQuery || fuzzyScore(title + ' ' + excerpt, searchQuery) > 0;
            if (levelOk && searchOk) { matchingCards.push(card); }
        });

        // Pagination
        const page = currentPages[activeCategory] || 1;
        const totalPages = Math.max(1, Math.ceil(matchingCards.length / PER_PAGE));
        const safeP = Math.min(page, totalPages);
        currentPages[activeCategory] = safeP;
        const start = (safeP - 1) * PER_PAGE;
        const end = start + PER_PAGE;

        // Show/hide cards
        cards.forEach(c => c.style.display = 'none');
        matchingCards.forEach((c, i) => {
            c.style.display = (i >= start && i < end) ? '' : 'none';
        });

        // Highlight
        highlightText(section, searchQuery);

        // Count
        if (countEl) countEl.textContent = matchingCards.length + ' artikel';

        // Empty / no-result
        if (emptyState) emptyState.style.display = cards.length === 0 ? '' : 'none';
        if (noResults) {
            if (cards.length > 0 && matchingCards.length === 0) {
                noResults.classList.remove('hidden');
            } else {
                noResults.classList.add('hidden');
            }
        }

        // Render pagination
        renderPagination(pagContainer, safeP, totalPages, matchingCards.length);
    }

    function renderPagination(container, current, total, count) {
        if (!container) return;
        if (count <= PER_PAGE) { container.style.display = 'none'; return; }
        container.style.display = 'flex';

        let html = '';
        html += `<button class="page-btn page-arrow" onclick="goPage(${current - 1})" ${current <= 1 ? 'disabled' : ''}>←</button>`;

        // Show max 7 page numbers
        let pages = [];
        if (total <= 7) {
            for (let i = 1; i <= total; i++) pages.push(i);
        } else {
            pages = [1];
            if (current > 3) pages.push('...');
            for (let i = Math.max(2, current - 1); i <= Math.min(total - 1, current + 1); i++) pages.push(i);
            if (current < total - 2) pages.push('...');
            pages.push(total);
        }

        pages.forEach(p => {
            if (p === '...') {
                html += `<span style="padding:0 4px;color:#9CA3AF;">…</span>`;
            } else {
                html += `<button class="page-btn ${p === current ? 'active' : ''}" onclick="goPage(${p})">${p}</button>`;
            }
        });

        html += `<button class="page-btn page-arrow" onclick="goPage(${current + 1})" ${current >= total ? 'disabled' : ''}>→</button>`;
        container.innerHTML = html;
    }

    window.goPage = function(p) {
        currentPages[activeCategory] = p;
        applyFilters();
        // Smooth scroll ke filter bar (bukan ke atas halaman)
        const filterBar = document.querySelector('.filter-bar');
        if (filterBar) filterBar.scrollIntoView({ behavior: 'smooth', block: 'start' });
    };

    function highlightText(section, query) {
        section.querySelectorAll('.article-title-text').forEach(el => {
            const orig = el.getAttribute('data-orig') || el.textContent;
            el.setAttribute('data-orig', orig);
            if (!query) { el.innerHTML = orig; return; }
            const re = new RegExp(`(${query.replace(/[.*+?^${}()|[\]\\]/g, '\\$&')})`, 'gi');
            el.innerHTML = orig.replace(re, '<mark class="search-highlight">$1</mark>');
        });
    }

    // --- Search ---
    const searchInput = document.getElementById('articleSearch');
    if (searchInput) {
        let timer;
        searchInput.addEventListener('input', function() {
            clearTimeout(timer);
            timer = setTimeout(function() {
                searchQuery = searchInput.value.trim();
                currentPages[activeCategory] = 1;
                applyFilters();
            }, 200);
        });
    }

    applyFilters();
})();
</script>
@endpush
