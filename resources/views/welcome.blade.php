<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Project Monitoring Geo Survey Persada Indonesia</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        @keyframes slowZoom {
            0% { transform: scale(1); }
            50% { transform: scale(1.15); }
            100% { transform: scale(1); }
        }
        .animate-zoom {
            animation: slowZoom 25s ease-in-out infinite;
        }
    </style>
</head>

<body class="antialiased text-white bg-gray-900">

<div class="relative min-h-screen overflow-hidden flex flex-col">

    <div class="absolute inset-0 z-0">
        <img src="{{ asset('images/jalan.webp') }}"
             class="w-full h-full object-cover animate-zoom"
             alt="Background">
    </div>

    <div class="absolute inset-0 bg-black/60 z-0"></div>

    <header class="relative z-20 w-full border-b border-white/10 bg-black/20 backdrop-blur-md">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            
            <div class="flex items-center space-x-3 
                bg-white/10 backdrop-blur-md 
                border border-white/20 
                px-2 py-1 
                rounded-2xl 
                shadow-lg">

                <div>
                    <img src="{{ asset('images/logo-perusahaan.png') }}" 
                    class="h-14 object-contain drop-shadow-lg" 
                    style="filter: brightness(0) invert(1);"  
                    alt="Logo GSPI">
                </div>

                <h1 class="text-xl font-black tracking-widest text-white hidden sm:block">
                    GSPI<span class="text-[#F8931F]">-TRACK</span>
                </h1>

            </div>

            <div>
                <a href="{{ route('login') }}"
                   class="text-sm font-bold text-gray-200 hover:text-[#F8931F] transition-colors duration-300 tracking-wider uppercase">
                    Login Sistem
                </a>
            </div>

        </div>
    </header>

    <main class="relative z-10 flex-1 flex items-center justify-center text-center px-4 py-12">

        <div class="max-w-3xl bg-white/10 backdrop-blur-md border border-white/20 p-8 md:p-12 rounded-3xl shadow-2xl">
            
            <h2 class="text-3xl md:text-5xl font-black mb-6 leading-tight drop-shadow-lg">
                Project Monitoring <br>
                <span class="text-[#F8931F]">Geo Survey Persada</span>
            </h2>

            <p class="text-base md:text-lg mb-10 text-gray-300 font-medium drop-shadow-md max-w-2xl mx-auto">
                Sistem monitoring proyek untuk mengontrol progres dan performa tim lapangan maupun kantor dalam satu dashboard terintegrasi.
            </p>

            <a href="{{ route('login') }}"
               class="inline-block px-8 py-3.5 bg-[#144C4D] text-white font-bold rounded-xl 
                      shadow-[0_0_20px_rgba(20,76,77,0.4)] hover:shadow-[0_0_30px_rgba(20,76,77,0.7)] 
                      hover:bg-[#0c2e2e] hover:-translate-y-1 transition-all duration-300 border border-[#1a6162]">
                Mulai Kelola Proyek
            </a>

        </div>

    </main>

    <footer class="relative z-10 w-full text-center py-6 text-sm font-medium text-gray-400 backdrop-blur-sm bg-black/10">
        © {{ date('Y') }} Hak Cipta PT Geo Survey Persada Indonesia.
    </footer>

</div>

</body>
</html>