<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Monitoring Project') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    
    <body class="font-sans antialiased bg-[#F4F7F6] text-gray-900" x-data="{ sidebarOpen: false }">

        <div class="flex h-screen overflow-hidden">

            <div x-show="sidebarOpen" x-transition.opacity class="fixed inset-0 z-20 bg-gray-900 bg-opacity-50 lg:hidden" @click="sidebarOpen = false" style="display: none;"></div>

            <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 z-30 w-64 bg-[#144C4D] transition-transform duration-300 lg:translate-x-0 lg:static lg:inset-0 flex flex-col shadow-2xl border-r border-[#114243]">
                
                <div class="flex items-center justify-center h-16 bg-[#114243] border-b border-[#114243] shrink-0">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
                        <img src="/images/logo-perusahaan.png" alt="Logo Perusahaan"class="w-10 h-10 object-contain"style="filter: brightness(0) invert(1);">
                        <span class="text-white font-black text-xl tracking-widest mr-2">GSPI-<span class="text-[#F8931F]">TRACK</span></span>
                    </a>
                </div>

                <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto scrollbar-hide">
    
                    <p class="px-4 pt-5 pb-2 text-xs font-black text-gray-400 uppercase tracking-widest">Manajemen Operasional</p>
                    <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 text-[#F4F7F6] hover:bg-[#F8931F] hover:text-white rounded-lg transition-all font-medium {{ request()->routeIs('dashboard') ? 'bg-[#F8931F] text-white shadow-md' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                        </svg>
                        <span>Dashboard</span>
                    </a>

                    <a href="{{ route('projects.index') }}" class="flex items-center px-4 py-3 text-[#F4F7F6] hover:bg-[#F8931F] hover:text-white rounded-lg transition-all font-medium {{ request()->routeIs('projects.*') ? 'bg-[#F8931F] text-white shadow-md' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                        </svg>
                        <span>Manajemen Proyek</span>
                    </a>

                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('management.index') }}" class="flex items-center px-4 py-3 text-[#F4F7F6] hover:bg-[#F8931F] hover:text-white rounded-lg transition-all font-medium {{ request()->routeIs('management.*') ? 'bg-[#F8931F] text-white shadow-md' : '' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                            <span>Manajemen Asset</span>
                        </a>
                        <a href="{{ route('uav-maintenance.index') }}" class="flex items-center px-4 py-3 text-[#F4F7F6] hover:bg-[#F8931F] hover:text-white rounded-lg transition-all font-medium {{ request()->routeIs('uav-maintenance.*') ? 'bg-[#F8931F] text-white shadow-md' : '' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <span>Maintenance Asset</span>
                        </a>
                        <p class="px-4 pt-5 pb-2 text-xs font-black text-gray-400 uppercase tracking-widest">Manajemen Akun User</p>
                        <a href="{{ route('users.index') }}" class="flex items-center px-4 py-3 text-[#F4F7F6] hover:bg-[#F8931F] hover:text-white rounded-lg transition-all font-medium {{ request()->routeIs('users.*') ? 'bg-[#F8931F] text-white shadow-md' : '' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                            <span>Manajemen User</span>
                        </a>
                    @endif

                </nav>

                <div class="p-4 bg-[#114243] border-t border-[#114243]">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="flex items-center justify-center w-full px-4 py-2.5 text-white border border-white hover:bg-[#F8931F] hover:text-white rounded-lg transition-all font-bold text-sm">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            <span>{{ __('Log Out') }}</span>
                        </button>
                    </form>
                </div>
            </aside>

            <div class="flex-1 flex flex-col overflow-hidden bg-[#F4F7F6]">

                <header class="flex items-center justify-between px-6 py-3 bg-white border-b border-gray-200 shadow-sm shrink-0">
                    <div class="flex items-center">
                        <button @click="sidebarOpen = true" class="text-gray-600 focus:outline-none lg:hidden hover:text-[#144C4D] transition bg-gray-100 p-2 rounded-md">
                            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M4 6H20M4 12H20M4 18H11" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>
                        
                        @isset($header)
                            <div class="hidden lg:block ml-4 text-gray-800 breadcrumbs">
                                {{ $header }}
                            </div>
                        @endisset
                    </div>

                    <div class="flex items-center gap-4">
                        <div x-data="{ dropdownOpen: false }" class="relative">
                            <button @click="dropdownOpen = ! dropdownOpen" class="flex items-center gap-3 focus:outline-none hover:bg-gray-50 p-1.5 rounded-lg border border-transparent hover:border-gray-200 transition dropdown-trigger">
                                <div class="w-9 h-9 rounded-full bg-[#E8F1F1] flex items-center justify-center text-[#144C4D] font-black border border-[#144C4D] shadow-sm">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                                <div class="text-left hidden md:block">
                                    <span class="block text-sm font-bold text-gray-800">{{ Auth::user()->name }}</span>
                                    <span class="block text-xs font-semibold text-gray-500 capitalize">{{ Auth::user()->role ?? 'Admin' }}</span>
                                </div>
                                <svg class="w-4 h-4 text-gray-400 ml-1 hidden md:block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>

                            <div x-show="dropdownOpen" @click.away="dropdownOpen = false" x-transition.opacity class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg z-50 border border-gray-100 py-2 dropdown-content" style="display: none;">
                                <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-2 text-sm font-bold text-gray-600 hover:bg-[#F4F7F6] hover:text-[#144C4D] transition">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    {{ __('Profile') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </header>

                <main class="flex-1 overflow-x-hidden overflow-y-auto bg-[#F4F7F6]">
                    @isset($header)
                        <div class="block lg:hidden bg-white shadow-sm border-b border-gray-200 px-6 py-4">
                            {{ $header }}
                        </div>
                    @endisset

                    <div class="container mx-auto">
                        {{ $slot }}
                    </div>
                </main>

            </div>
        </div>
    </body>
</html>