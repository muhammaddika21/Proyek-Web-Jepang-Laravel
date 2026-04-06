{{-- Navbar — Always visible, no slide up/down --}}
<header
    x-data="{
        open: false,
        scrolled: false,
        init() {
            window.addEventListener('scroll', () => {
                this.scrolled = window.scrollY > 50;
            });
        }
    }"
    :class="scrolled ? 'bg-white/95 shadow-lg backdrop-blur-xl' : 'bg-transparent'"
    class="fixed top-0 left-0 right-0 z-50 transition-all duration-400 ease-in-out"
    id="mainHeader"
>
    <nav class="max-w-[1200px] mx-auto px-4 sm:px-8 flex items-center h-[70px] md:h-[80px] relative">

        {{-- Logo Area — with original hover animation (scale + rotate) --}}
        <a href="{{ route('home') }}" class="flex items-center gap-3 group transition-transform duration-300 hover:scale-105 shrink-0">
            {{-- Logo circle — matching original size (55px) --}}
            <div class="w-[55px] h-[55px] rounded-full flex items-center justify-center shadow-md transition-all duration-300 overflow-hidden border-2 group-hover:shadow-lg group-hover:rotate-[5deg]"
                 :class="scrolled ? 'border-[#8fd6b0]/40 shadow-[#8fd6b0]/40' : 'border-white/40 shadow-white/20'"
                 style="background: linear-gradient(135deg, #8fd6b0, #a8e6cf);">
                @if(file_exists(public_path('images/Logo ukm nihon fix.png')))
                    <img src="{{ asset('images/Logo ukm nihon fix.png') }}" alt="Logo UKM Nihon" class="w-full h-full object-cover" style="image-rendering: auto;">
                @else
                    <span class="text-white font-bold text-base">NB</span>
                @endif
            </div>
            <div>
                <h1 class="text-[1.5rem] font-bold leading-tight transition-colors duration-300"
                    :class="scrolled ? 'text-[#66bb6a]' : 'text-white'">Nihongo Bu</h1>
                <p class="text-[0.75rem] font-medium transition-colors duration-300"
                    :class="scrolled ? 'text-[#66bb6a]/60' : 'text-white/70'"
                    style="font-family: 'Noto Sans JP', sans-serif;">日本語と文化</p>
            </div>
        </a>

        {{-- Desktop Navigation — center positioned (absolute like original) --}}
        <ul class="hidden md:flex items-center absolute left-1/2 -translate-x-1/2">
            @php
                $navItems = [
                    ['label' => 'Home', 'href' => route('home')],
                    ['label' => 'Profil', 'href' => '#profil'],
                    ['label' => 'Kegiatan', 'href' => '#kegiatan'],
                    ['label' => 'Budaya', 'href' => '#budaya'],
                    ['label' => 'Bahasa', 'href' => url('/bahasa')],
                ];
            @endphp

            @foreach($navItems as $item)
            <li>
                <a href="{{ $item['href'] }}"
                   class="nav-link-custom inline-flex items-center px-[0.75rem] py-[0.6rem] pr-[23px] mx-[0.4rem] rounded-lg text-[1.05rem] font-semibold border border-transparent transition-all duration-300 outline-none"
                   :class="scrolled
                       ? 'text-[#66bb6a] hover:text-[#66bb6a] hover:bg-[rgba(193,225,208,0.15)] hover:border-[#8fd6b0] hover:-translate-y-1 hover:scale-105 hover:shadow-[0_4px_12px_rgba(143,214,176,0.3)]'
                       : 'text-white hover:text-white hover:bg-white/10 hover:border-white/40 hover:-translate-y-1 hover:scale-105 hover:shadow-[0_4px_12px_rgba(255,255,255,0.15)]'"
                >
                    {{ $item['label'] }}
                </a>
            </li>
            @endforeach
        </ul>

        {{-- Right side: Admin Login Button --}}
        <div class="hidden md:flex items-center ml-auto">
            <a href="{{ url('/admin') }}"
               class="inline-flex items-center gap-2 px-5 py-2 rounded-full text-sm font-semibold transition-all duration-300 hover:-translate-y-0.5 hover:shadow-lg"
               :class="scrolled
                   ? 'bg-[#448646] text-white hover:bg-[#296751] shadow-[#448646]/20'
                   : 'bg-white/20 text-white border border-white/30 hover:bg-white/30 backdrop-blur-sm'"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                Login
            </a>
        </div>

        {{-- Hamburger (Mobile) --}}
        <button
            @click="open = !open"
            class="md:hidden flex flex-col justify-center items-center w-10 h-10 rounded-lg transition-colors ml-auto"
            :class="scrolled ? 'hover:bg-gray-100' : 'hover:bg-white/15'"
            aria-label="Toggle menu"
        >
            <span :class="[open ? 'rotate-45 translate-y-[9px]' : '', scrolled ? 'bg-[#66bb6a]' : 'bg-white']"
                  class="block w-[28px] h-[3px] rounded-sm transition-all duration-300 origin-center"></span>
            <span :class="[open ? 'opacity-0 translate-x-[10px]' : '', scrolled ? 'bg-[#66bb6a]' : 'bg-white']"
                  class="block w-[28px] h-[3px] rounded-sm mt-[6px] transition-all duration-300"></span>
            <span :class="[open ? '-rotate-45 -translate-y-[9px]' : '', scrolled ? 'bg-[#66bb6a]' : 'bg-white']"
                  class="block w-[28px] h-[3px] rounded-sm mt-[6px] transition-all duration-300 origin-center"></span>
        </button>
    </nav>

    {{-- Mobile Menu — Japanese soft theme + backdrop blur --}}
    <div
        x-show="open"
        x-transition:enter="transition-all ease duration-[400ms]"
        x-transition:enter-start="max-h-0 opacity-0"
        x-transition:enter-end="max-h-screen opacity-100"
        x-transition:leave="transition-all ease duration-[400ms]"
        x-transition:leave-start="max-h-screen opacity-100"
        x-transition:leave-end="max-h-0 opacity-0"
        class="md:hidden overflow-hidden"
        style="background: linear-gradient(to bottom, rgba(255, 255, 255, 0.92), rgba(245, 252, 248, 0.95));
               backdrop-filter: blur(24px);
               -webkit-backdrop-filter: blur(24px);
               border-bottom: 1px solid rgba(143, 214, 176, 0.2);
               box-shadow: 0 8px 32px rgba(0, 0, 0, 0.06);"
    >
        <ul class="px-6 py-6 space-y-3 flex flex-col items-center">
            @php
                $mobileItems = [
                    ['label' => 'Home', 'href' => route('home')],
                    ['label' => 'Profil', 'href' => '#profil'],
                    ['label' => 'Kegiatan', 'href' => '#kegiatan'],
                    ['label' => 'Budaya', 'href' => '#budaya'],
                    ['label' => 'Bahasa', 'href' => url('/bahasa')],
                ];
            @endphp

            @foreach($mobileItems as $item)
            <li class="w-full max-w-[250px]">
                <a href="{{ $item['href'] }}"
                   @click="open = false"
                   class="block text-center px-6 py-3 rounded-xl text-[1.1rem] font-semibold transition-all duration-300 border border-[#7bcf9b]/30"
                   style="color: #7bcf9b;"
                   onmouseover="this.style.background='#7bcf9b'; this.style.color='#0f1a14'; this.style.transform='scale(1.05)'; this.style.boxShadow='0 4px 16px rgba(123,207,155,0.35)'; this.style.borderColor='#7bcf9b';"
                   onmouseout="this.style.background='transparent'; this.style.color='#7bcf9b'; this.style.transform='scale(1)'; this.style.boxShadow='none'; this.style.borderColor='rgba(123,207,155,0.3)';"
                >
                    {{ $item['label'] }}
                </a>
            </li>
            @endforeach

            {{-- Separator --}}
            <li class="w-full max-w-[250px] py-1 flex items-center gap-3">
                <div class="flex-1 h-px bg-gradient-to-r from-transparent via-[#7bcf9b]/30 to-transparent"></div>
                <span class="text-[#f7b6e4] text-sm">🌸</span>
                <div class="flex-1 h-px bg-gradient-to-r from-transparent via-[#7bcf9b]/30 to-transparent"></div>
            </li>

            <li class="w-full max-w-[250px]">
                <a href="{{ url('/admin') }}"
                   class="block px-6 py-3 rounded-xl text-[1rem] font-bold text-white text-center transition-all duration-300 shadow-md hover:shadow-lg hover:scale-105"
                   style="background: linear-gradient(135deg, #448646, #296751);">
                    Login Admin
                </a>
            </li>
        </ul>
    </div>
</header>
