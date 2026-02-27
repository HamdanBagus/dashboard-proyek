<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="relative min-h-screen flex items-center justify-center bg-cover bg-center"
      style="background-image: url('{{ asset('images/bg-login.jpg') }}');">

    <!-- Overlay -->
    <div class="absolute inset-0 bg-black/60"></div>

    <div class="relative w-full max-w-md">

        <!-- Logo -->
        <div class="flex justify-center mb-6">
            <a href="/">
                <x-application-logo class="w-16 h-16 fill-white" />
            </a>
        </div>

        <!-- Glass Card -->
        <div class="backdrop-blur-xl bg-white/10 border border-white/20
                    shadow-2xl rounded-2xl px-8 py-8 text-white">

            {{ $slot }}

        </div>

    </div>

</body>
</html>
