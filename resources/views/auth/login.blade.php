<x-guest-layout>

    <div class="w-full max-w-md mx-auto bg-white/10 backdrop-blur-md border border-white/20 p-8 sm:p-10 rounded-3xl shadow-2xl">
        
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="text-center mb-8">
                <h2 class="text-3xl font-black text-white drop-shadow-md">
                    Login <span class="text-[#F8931F]">Sistem</span>
                </h2>
                <p class="text-sm text-gray-300 mt-2 font-medium">Silakan masuk menggunakan akun Anda</p>
            </div>

            <x-auth-session-status class="mb-4 text-center text-green-400 font-medium" :status="session('status')" />

            <div>
                <x-input-label for="email" :value="__('Email Akses')" class="text-white font-bold tracking-wider text-xs uppercase" />
                <x-text-input id="email"
                    class="block mt-1.5 w-full bg-black/20 border border-white/20
                           text-white placeholder-gray-400 rounded-xl shadow-inner
                           focus:border-[#F8931F] focus:ring focus:ring-[#F8931F]/30 transition-all"
                    type="email"
                    name="email"
                    :value="old('email')"
                    placeholder="email@geosurvey.com"
                    required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-400 text-sm" />
            </div>

            <div class="mt-6" x-data="{ show: false }">
                <x-input-label for="password" :value="__('Password')" class="text-white font-bold tracking-wider text-xs uppercase" />
                
                <div class="relative mt-1.5">
                    <x-text-input id="password"
                        class="block w-full bg-black/20 border border-white/20
                               text-white placeholder-gray-400 rounded-xl shadow-inner
                               focus:border-[#F8931F] focus:ring focus:ring-[#F8931F]/30 transition-all pr-10"
                        x-bind:type="show ? 'text' : 'password'"
                        name="password"
                        placeholder="Masukkan password Anda"
                        required autocomplete="current-password" />
                    
                    <button type="button" @click="show = !show" 
                            class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-[#F8931F] focus:outline-none transition-colors duration-200">
                        
                        <svg x-show="!show" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        
                        <svg x-show="show" x-cloak class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display: none;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.05 10.05 0 014.182-5.322m5.82 0A10.05 10.05 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.05 10.05 0 01-4.182 5.322m-5.82 0l-4.182 4.182m4.182-4.182l4.182 4.182" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18" />
                        </svg>
                    </button>
                </div>

                <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-400 text-sm" />
            </div>

            <div class="flex items-center justify-between mt-6 text-sm">
                <label for="remember_me" class="inline-flex items-center cursor-pointer group">
                    <input id="remember_me" type="checkbox"
                        class="rounded border-white/30 bg-black/20 text-[#F8931F] shadow-sm focus:ring-[#F8931F] focus:ring-offset-0 transition"
                        name="remember">
                    <span class="ml-2 text-gray-300 group-hover:text-white transition font-medium">Ingat Saya</span>
                </label>

                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}"
                       class="text-gray-300 hover:text-[#F8931F] font-medium transition-colors duration-200">
                        Lupa password?
                    </a>
                @endif
            </div>

            <div class="mt-8">
                <button type="submit"
                    class="w-full bg-[#144C4D] text-white font-bold py-3.5 px-4
                           rounded-xl shadow-[0_0_20px_rgba(20,76,77,0.4)] hover:shadow-[0_0_30px_rgba(20,76,77,0.7)] 
                           hover:bg-[#0c2e2e] hover:-translate-y-1 transition-all duration-300 border border-[#1a6162] focus:outline-none focus:ring-2 focus:ring-[#F8931F] focus:ring-offset-2 focus:ring-offset-transparent">
                    Masuk Sekarang
                </button>
            </div>

        </form>
    </div>

</x-guest-layout>