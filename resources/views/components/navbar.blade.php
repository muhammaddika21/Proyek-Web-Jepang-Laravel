{{-- Navbar — Always visible, full width --}}
<header x-data="{
        open: false,
        scrolled: false,
        init() {
            window.addEventListener('scroll', () => {
                this.scrolled = window.scrollY > 50;
            });
        }
    }"
    :class="scrolled ? 'bg-white/95 shadow-lg backdrop-blur-xl border-b border-white/60' : 'bg-transparent border-b border-transparent'"
    class="fixed top-0 left-0 right-0 z-50 transition-all duration-400 ease-in-out will-change-[background-color]"
    id="mainHeader" style="-webkit-transform: translateZ(0);">
    <nav class="max-w-[1290px] mx-auto px-4 md:px-8 h-[70px] md:h-[80px] flex items-center justify-between">

        {{-- LEFT: Logo --}}
        <a href="{{ route('home') }}" class="flex items-center gap-3 group shrink-0 justify-self-start">
            <div class="w-[55px] h-[55px] rounded-full flex items-center justify-center shadow-md transition-all duration-300 overflow-hidden border-2 group-hover:shadow-lg group-hover:rotate-[5deg] group-hover:scale-105"
                :class="scrolled ? 'border-[#8fd6b0]/40 shadow-[#8fd6b0]/40' : 'border-white/40 shadow-white/20'"
                style="background: linear-gradient(135deg, #8fd6b0, #a8e6cf); transform: translateZ(0); will-change: transform;">
                @if(file_exists(public_path('images/Logo ukm nihon fix.png')))
                    <img src="{{ asset('images/Logo ukm nihon fix.png') }}" alt="Logo UKM Nihon"
                        class="w-full h-full object-cover" style="image-rendering: auto;">
                @else
                    <span class="text-white font-bold text-base">NB</span>
                @endif
            </div>
            <div>
                <h1 class="text-[1.5rem] font-bold leading-tight transition-colors duration-300"
                    :style="scrolled ? 'color: #2D6A4F;' : 'color: #f8f7ef;'"
                    style="font-family: 'Zen Kurenaido', serif;">Nihongo Bu</h1>
                <p class="text-[0.75rem] font-medium transition-colors duration-300"
                    :style="scrolled ? 'color: rgba(45,106,79, 0.7);' : 'color: #f8f7ef;'"
                    style="font-family: 'Noto Sans JP', sans-serif;">日本語と文化</p>
            </div>
        </a>

        {{-- CENTER: Navigation links --}}
        <ul class="hidden md:flex items-center justify-center gap-1">
            @php
                $navItems = [
                    ['label' => 'Home', 'href' => route('home')],
                    ['label' => 'Bahasa', 'href' => url('/bahasa')],
                    ['label' => 'Kegiatan', 'href' => url('/kegiatan')],
                    ['label' => 'Budaya', 'href' => url('/budaya')],
                ];
            @endphp

            @foreach($navItems as $item)
                <li>
                    <a href="{{ $item['href'] }}"
                        class="inline-flex items-center px-4 py-2 rounded-lg text-[1.05rem] font-semibold border border-transparent transition-all duration-300 outline-none"
                        :class="scrolled
                           ? 'text-[#2D6A4F] hover:text-[#2D6A4F] hover:bg-[rgba(45,106,79,0.08)] hover:border-[#2D6A4F]/20 hover:-translate-y-1 hover:scale-105'
                           : 'text-white hover:text-white hover:bg-white/10 hover:border-white/40 hover:-translate-y-1 hover:scale-105'">
                        {{ $item['label'] }}
                    </a>
                </li>
            @endforeach
        </ul>

        {{-- RIGHT: Login + Hamburger --}}
        <div class="flex items-center justify-self-end gap-3">
            <a href="{{ url('/admin') }}"
                class="hidden md:inline-flex items-center gap-2 px-5 py-2 rounded-full text-sm font-semibold transition-all duration-300 hover:-translate-y-0.5 hover:shadow-lg border border-transparent"
                :class="scrolled
                   ? 'bg-[#2D6A4F] text-white hover:bg-[#0F5238] shadow-[#2D6A4F]/20'
                   : 'bg-white/20 text-white border-white/30 hover:bg-white/30 backdrop-blur-sm'">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                Login
            </a>

            {{-- Hamburger (Mobile) --}}
            <button @click="open = !open"
                class="md:hidden flex flex-col justify-center items-center w-10 h-10 rounded-lg transition-colors"
                :class="scrolled ? 'hover:bg-gray-100' : 'hover:bg-white/15'" aria-label="Toggle menu" type="button">
                <span :class="[open ? 'rotate-45 translate-y-[9px]' : '', scrolled ? 'bg-[#2D6A4F]' : 'bg-white']"
                    class="block w-[28px] h-[3px] rounded-sm transition-all duration-300 origin-center"></span>
                <span :class="[open ? 'opacity-0 translate-x-[10px]' : '', scrolled ? 'bg-[#2D6A4F]' : 'bg-white']"
                    class="block w-[28px] h-[3px] rounded-sm mt-[6px] transition-all duration-300"></span>
                <span :class="[open ? '-rotate-45 -translate-y-[9px]' : '', scrolled ? 'bg-[#2D6A4F]' : 'bg-white']"
                    class="block w-[28px] h-[3px] rounded-sm mt-[6px] transition-all duration-300 origin-center"></span>
            </button>
        </div>
    </nav>

    {{-- Mobile Menu --}}
    <div x-show="open" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-2" class="md:hidden" style="background: linear-gradient(to bottom, rgba(255, 255, 255, 0.96), rgba(245, 252, 248, 0.98));
               backdrop-filter: blur(24px);
               -webkit-backdrop-filter: blur(24px);
               border-bottom: 1px solid rgba(143, 214, 176, 0.2);
               box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);">
        <ul class="px-6 py-6 space-y-3 flex flex-col items-center">
            @php
                $mobileItems = [
                    ['label' => 'Home', 'href' => route('home')],
                    ['label' => 'Bahasa', 'href' => url('/bahasa')],
                    ['label' => 'Kegiatan', 'href' => url('/kegiatan')],
                    ['label' => 'Budaya', 'href' => url('/budaya')],
                ];
            @endphp

            @foreach($mobileItems as $item)
                <li class="w-full max-w-[250px]">
                    <a href="{{ $item['href'] }}" @click="open = false"
                        class="block text-center px-6 py-3 rounded-xl text-[1.1rem] font-semibold transition-all duration-300 border border-[#2D6A4F]/20 text-[#2D6A4F] hover:bg-[#2D6A4F] hover:text-white hover:border-[#2D6A4F]">
                        {{ $item['label'] }}
                    </a>
                </li>
            @endforeach

            <li class="w-full max-w-[250px] py-1 flex items-center gap-3">
                <div class="flex-1 h-px bg-gradient-to-r from-transparent via-[#2D6A4F]/20 to-transparent"></div>
                <span class="text-[#f7b6e4] text-sm">🌸</span>
                <div class="flex-1 h-px bg-gradient-to-r from-transparent via-[#2D6A4F]/20 to-transparent"></div>
            </li>

            <li class="w-full max-w-[250px]">
                <a href="{{ url('/admin') }}"
                    class="block px-6 py-3 rounded-xl text-[1rem] font-bold text-white text-center transition-all duration-300 shadow-md hover:shadow-lg hover:scale-105"
                    style="background: linear-gradient(135deg, #2D6A4F, #0F5238);">
                    Login Admin
                </a>
            </li>
        </ul>
    </div>
</header>