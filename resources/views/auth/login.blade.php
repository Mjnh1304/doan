<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email -->
        <div>
            <x-input-label for="email" :value="__('messages.email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                          :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('messages.password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password"
                          name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" name="remember" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" />
                <span class="ms-2 text-sm text-gray-600">{{ __('messages.remember_me') }}</span>
            </label>
        </div>

        <!-- Login Button -->
        <div class="flex items-center justify-center mt-4">
            <x-primary-button class="ms-3">
                {{ __('messages.login') }}
            </x-primary-button>
        </div>

        <!-- Forgot Password -->
        @if (Route::has('password.request'))
        <div class="mt-2 text-center">
            <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                {{ __('messages.forgot_password') }}
            </a>
        </div>
        @endif

        <!-- Register Link -->
        <p class="text-center mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('register') }}">
                {{ __('messages.no_account') }}
            </a>
        </p>
    </form>
</x-guest-layout>
