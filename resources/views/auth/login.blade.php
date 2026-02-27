<x-guest-layout>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <h2 class="text-2xl font-semibold text-center mb-6">
            Login Account
        </h2>

        <!-- Email -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="text-white" />
            <x-text-input id="email"
                class="block mt-1 w-full bg-white/20 border border-white/30
                       text-white placeholder-gray-300 rounded-lg
                       focus:border-indigo-400 focus:ring-indigo-400"
                type="email"
                name="email"
                :value="old('email')"
                required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-300" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" class="text-white" />
            <x-text-input id="password"
                class="block mt-1 w-full bg-white/20 border border-white/30
                       text-white placeholder-gray-300 rounded-lg
                       focus:border-indigo-400 focus:ring-indigo-400"
                type="password"
                name="password"
                required />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-300" />
        </div>

        <!-- Remember -->
        <div class="flex items-center justify-between mt-4 text-sm">
            <label class="flex items-center">
                <input type="checkbox"
                    class="rounded border-white/30 bg-white/20 text-indigo-500 shadow-sm focus:ring-indigo-400"
                    name="remember">
                <span class="ml-2 text-gray-200">Remember me</span>
            </label>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}"
                   class="text-gray-300 hover:text-white transition">
                    Forgot password?
                </a>
            @endif
        </div>

        <!-- Button -->
        <button type="submit"
            class="w-full mt-6 bg-white text-gray-900 font-semibold py-2.5
                   rounded-full hover:bg-gray-200 transition duration-200 shadow-lg">
            Log In
        </button>

    </form>

</x-guest-layout>
