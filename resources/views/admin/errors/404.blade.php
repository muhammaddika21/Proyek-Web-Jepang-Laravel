<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>404 - Halaman Tidak Ditemukan | Admin</title>
    @vite(['resources/css/admin.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&family=Noto+Sans+JP:wght@400;700&family=Zen+Kurenaido&display=swap" rel="stylesheet">
    <script>
        (function() {
            const savedTheme = localStorage.getItem('theme');
            const systemTheme = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
            if ((savedTheme || systemTheme) === 'dark') document.documentElement.classList.add('dark');
        })();
    </script>
</head>
<body class="bg-gray-50 dark:bg-[#112117] h-full flex items-center justify-center p-4">
    <div class="w-full max-w-2xl rounded-2xl border border-dashed border-gray-300 bg-white p-8 sm:p-12 text-center shadow-sm dark:border-[#24463a] dark:bg-[#1a2e24]">
        <div class="mb-6 relative inline-block">
            <span class="text-9xl font-bold text-gray-100 dark:text-gray-800/50 select-none" style="font-family: 'Noto Sans JP', sans-serif;">空</span>
            <div class="absolute inset-0 flex items-center justify-center">
                <span class="text-6xl font-black text-brand-500" style="font-family: 'Zen Kurenaido', serif;">404</span>
            </div>
        </div>
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-2">Halaman Tidak Ditemukan</h1>
        <p class="text-sm text-gray-500 dark:text-gray-400 mb-8">Maaf, halaman dashboard yang Anda cari mungkin telah dihapus, URL-nya salah, atau Anda belum login.</p>
        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 px-6 py-2.5 bg-brand-500 text-white rounded-lg font-medium hover:bg-brand-600 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Dashboard
        </a>
    </div>
</body>
</html>
