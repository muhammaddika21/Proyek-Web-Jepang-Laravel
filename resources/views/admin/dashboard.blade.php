<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - NihonLearn</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&family=Noto+Sans+JP:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet">
</head>
<body class="bg-gray-50 font-['Montserrat'] text-slate-800">

    <div class="flex min-h-screen">
        <!-- ================= SIDEBAR ================= -->
        <aside class="w-64 bg-white border-r border-gray-100 flex flex-col fixed h-full z-10">
            <div class="p-6 flex items-center gap-3 border-b border-gray-50">
                <div class="w-10 h-10 bg-[#448646] rounded-xl flex items-center justify-center text-white shadow-lg shadow-[#448646]/20">
                    <i class="ri-leaf-line text-2xl"></i>
                </div>
                <div>
                    <h1 class="font-bold text-lg leading-none">NihonLearn</h1>
                    <span class="text-[10px] text-gray-400 font-bold tracking-widest uppercase">Admin Panel</span>
                </div>
            </div>

            <nav class="flex-1 p-4 space-y-1 mt-4">
                <a href="#" class="flex items-center gap-3 px-4 py-3 bg-[#448646]/10 text-[#448646] rounded-xl font-bold transition-all">
                    <i class="ri-dashboard-3-line"></i> Dashboard
                </a>
                <a href="#" class="flex items-center gap-3 px-4 py-3 text-gray-400 hover:text-[#448646] hover:bg-gray-50 rounded-xl font-medium transition-all group">
                    <i class="ri-article-line"></i> Kelola Artikel
                </a>
                <a href="#" class="flex items-center gap-3 px-4 py-3 text-gray-400 hover:text-[#448646] hover:bg-gray-50 rounded-xl font-medium transition-all group">
                    <i class="ri-calendar-event-line"></i> Kegiatan UKM
                </a>
                <a href="#" class="flex items-center gap-3 px-4 py-3 text-gray-400 hover:text-[#448646] hover:bg-gray-50 rounded-xl font-medium transition-all group">
                    <i class="ri-chat-3-line"></i> Pesan Masuk
                </a>
            </nav>

            <div class="p-4 border-t border-gray-50">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 text-red-400 hover:bg-red-50 rounded-xl font-bold transition-all">
                        <i class="ri-logout-box-r-line"></i> Logout
                    </button>
                </form>
            </div>
        </aside>

        <!-- ================= MAIN CONTENT ================= -->
        <main class="flex-1 ml-64 p-8">
            <!-- Topbar -->
            <header class="flex justify-between items-center mb-10">
                <div>
                    <h2 class="text-2xl font-bold font-['Noto_Sans_JP']">Okaerinasai, Admin! 👋</h2>
                    <p class="text-gray-400 text-sm">Berikut ringkasan statistik UKM NihonLearn hari ini.</p>
                </div>
                <div class="flex items-center gap-4 text-sm font-bold">
                    <div class="text-right">
                        <p class="leading-none">Admin NihonLearn</p>
                        <span class="text-[10px] text-[#d6975e]">Master Admin</span>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-gray-200 border-2 border-white shadow-sm overflow-hidden">
                        <img src="https://ui-avatars.com/api/?name=Admin+Nihon&background=448646&color=fff" alt="Avatar">
                    </div>
                </div>
            </header>

            <!-- Statistik Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">
                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
                    <div class="w-12 h-12 bg-blue-50 text-blue-500 rounded-xl flex items-center justify-center mb-4 text-xl">
                        <i class="ri-article-line"></i>
                    </div>
                    <p class="text-gray-400 text-sm font-medium">Total Artikel</p>
                    <h3 class="text-2xl font-bold">24</h3>
                </div>
                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
                    <div class="w-12 h-12 bg-green-50 text-green-500 rounded-xl flex items-center justify-center mb-4 text-xl">
                        <i class="ri-calendar-event-line"></i>
                    </div>
                    <p class="text-gray-400 text-sm font-medium">Kegiatan Aktif</p>
                    <h3 class="text-2xl font-bold">5</h3>
                </div>
                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
                    <div class="w-12 h-12 bg-orange-50 text-orange-500 rounded-xl flex items-center justify-center mb-4 text-xl">
                        <i class="ri-group-line"></i>
                    </div>
                    <p class="text-gray-400 text-sm font-medium">Pengelola</p>
                    <h3 class="text-2xl font-bold">3</h3>
                </div>
                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
                    <div class="w-12 h-12 bg-red-50 text-red-500 rounded-xl flex items-center justify-center mb-4 text-xl">
                        <i class="ri-eye-line"></i>
                    </div>
                    <p class="text-gray-400 text-sm font-medium">Total Kunjungan</p>
                    <h3 class="text-2xl font-bold">1,204</h3>
                </div>
            </div>

            <!-- Pesan Terbaru / Aktivitas (Placeholder) -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-gray-50 flex justify-between items-center">
                    <h3 class="font-bold">Aktivitas Terbaru</h3>
                    <button class="text-[#448646] text-xs font-bold hover:underline">Lihat Semua</button>
                </div>
                <div class="p-6">
                    <div class="text-center py-10">
                        <i class="ri-inbox-archive-line text-4xl text-gray-200 mb-2 block"></i>
                        <p class="text-gray-400 text-sm">Belum ada aktivitas baru hari ini.</p>
                    </div>
                </div>
            </div>
        </main>
    </div>

</body>
</html>
