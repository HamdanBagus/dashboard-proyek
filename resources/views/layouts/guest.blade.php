<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'GSPI-TRACK') }}</title>

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

<body class="relative min-h-screen flex items-center justify-center overflow-hidden bg-gray-900">

    <div class="absolute inset-0 z-0">
        <img src="{{ asset('images/tambang.webp') }}"
             class="w-full h-full object-cover animate-zoom"
             alt="Background Tambang">
    </div>

    <div class="absolute inset-0 bg-black/60 z-0"></div>

    <div class="relative z-10 w-full max-w-md px-6 py-12 flex flex-col items-center">

        <div class="flex justify-center mb-10">
            <a href="/" class="flex items-center gap-4 hover:scale-105 transition-transform duration-300">
                
                <img src="{{ asset('images/logo-perusahaan.png') }}" 
                     class="w-14 h-14 object-contain drop-shadow-lg" 
                     style="filter: brightness(0) invert(1);" 
                     alt="Logo GSPI">

                <h1 class="text-3xl font-black tracking-widest text-white drop-shadow-lg">
                    GSPI<span class="text-[#F8931F]">-TRACK</span>
                </h1>

            </a>
        </div>

        <div class="w-full">
            {{ $slot }}
        </div>

    </div>

</body>
</html>