@extends('layouts.app')

@section('title', 'Kegiatan UKM')
@section('meta_description', 'Kegiatan terbaru dan event dari UKM Nihon STIS — workshop, pertemuan, dan acara seru.')

@push('styles')
<style>
    .line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
    .filter-bar { width: 90%; max-width: 1100px; margin: 0 auto; background: rgba(255,255,255,0.97); border: 1px solid rgba(229,224,216,0.8); border-radius: 16px; box-shadow: 0 4px 24px rgba(214,151,94,0.06); padding: 12px 20px; display: grid; grid-template-columns: 1fr auto 1fr; align-items: center; gap: 12px; }
    .filter-search { position: relative; max-width: 400px; width: 100%; z-index: 2; }
    .search-input { border: 1.5px solid #E5E0D8; border-radius: 10px; padding: 8px 12px 8px 36px; font-size: 0.85rem; font-family: 'Noto Sans JP', sans-serif; background: #faf9f5; color: #1A1A2E; width: 100%; transition: border-color 0.2s, box-shadow 0.2s; outline: none; }
    .search-input:focus { border-color: #d6975e; box-shadow: 0 0 0 3px rgba(214,151,94,0.1); background: #fff; }
    .search-icon { position: absolute; left: 11px; top: 50%; transform: translateY(-50%); width: 16px; height: 16px; color: #9CA3AF; pointer-events: none; }
    .filter-cats { display: flex; align-items: center; justify-content: center; gap: 4px; overflow-x: auto; scrollbar-width: none; grid-column: 2; z-index: 1; }
    .filter-cats::-webkit-scrollbar { display: none; }
    .cat-btn { padding: 6px 14px; border-radius: 999px; font-size: 0.82rem; font-family: 'Sawarabi Mincho', serif; border: 1.5px solid transparent; background: transparent; color: #6B7280; cursor: pointer; transition: all 0.2s; white-space: nowrap; }
    .cat-btn:hover { color: #d6975e; border-color: rgba(214,151,94,0.15); background: rgba(214,151,94,0.04); }
    .cat-btn.active { color: #fff; background: #d6975e; border-color: #d6975e; font-weight: 600; }
    .article-section { width: 90%; max-width: 1200px; margin: 0 auto; }
    .article-card-link { display: block; position: relative; border-radius: 16px; overflow: hidden; aspect-ratio: 4/3; transition: transform 0.35s ease, box-shadow 0.35s ease; }
    .article-card-link:hover { transform: translateY(-4px); box-shadow: 0 12px 28px rgba(0,0,0,0.12); }
    .article-card-link img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.6s ease; }
    .article-card-link:hover img { transform: scale(1.06); }
    .article-card-overlay { position: absolute; inset: 0; background: linear-gradient(to top, rgba(0,0,0,0.6) 0%, rgba(0,0,0,0.15) 50%, rgba(0,0,0,0.08) 100%); display: flex; flex-direction: column; justify-content: flex-end; padding: 20px; }
    .article-card-title { color: #fff; font-family: 'Noto Sans JP', sans-serif; font-weight: 700; font-size: 1.1rem; line-height: 1.35; text-shadow: 0 2px 8px rgba(0,0,0,0.35); margin-bottom: 6px; }
    .article-card-meta { display: flex; align-items: center; gap: 8px; font-size: 0.7rem; color: rgba(255,255,255,0.75); text-transform: uppercase; letter-spacing: 0.05em; }
    .article-card-badges { position: absolute; top: 12px; left: 12px; display: flex; gap: 6px; }
    .badge-cat { background: rgba(255,255,255,0.9); backdrop-filter: blur(6px); color: #d6975e; font-size: 10px; font-weight: 700; padding: 3px 10px; border-radius: 999px; text-transform: uppercase; letter-spacing: 0.06em; }
    .card-placeholder {
        width: 100%; height: 100%;
        background: linear-gradient(135deg, #d6975e 0%, #ba8352 40%, #946942 100%);
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
    .pagination-bar { display: flex; align-items: center; justify-content: center; gap: 6px; margin-top: 2rem; }
    .page-btn { width: 36px; height: 36px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 0.85rem; font-weight: 600; border: 1.5px solid #E5E0D8; background: #fff; color: #6B7280; cursor: pointer; transition: all 0.2s; font-family: 'Noto Sans JP', sans-serif; }
    .page-btn:hover:not(.active):not(:disabled) { border-color: #d6975e; color: #d6975e; }
    .page-btn.active { background: #d6975e; color: #fff; border-color: #d6975e; }
    .page-btn:disabled { opacity: 0.4; cursor: default; }
    .search-highlight { background: #FEF9C3; border-radius: 2px; }
    @media (max-width: 1024px) { .article-section { width: 85%; } }
    @media (max-width: 768px) {
        .filter-bar { width: 95%; display: flex; flex-direction: column; gap: 10px; padding: 12px 14px; }
        .filter-search { flex: none; width: 100%; max-width: 100%; }
        .filter-cats { width: 100%; justify-content: center; flex-wrap: wrap; gap: 6px; }
        .article-section { width: 95%; }
    }
</style>
@endpush

@section('content')

{{-- Hero --}}
<section class="relative w-full min-h-[420px] md:min-h-[500px] overflow-hidden flex items-end p-8 md:p-12"
    style="background: linear-gradient(to bottom, rgba(21,28,39,0.15), rgba(21,28,39,0.7)), url('{{ asset('images/hero-bahasa.jpg') }}') center/cover no-repeat; background-color: #d6975e;">
    <div class="absolute inset-0 bg-gradient-to-t from-[#151c27]/80 via-[#151c27]/20 to-transparent"></div>
    <div class="relative z-10 max-w-4xl">
        <span class="text-white/80 text-xl tracking-widest mb-4 block" style="font-family: 'Noto Sans JP';">活動の記録</span>
        <h1 class="text-4xl md:text-6xl lg:text-7xl font-bold text-white tracking-tight leading-tight mb-6" style="font-family: 'Zen Kurenaido', serif;">
            Kegiatan &<br>Event UKM
        </h1>
        <p class="text-lg text-white/90 max-w-xl font-light" style="font-family: 'Noto Sans JP';">
            Ikuti perkembangan kegiatan, workshop, dan event seru dari UKM Nihon STIS.
        </p>
    </div>
</section>

{{-- Filter --}}
<section class="py-8 md:py-10" style="background: #f8f7ef;">
    <div class="filter-bar">
        <div class="filter-search">
            <svg class="search-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0"/></svg>
            <input type="text" id="articleSearch" class="search-input" placeholder="Cari kegiatan..." autocomplete="off">
        </div>
        <div class="filter-cats">
            @foreach($allCategories as $category)
            <button class="cat-btn {{ $loop->first ? 'active' : '' }}" data-cat="{{ $category->slug }}" onclick="setCategory('{{ $category->slug }}')">{{ $category->name }}</button>
            @endforeach
        </div>
    </div>
</section>

{{-- Articles --}}
<section class="pb-16 md:pb-24" style="background: #f8f7ef;">
    <div class="article-section">
        @foreach($allCategories as $category)
        <div id="cat-section-{{ $category->slug }}" class="cat-section {{ $loop->first ? '' : 'hidden' }}" data-cat="{{ $category->slug }}">
            <div class="flex items-center justify-between mb-8 border-b border-gray-200/40 pb-4">
                <h2 class="text-2xl text-gray-800" style="font-family: 'Sawarabi Mincho', serif;">{{ $category->name }}</h2>
                <span class="text-sm text-gray-400 visible-count"></span>
            </div>
            @php $catWithData = $categories->firstWhere('id', $category->id); $articles = $catWithData ? $catWithData->articles : collect(); @endphp
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6 article-grid">
                @forelse($articles as $article)
                <article class="article-card" data-title="{{ strtolower($article->title) }}" data-excerpt="{{ strtolower(strip_tags($article->excerpt ?? $article->content ?? '')) }}">
                    <a href="{{ route('kegiatan.show', $article->slug) }}" class="article-card-link">
                        @if($article->cover_image)
                            <img src="{{ asset('storage/' . $article->cover_image) }}" alt="{{ $article->title }}">
                        @else
                            @php
                                $kanjiMap = [
                                    'event' => '祭',
                                    'kegiatan-terbaru' => '活',
                                ];
                                $placeholderKanji = $kanjiMap[$category->slug] ?? '活';
                            @endphp
                            <div class="card-placeholder">
                                <span class="card-placeholder-text">{{ $placeholderKanji }}</span>
                                <span class="card-placeholder-label">{{ $category->name }}</span>
                            </div>
                        @endif
                        <div class="article-card-overlay">
                            <h3 class="article-card-title article-title-text">{{ $article->title }}</h3>
                            <div class="article-card-meta">
                                @if($article->user)<span>{{ $article->user->name ?? 'Admin' }}</span><span>•</span>@endif
                                @if($article->read_time)<span>{{ $article->read_time }} min</span>@endif
                            </div>
                        </div>
                        <div class="article-card-badges"><span class="badge-cat">{{ $category->name }}</span></div>
                    </a>
                </article>
                @empty
                <div class="col-span-full py-16 text-center bg-white/50 rounded-2xl border border-gray-100">
                    <span class="text-5xl mb-4 block">🍃</span>
                    <h3 class="text-lg font-medium text-gray-800 mb-1" style="font-family: 'Sawarabi Mincho', serif;">Belum Ada Kegiatan</h3>
                    <p class="text-gray-500 text-sm">Materi sedang disiapkan.</p>
                </div>
                @endforelse
            </div>
            <div class="pagination-bar pagination-container" style="display:none;"></div>
            <div class="no-results hidden col-span-full py-16 flex flex-col items-center justify-center text-center bg-white/50 rounded-2xl border border-gray-100 mb-8">
                <span class="text-5xl mb-4 block">🔍</span>
                <h3 class="text-lg font-medium text-gray-800 mb-1" style="font-family: 'Sawarabi Mincho', serif;">Tidak ada hasil</h3>
                <p class="text-gray-500 text-sm">Coba kata kunci lain.</p>
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
    let activeCat = urlParams.get('cat') || '{{ $allCategories->first()->slug ?? '' }}';
    let searchQ = '';
    let pages = {};

    if (activeCat) {
        setTimeout(() => {
            if (document.querySelector(`.cat-btn[data-cat="${activeCat}"]`)) {
                window.setCategory(activeCat);
            }
        }, 100);
    }

    window.setCategory = function(slug) {
        activeCat = slug;
        document.querySelectorAll('.cat-btn').forEach(b => b.classList.toggle('active', b.dataset.cat === slug));
        document.querySelectorAll('.cat-section').forEach(s => s.classList.toggle('hidden', s.dataset.cat !== slug));
        if (!pages[slug]) pages[slug] = 1;
        apply();
    };

    function fuzzy(text, q) { if (!q) return 1; q = q.toLowerCase(); text = text.toLowerCase(); if (text.includes(q)) return 3; if (text.split(/\s+/).some(w => w.startsWith(q))) return 2; let qi=0; for (let i=0;i<text.length&&qi<q.length;i++) if (text[i]===q[qi]) qi++; if (qi===q.length) return 1; if (q.length>=4) for (let s=0;s<q.length;s++) { if (text.includes(q.slice(0,s)+q.slice(s+1))) return 0.5; } return 0; }

    function apply() {
        const sec = document.querySelector(`.cat-section[data-cat="${activeCat}"]`);
        if (!sec) return;
        const cards = Array.from(sec.querySelectorAll('.article-card'));
        const noR = sec.querySelector('.no-results');
        const pagC = sec.querySelector('.pagination-container');
        const cntEl = sec.querySelector('.visible-count');
        const matching = cards.filter(c => { const t = c.dataset.title||''; const e = c.dataset.excerpt||''; return !searchQ || fuzzy(t+' '+e, searchQ) > 0; });
        const p = Math.min(pages[activeCat]||1, Math.max(1, Math.ceil(matching.length/PER_PAGE)));
        pages[activeCat]=p; const s=(p-1)*PER_PAGE, en=s+PER_PAGE;
        cards.forEach(c => c.style.display='none');
        matching.forEach((c,i) => c.style.display = (i>=s&&i<en)?'':'none');
        if (cntEl) cntEl.textContent = matching.length + ' artikel';
        if (noR) { if (cards.length>0&&matching.length===0) noR.classList.remove('hidden'); else noR.classList.add('hidden'); }
        renderPag(pagC, p, Math.max(1,Math.ceil(matching.length/PER_PAGE)), matching.length);
    }

    function renderPag(c, cur, tot, cnt) { if (!c) return; if (cnt<=PER_PAGE){c.style.display='none';return;} c.style.display='flex'; let h=`<button class="page-btn" onclick="goP(${cur-1})" ${cur<=1?'disabled':''}>←</button>`; let ps=[]; if(tot<=7){for(let i=1;i<=tot;i++)ps.push(i);}else{ps=[1];if(cur>3)ps.push('...');for(let i=Math.max(2,cur-1);i<=Math.min(tot-1,cur+1);i++)ps.push(i);if(cur<tot-2)ps.push('...');ps.push(tot);} ps.forEach(p=>{if(p==='...')h+=`<span style="padding:0 4px;color:#9CA3AF;">…</span>`;else h+=`<button class="page-btn ${p===cur?'active':''}" onclick="goP(${p})">${p}</button>`;}); h+=`<button class="page-btn" onclick="goP(${cur+1})" ${cur>=tot?'disabled':''}>→</button>`; c.innerHTML=h; }
    window.goP = function(p) { pages[activeCat]=p; apply(); document.querySelector('.filter-bar')?.scrollIntoView({behavior:'smooth',block:'start'}); };

    const si = document.getElementById('articleSearch');
    if (si) { let t; si.addEventListener('input', function(){ clearTimeout(t); t=setTimeout(()=>{ searchQ=si.value.trim(); pages[activeCat]=1; apply(); },200); }); }
    apply();
})();
</script>
@endpush
