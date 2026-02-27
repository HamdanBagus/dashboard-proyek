<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Project Monitoring Geo Survey Persada Indonesia</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased text-white">

<div class="relative min-h-screen overflow-hidden">

    <!-- BACKGROUND IMAGE -->
    <div class="absolute inset-0">
        <img src="{{ asset('images/background.jpg') }}"
             class="w-full h-full object-cover "
             alt="Background">
    </div>

    <!-- DARK OVERLAY -->
    <div class="absolute inset-0 bg-black opacity-60"></div>

    <!-- CONTENT -->
    <div class="relative z-10 flex flex-col min-h-screen">

        <!-- ================= HEADER ================= -->
        <header class="absolute top-0 left-0 w-full z-20">
            <div class="max-w-7xl mx-auto px-6 py-6 flex justify-between items-center">
                <div  class="flex items-center space-x-3">
                    <img src="{{ asset('images/logo-perusahaan-bgputih.png') }}"class="w-20 h-20 object-contain">
                <h1 class="text-xl font-bold">
                    Project Monitoring Geo Survey Persada Indonesia
                </h1>
                </div>
                <div class="space-x-6">
                    <a href="{{ route('login') }}"
                       class="hover:text-blue-400 transition">
                        Login
                    </a>

                    <a href="{{ route('register') }}"
                       class="px-4 py-2 bg-blue-600 rounded-lg hover:bg-blue-700 transition">
                        Register
                    </a>
                </div>

            </div>
        </header>

        <!-- ================= HERO ================= -->
        <main class="flex-1 flex items-center justify-center text-center px-6">

            <div class="max-w-3xl">

                <h2 class="text-4xl md:text-5xl font-bold mb-6 leading-tight">
                    Monitor & Manage Your Projects Efficiently
                </h2>

                <p class="text-lg md:text-xl mb-8 text-gray-200">
                    Sistem monitoring proyek untuk mengontrol progres dan performa tim dalam satu dashboard terintegrasi.
                </p>

                <a href="{{ route('login') }}"
                   class="px-6 py-3 bg-blue-600 rounded-lg shadow-lg hover:bg-blue-700 transition">
                    Get Started
                </a>

            </div>

        </main>

        <!-- ================= FOOTER ================= -->
        <footer class="absolute bottom-0 left-0 w-full text-center py-6 text-gray-300">
            © {{ date('Y') }} Project Monitoring System
        </footer>

    </div>

</div>

</body>
</html>
