@extends('layouts.app')

@section('title', 'Profil — Nihongo Bu STIS')
@section('meta_description', 'Berkenalan dengan pengurus yang berdedikasi membawa Nihongo Bu STIS menjadi lebih baik.')

@push('styles')
<style>
/* ── Color tokens ── */
:root {
    --green:    #2D6A4F;
    --green-dk: #1f5240;
    --cream:    #f8f7ef;
    --cream2:   #f0efe6;
    --dark:     #1A1A2E;
    --amber:    #c9874a;
}

/* ── Hero ── */
.kep-hero {
    background: var(--cream);
    padding: 110px 16px 64px;
    text-align: center;
    position: relative;
    overflow: hidden;
}
.kep-hero-fuji {
    position: absolute;
    bottom: 0; left: 0; right: 0;
    height: 180px;
    opacity: 0.055;
    background: url("data:image/svg+xml,%3Csvg viewBox='0 0 1200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M600 20 L780 180 L420 180 Z' fill='%232D6A4F'/%3E%3Cpath d='M600 20 L820 180 L380 180 Z' fill='%232D6A4F' opacity='.4'/%3E%3C/svg%3E") center bottom / cover no-repeat;
    pointer-events: none;
}

.hero-tag {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-family: 'Noto Sans JP', sans-serif;
    font-size: 0.7rem;
    font-weight: 700;
    letter-spacing: 0.2em;
    text-transform: uppercase;
    color: var(--green);
    background: rgba(45,106,79,0.08);
    border: 1px solid rgba(45,106,79,0.2);
    border-radius: 999px;
    padding: 5px 16px;
    margin-bottom: 20px;
}
.hero-tag::before {
    content: '🌸';
    font-size: 0.75rem;
}
.hero-jp-subtitle {
    font-family: 'Noto Sans JP', sans-serif;
    font-size: 1rem;
    color: rgba(45,106,79,0.7);
    letter-spacing: 0.12em;
    margin-top: 12px;
    margin-bottom: 16px;
}
.hero-desc {
    font-family: 'Noto Sans JP', sans-serif;
    color: #6B7280;
    font-size: 0.95rem;
    max-width: 440px;
    margin: 0 auto;
    line-height: 1.9;
}

/* ── Divider label ── */
.section-divider {
    display: flex;
    align-items: center;
    gap: 14px;
    margin-bottom: 32px;
}
.section-divider::before, .section-divider::after {
    content: '';
    flex: 1;
    height: 1px;
    background: linear-gradient(to right, transparent, rgba(45,106,79,0.2), transparent);
}
.section-divider-inner {
    display: flex;
    align-items: center;
    gap: 7px;
    font-family: 'Noto Sans JP', sans-serif;
    font-size: 0.67rem;
    font-weight: 700;
    letter-spacing: 0.22em;
    text-transform: uppercase;
    color: var(--green);
    white-space: nowrap;
}

/* ── Pengurus Inti Grid ── */
.pi-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 16px;
    max-width: 700px;
    margin: 0 auto;
}
@media (min-width: 640px) { .pi-grid { gap: 20px; } }
@media (min-width: 900px) { .pi-grid { grid-template-columns: repeat(4, 1fr); max-width: 100%; } }

.pi-card {
    background: #ffffff;
    border-radius: 22px;
    padding: 28px 18px 22px;
    text-align: center;
    position: relative;
    overflow: hidden;
    border: 1px solid rgba(45,106,79,0.09);
    box-shadow: 0 2px 12px rgba(45,106,79,0.06);
    transition: transform 320ms ease, box-shadow 320ms ease;
}
.pi-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 20px 48px rgba(45,106,79,0.13);
}
/* Gradient top accent — different per jabatan */
.pi-card::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 4px;
    border-radius: 22px 22px 0 0;
}
.pi-card-ketua::before        { background: linear-gradient(90deg, #2D6A4F, #52B788); }
.pi-card-wakil::before         { background: linear-gradient(90deg, #52B788, #95D5B2); }
.pi-card-sekretaris::before    { background: linear-gradient(90deg, #c9874a, #e6a96a); }
.pi-card-bendahara::before     { background: linear-gradient(90deg, #9b7ec8, #c4aef0); }

/* Soft circle bg on avatar */
.pi-avatar-wrap {
    position: relative;
    width: 76px;
    height: 76px;
    margin: 0 auto 16px;
}
.pi-avatar-bg {
    position: absolute;
    inset: -6px;
    border-radius: 50%;
    opacity: 0.12;
}
.pi-avatar {
    position: relative;
    width: 76px;
    height: 76px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-family: 'Zen Kurenaido', serif;
    font-size: 2rem;
    font-weight: 700;
    border: 2px solid;
}
/* Per jabatan colors */
.pi-card-ketua     .pi-avatar { background: rgba(45,106,79,0.08);  border-color: rgba(45,106,79,0.2);  color: #2D6A4F; }
.pi-card-wakil     .pi-avatar { background: rgba(82,183,136,0.1);  border-color: rgba(82,183,136,0.25); color: #52B788; }
.pi-card-sekretaris .pi-avatar { background: rgba(201,135,74,0.1); border-color: rgba(201,135,74,0.25); color: #c9874a; }
.pi-card-bendahara  .pi-avatar { background: rgba(155,126,200,0.1);border-color: rgba(155,126,200,0.25);color: #9b7ec8; }

.pi-card-ketua      .pi-avatar-bg { background: #2D6A4F; }
.pi-card-wakil      .pi-avatar-bg { background: #52B788; }
.pi-card-sekretaris .pi-avatar-bg { background: #c9874a; }
.pi-card-bendahara  .pi-avatar-bg { background: #9b7ec8; }

.pi-badge {
    display: inline-block;
    font-size: 0.6rem;
    font-weight: 700;
    letter-spacing: 0.14em;
    text-transform: uppercase;
    border-radius: 999px;
    padding: 3px 10px;
    margin-bottom: 10px;
    border: 1px solid;
}
.pi-card-ketua      .pi-badge { color: #2D6A4F; background: rgba(45,106,79,0.08);  border-color: rgba(45,106,79,0.2);  }
.pi-card-wakil      .pi-badge { color: #3a9c6b; background: rgba(82,183,136,0.08); border-color: rgba(82,183,136,0.2); }
.pi-card-sekretaris .pi-badge { color: #b07030; background: rgba(201,135,74,0.09); border-color: rgba(201,135,74,0.2); }
.pi-card-bendahara  .pi-badge { color: #7a5eaa; background: rgba(155,126,200,0.09);border-color: rgba(155,126,200,0.2);}

.pi-nama {
    font-family: 'Sawarabi Mincho', serif;
    font-size: 1rem;
    font-weight: 700;
    color: var(--dark);
    line-height: 1.3;
    margin-bottom: 4px;
}
.pi-nim {
    font-size: 0.72rem;
    color: #9CA3AF;
    font-family: 'Noto Sans JP', sans-serif;
}

/* ── Divisi Cards ── */
.div-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 24px;
}
@media (min-width: 768px) { .div-grid { grid-template-columns: repeat(3, 1fr); } }

.div-card {
    background: #fff;
    border: 1px solid rgba(0,0,0,0.07);
    border-radius: 22px;
    overflow: hidden;
    box-shadow: 0 4px 18px rgba(0,0,0,0.05);
    transition: transform 300ms ease, box-shadow 300ms ease;
    display: flex;
    flex-direction: column;
}
.div-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 18px 42px rgba(0,0,0,0.09);
}
.div-card-top {
    padding: 32px 24px 20px;
    text-align: center;
    position: relative;
}
.div-card-top::after {
    content: '';
    position: absolute;
    bottom: 0; left: 24px; right: 24px;
    height: 1px;
    background: linear-gradient(to right, transparent, rgba(0,0,0,0.08), transparent);
}

.div-icon {
    width: 60px; height: 60px;
    border-radius: 18px;
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 14px;
    font-size: 1.7rem;
}
.div-nama-text {
    font-family: 'Sawarabi Mincho', serif;
    font-size: 1.1rem;
    font-weight: 700;
    color: var(--dark);
    margin-bottom: 6px;
}
.div-deskripsi {
    font-size: 0.78rem;
    color: #9CA3AF;
    font-family: 'Noto Sans JP', sans-serif;
    line-height: 1.6;
}
.div-ketua-section {
    padding: 16px 24px;
    background: rgba(0,0,0,0.015);
    border-bottom: 1px solid rgba(0,0,0,0.05);
}
.div-ketua-label {
    font-size: 0.6rem;
    font-weight: 700;
    letter-spacing: 0.18em;
    text-transform: uppercase;
    color: var(--amber);
    font-family: 'Noto Sans JP', sans-serif;
    margin-bottom: 4px;
}
.div-ketua-nama {
    font-family: 'Sawarabi Mincho', serif;
    font-size: 0.92rem;
    font-weight: 600;
    color: var(--dark);
}
.div-ketua-nim {
    font-size: 0.7rem;
    color: #9CA3AF;
    font-family: 'Noto Sans JP', sans-serif;
}
.div-anggota-section {
    padding: 12px 24px 20px;
    flex: 1;
}
.div-anggota-label {
    font-size: 0.58rem;
    font-weight: 700;
    letter-spacing: 0.18em;
    text-transform: uppercase;
    color: #C4C4C4;
    font-family: 'Noto Sans JP', sans-serif;
    margin-bottom: 8px;
}
.div-anggota-item {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 5px 0;
}
.div-anggota-dot {
    width: 5px; height: 5px;
    border-radius: 50%;
    flex-shrink: 0;
    opacity: 0.5;
}
.div-anggota-name {
    font-size: 0.82rem;
    color: #4B5563;
    font-family: 'Noto Sans JP', sans-serif;
}
.div-anggota-nim {
    font-size: 0.68rem;
    color: #D1D5DB;
    margin-left: auto;
}
</style>
@endpush

@section('content')

{{-- ══════════ MAIN ══════════ --}}
<main class="pt-32" style="background: var(--cream); padding-bottom: 80px; min-height: 100vh;">

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
    
        {{-- JUDUL HALAMAN --}}
        <div class="text-center mb-16 reveal">
            <h1 class="text-3xl md:text-4xl font-bold text-[#1A1A2E] tracking-tight" style="font-family:'Zen Kurenaido', serif;">
                Struktur Kepengurusan
            </h1>
        </div>

        {{-- ── PENGURUS INTI ── --}}
        <section class="mb-20 reveal">
            <div class="section-divider">
                <div class="section-divider-inner">
                    <span>🏮</span>
                    <span>Pengurus Inti</span>
                </div>
            </div>

            @php
                $jabatanClass = [
                    'Ketua'       => 'pi-card-ketua',
                    'Wakil Ketua' => 'pi-card-wakil',
                    'Sekretaris'  => 'pi-card-sekretaris',
                    'Bendahara'   => 'pi-card-bendahara',
                ];
                $kanjiJabatan = [
                    'Ketua'       => '長',
                    'Wakil Ketua' => '副',
                    'Sekretaris'  => '記',
                    'Bendahara'   => '財',
                ];
            @endphp

            <div class="pi-grid">
                @forelse($pengurusInti as $p)
                @php 
                    $cls = $jabatanClass[$p->jabatan] ?? 'pi-card-ketua'; 
                    $kanji = $kanjiJabatan[$p->jabatan] ?? '員';
                @endphp
                <div class="pi-card {{ $cls }}">
                    <div class="pi-avatar-wrap">
                        <div class="pi-avatar-bg"></div>
                        <div class="pi-avatar" style="font-family: 'Noto Sans JP', sans-serif;">{{ $kanji }}</div>
                    </div>
                    <div class="pi-badge">{{ $p->jabatan }}</div>
                    <div class="pi-nama">{{ $p->nama }}</div>
                    @if($p->nim)
                    <div class="pi-nim">NIM {{ $p->nim }}</div>
                    @endif
                </div>
                @empty
                <div class="col-span-4 text-center py-14 text-gray-400 italic text-sm">
                    Data pengurus inti belum tersedia.
                </div>
                @endforelse
            </div>
        </section>

        {{-- ── DIVISI ── --}}
        <section class="reveal">
            <div class="section-divider">
                <div class="section-divider-inner">
                    <span>🗂</span>
                    <span>Divisi Kami</span>
                </div>
            </div>

            @php
                $divisiConfig = [
                    'bahasa' => ['icon' => '語', 'bg' => 'rgba(45,106,79,0.1)',   'color' => '#2D6A4F',  'dot' => '#52B788'],
                    'budaya' => ['icon' => '文', 'bg' => 'rgba(231,111,81,0.1)', 'color' => '#E76F51',  'dot' => '#E76F51'],
                    'hpd'    => ['icon' => '広', 'bg' => 'rgba(201,135,74,0.12)','color' => '#c9874a',  'dot' => '#c9874a'],
                ];
            @endphp

            <div class="div-grid">
                @forelse($divisi as $div)
                @php
                    $cfg    = $divisiConfig[$div->slug] ?? ['icon'=>'🌸','bg'=>'rgba(45,106,79,0.1)','color'=>'#2D6A4F','dot'=>'#52B788'];
                    $ketua  = $div->anggota->firstWhere('jabatan','Ketua Divisi');
                    $members= $div->anggota->where('jabatan','Anggota');
                @endphp
                <div class="div-card">
                    {{-- Top section --}}
                    <div class="div-card-top">
                        <div class="div-icon" style="background:{{ $cfg['bg'] }}; color:{{ $cfg['color'] }}; font-family: 'Noto Sans JP', sans-serif;">{{ $cfg['icon'] }}</div>
                        <div class="div-nama-text">{{ $div->nama }}</div>
                        @if($div->deskripsi)
                        <p class="div-deskripsi">{{ $div->deskripsi }}</p>
                        @endif
                    </div>

                    {{-- Ketua Divisi --}}
                    <div class="div-ketua-section">
                        <div class="div-ketua-label">Ketua Divisi</div>
                        @if($ketua)
                            <div class="div-ketua-nama" style="color:{{ $cfg['color'] }};">{{ $ketua->nama }}</div>
                            @if($ketua->nim)
                            <div class="div-ketua-nim">NIM {{ $ketua->nim }}</div>
                            @endif
                        @else
                            <div class="div-ketua-nama" style="color:#ccc;font-style:italic;">Belum ditentukan</div>
                        @endif
                    </div>

                    {{-- Anggota list --}}
                    @if($members->isNotEmpty())
                    <div class="div-anggota-section">
                        <div class="div-anggota-label">Anggota</div>
                        @foreach($members as $a)
                        <div class="div-anggota-item">
                            <span class="div-anggota-dot" style="background:{{ $cfg['dot'] }};"></span>
                            <span class="div-anggota-name">{{ $a->nama }}</span>
                            @if($a->nim)
                            <span class="div-anggota-nim">{{ $a->nim }}</span>
                            @endif
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="div-anggota-section" style="color:#ccc;font-size:0.8rem;font-style:italic;padding-top:14px;">
                        Anggota belum ditambahkan.
                    </div>
                    @endif
                </div>
                @empty
                <div class="col-span-3 text-center py-14 text-gray-400 italic text-sm">
                    Data divisi belum tersedia.
                </div>
                @endforelse
            </div>
        </section>

    </div>
</main>

@endsection
