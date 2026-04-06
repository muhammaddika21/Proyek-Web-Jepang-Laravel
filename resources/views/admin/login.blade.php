<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - NihonLearn</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;800&family=Noto+Sans+JP:wght@400;700&display=swap" rel="stylesheet">
    <!-- Icon library -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.6.0/fonts/remixicon.css" rel="stylesheet" />
    
    <style>
        /* Kita tambahkan sedikit Custom CSS untuk mask bentuk blob di bagian gambar */
        .image-mask {
            clip-path: polygon(10% 0, 100% 0, 100% 100%, 0% 100%);
        }
        /* Custom mask untuk gambar di Swiper */
        .swiper-img-mask {
            clip-path: polygon(0 0, 100% 0, 100% 85%, 0% 100%);
        }
    </style>
</head>
<body class="bg-[#f8f7ef] min-h-screen flex items-center justify-center font-['Montserrat'] text-[#404235] p-4 sm:p-8">

    <!-- Container Utama: Split Card -->
    <div class="bg-white max-w-5xl w-full rounded-[2rem] shadow-2xl overflow-hidden flex flex-col md:flex-row min-h-[600px]">

        <!-- ======================= 
             KOLOM KIRI: FORM LOGIN 
             ======================= -->
        <div class="w-full md:w-1/2 p-10 sm:p-14 lg:p-16 flex flex-col justify-center relative">
            
            <!-- Logo / Elemen Dekorasi Atas -->
            <div class="absolute top-8 left-8 sm:top-12 sm:left-14 flex items-center gap-2 text-[#448646] font-bold text-xl">
                <i class="ri-leaf-fill text-2xl"></i>
                <span class="font-['Noto_Sans_JP'] tracking-wider">NihonLearn</span>
            </div>

            <div class="mt-12 md:mt-0">
                <h1 class="text-3xl lg:text-4xl font-extrabold mb-2">Okaerinasai 👋</h1>
                <p class="text-gray-500 mb-8 font-medium">Silakan masukkan detail akun Kanrisha (Admin) Anda.</p>

                <!-- Menampilkan pesan error jika login gagal -->
                @if($errors->any())
                    <div class="bg-red-50 border-l-4 border-[#d6975e] text-[#d6975e] p-4 mb-6 rounded text-sm font-semibold" role="alert">
                        <i class="ri-error-warning-fill mr-2"></i> {{ $errors->first() }}
                    </div>
                @endif

                <!-- Form Login -->
                <form action="{{ route('login.process') }}" method="POST" class="space-y-6">
                    @csrf 

                    <!-- Input Username -->
                    <div>
                        <label for="username" class="block font-semibold mb-2 ml-1 text-sm">Username</label>
                        <div class="relative flex items-center">
                            <i class="ri-user-smile-line absolute left-4 text-xl text-gray-400"></i>
                            <input type="text" name="username" id="username" 
                                class="w-full bg-gray-50 border-none rounded-2xl py-4 pl-12 pr-4 text-sm font-medium focus:ring-2 focus:ring-[#448646] focus:bg-white transition-all outline-none"
                                value="{{ old('username') }}" required autofocus placeholder="Masukkan username">
                        </div>
                    </div>

                    <!-- Input Password -->
                    <div>
                        <div class="flex items-center justify-between mb-2 ml-1">
                            <label for="password" class="block font-semibold text-sm">Password</label>
                            <a href="#" class="text-sm font-semibold text-[#80b68b] hover:text-[#448646] transition-colors">Lupa sandi?</a>
                        </div>
                        <div class="relative flex items-center">
                            <i class="ri-lock-password-line absolute left-4 text-xl text-gray-400"></i>
                            <input type="password" name="password" id="password" 
                                class="w-full bg-gray-50 border-none rounded-2xl py-4 pl-12 pr-12 text-sm font-medium focus:ring-2 focus:ring-[#448646] focus:bg-white transition-all outline-none"
                                required placeholder="••••••••">
                            
                            <!-- Toggle Show Password -->
                            <button type="button" class="absolute right-4 text-gray-400 hover:text-[#448646] transition-colors">
                                <i class="ri-eye-line text-xl"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Tombol Masuk -->
                    <button type="submit" class="w-full bg-[#448646] hover:bg-[#296751] text-white font-bold py-4 rounded-2xl transition-transform transform hover:-translate-y-1 shadow-[0_10px_20px_rgba(68,134,70,0.3)] flex justify-center items-center gap-2 mt-4">
                        Masuk Ke Panel <i class="ri-arrow-right-line"></i>
                    </button>
                </form>

            </div>
        </div>

        <!-- ======================= 
             KOLOM KANAN: SLIDER/GAMBAR 
             ======================= -->
        <div class="hidden md:flex w-1/2 bg-[#448646] text-white p-12 flex-col justify-between relative overflow-hidden image-mask">
            
            <!-- Ornamen Lingkaran BG -->
            <div class="absolute -top-32 -right-32 w-80 h-80 border-[40px] border-[#80b68b] rounded-full opacity-20"></div>
            <div class="absolute -bottom-20 -left-20 w-64 h-64 bg-[#d6975e] rounded-full opacity-40 blur-3xl"></div>

            <div class="relative z-10">
                <!-- Konten Atas Kanan -->
            </div>

            <!-- Konten Banner Teks -->
            <div class="relative z-10 bg-white/10 backdrop-blur-sm p-8 rounded-3xl border border-white/20 shadow-2xl mb-8">
                <p class="text-sm font-semibold tracking-widest text-[#d6975e] uppercase mb-2">Web Administrator</p>
                <h2 class="text-3xl font-bold font-['Noto_Sans_JP'] leading-snug mb-4">
                    Kendalikan <br>
                    <span class="text-[#f8f7ef]">Aset Digital</span> Anda.
                </h2>
                <p class="text-sm text-gray-200">
                    Sistem Manajemen Konten UKM NihonLearn. Jaga keamanan data, kelola artikel, dan pantau aktivitas pengguna dengan mudah dan aman.
                </p>
                
                <!-- Dot Pagination Simulation -->
                
            </div>

            <!-- Sosmed Link -->
            <div class="relative z-10 flex gap-4 text-white/70">
                
            </div>
            
            <!-- Gambar Hiasan (Placeholder) - Anda bisa ganti src url image-nya nanti -->
            <!-- <img src="url_gambar_jepang.png" class="absolute bottom-0 right-0 w-3/4 opacity-40 object-cover" alt="Japan Sakura"> -->
        </div>

    </div>

</body>
</html>
