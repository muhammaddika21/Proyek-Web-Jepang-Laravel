{{-- Reusable Article Card Component --}}
<a href="{{ $link ?? '#' }}" class="group block bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl border border-gray-100 hover:border-[#448646]/20 transition-all duration-300 hover:-translate-y-1">
    <div class="p-6">
        <span class="inline-block px-3 py-1 bg-[#448646]/10 text-[#448646] text-xs font-semibold rounded-full mb-4">
            {{ $meta ?? 'Materi' }}
        </span>
        <h3 class="text-lg font-bold text-[#296751] mb-2 group-hover:text-[#448646] transition-colors">
            {{ $title ?? 'Judul Artikel' }}
        </h3>
        <p class="text-sm text-gray-500 leading-relaxed mb-4">
            {{ $desc ?? 'Deskripsi artikel...' }}
        </p>
        <span class="inline-flex items-center gap-1 text-sm font-semibold text-[#448646] group-hover:gap-2 transition-all">
            {{ $btn ?? 'Baca' }} <span class="text-lg">→</span>
        </span>
    </div>
</a>
