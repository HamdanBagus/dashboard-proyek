<x-guest-layout>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <h2 class="text-2xl font-semibold text-center mb-6">
            Create Account
        </h2>

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" class="text-white" />
            <x-text-input id="name"
                class="block mt-1 w-full bg-white/20 border border-white/30
                       text-white placeholder-gray-300 rounded-lg
                       focus:border-indigo-400 focus:ring-indigo-400"
                type="text"
                name="name"
                :value="old('name')"
                required autofocus />
            <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-300" />
        </div>

        <!-- Email -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" class="text-white" />
            <x-text-input id="email"
                class="block mt-1 w-full bg-white/20 border border-white/30
                       text-white placeholder-gray-300 rounded-lg
                       focus:border-indigo-400 focus:ring-indigo-400"
                type="email"
                name="email"
                :value="old('email')"
                required />
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

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation"
                :value="__('Confirm Password')" class="text-white" />
            <x-text-input id="password_confirmation"
                class="block mt-1 w-full bg-white/20 border border-white/30
                       text-white placeholder-gray-300 rounded-lg
                       focus:border-indigo-400 focus:ring-indigo-400"
                type="password"
                name="password_confirmation"
                required />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-300" />
        </div>

        <!-- Button -->
        <button type="submit"
            class="w-full mt-6 bg-white text-gray-900 font-semibold py-2.5
                   rounded-full hover:bg-gray-200 transition duration-200 shadow-lg">
            Register
        </button>

        <div class="text-center mt-4 text-sm text-gray-300">
            Already registered?
            <a href="{{ route('login') }}" class="hover:text-white underline">
                Login here
            </a>
        </div>

    </form>

</x-guest-layout>
