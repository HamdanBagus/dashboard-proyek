<x-guest-layout>

    <div class="w-full max-w-md mx-auto">
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <h2 class="text-2xl font-semibold text-center mb-6 text-white">
                Login Account
            </h2>

            <x-auth-session-status class="mb-4 text-center text-green-300" :status="session('status')" />

            <div>
                <x-input-label for="email" :value="__('Email')" class="text-white font-medium" />
                <x-text-input id="email"
                    class="block mt-1 w-full bg-white/20 border border-white/30
                           text-white placeholder-gray-300 rounded-lg shadow-sm
                           focus:border-indigo-400 focus:ring focus:ring-indigo-400/50 transition"
                    type="email"
                    name="email"
                    :value="old('email')"
                    placeholder="Masukkan email Anda"
                    required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-300" />
            </div>

            <div class="mt-5" x-data="{ show: false }">
                <x-input-label for="password" :value="__('Password')" class="text-white font-medium" />
                
                <div class="relative mt-1">
                    <x-text-input id="password"
                        class="block w-full bg-white/20 border border-white/30
                               text-white placeholder-gray-300 rounded-lg shadow-sm
                               focus:border-indigo-400 focus:ring focus:ring-indigo-400/50 transition pr-10"
                        x-bind:type="show ? 'text' : 'password'"
                        name="password"
                        placeholder="Masukkan password Anda"
                        required autocomplete="current-password" />
                    
                    <button type="button" @click="show = !show" 
                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-300 hover:text-white focus:outline-none transition-colors duration-200">
                        
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

                <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-300" />
            </div>

            <div class="flex items-center justify-between mt-5 text-sm">
                <label for="remember_me" class="inline-flex items-center cursor-pointer">
                    <input id="remember_me" type="checkbox"
                        class="rounded border-white/30 bg-white/20 text-indigo-500 shadow-sm focus:ring-indigo-400 focus:ring-offset-0 focus:ring-offset-transparent"
                        name="remember">
                    <span class="ml-2 text-gray-200 font-medium">Remember me</span>
                </label>

                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}"
                       class="text-gray-300 hover:text-white font-medium transition-colors duration-200">
                        Forgot password?
                    </a>
                @endif
            </div>

            <div class="mt-8">
                <button type="submit"
                    class="w-full bg-white text-indigo-900 font-bold py-3 px-4
                           rounded-xl hover:bg-gray-100 hover:shadow-xl hover:-translate-y-0.5 
                           transition-all duration-200 shadow-lg focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-indigo-600">
                    Log In
                </button>
            </div>

        </form>
    </div>

</x-guest-layout>