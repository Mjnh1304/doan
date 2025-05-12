<nav class="bg-white shadow-md">
    <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
        {{-- Logo + Tên --}}
        <div class="flex items-center space-x-2">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-8 w-8">
            <h1 class="text-xl font-bold text-blue-600">Jam Travel</h1>
        </div>

        {{-- Navigation --}}
        @auth
        <div class="flex items-center space-x-4">
            <span class="text-gray-700">{{ __('messages.welcome') }}, <strong>{{ Auth::user()->name }}</strong></span>

            <a href="{{ route('home') }}" class="text-blue-500 hover:underline">{{ __('messages.home') }}</a>

            @if (Auth::user()->role === 'admin')
                <a href="{{ route('admin.dashboard') }}" class="text-blue-500 hover:underline">{{ __('messages.dashboard') }}</a>
            @endif

            <a href="#" class="text-blue-500 hover:underline">{{ __('messages.booking') }}</a>
            <a href="{{ route('profile.edit') }}" class="text-blue-500 hover:underline">{{ __('messages.profile') }}</a>
            <a href="{{ route('contact') }}" class="text-blue-500 hover:underline">{{ __('messages.contact') }}</a>

            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="text-red-500 hover:underline">{{ __('messages.logout') }}</button>
            </form>
        </div>
        @endauth

        @guest
        <div class="flex items-center space-x-4">
            <a href="{{ route('login') }}" class="text-blue-500 hover:underline">{{ __('messages.login') }}</a>
            <a href="{{ route('register') }}" class="text-blue-500 hover:underline">{{ __('messages.register') }}</a>
        </div>
        @endguest

        {{-- Đổi ngôn ngữ --}}
        <div class="flex items-center space-x-2">
            <a href="{{ route('lang.switch', 'vi') }}" class="text-sm {{ app()->getLocale() === 'vi' ? 'font-bold underline' : '' }}">VI</a>
            <span>|</span>
            <a href="{{ route('lang.switch', 'en') }}" class="text-sm {{ app()->getLocale() === 'en' ? 'font-bold underline' : '' }}">EN</a>
        </div>
    </div>
</nav>
