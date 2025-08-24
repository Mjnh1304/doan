<nav class="bg-white shadow-md sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 py-3 flex justify-between items-center">
        {{-- Logo + Tên --}}
        <a href="{{ route('home') }}" class="flex items-center gap-3 text-blue-600 hover:text-blue-700 transition">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="rounded-full w-10 h-10 shadow-md ring-2 ring-blue-300" />
            <h1 class="text-2xl font-extrabold tracking-tight">Jam Travel</h1>
        </a>

        {{-- Navigation --}}
        <div class="flex items-center gap-6">
            @auth
            <div class="flex items-center gap-4 text-sm">
                <span class="text-gray-700">👋 {{ __('messages.welcome') }}, <strong>{{ Auth::user()->name }}</strong></span>

                @if (Auth::user()->role === 'admin')
                <a href="{{ route('admin.dashboard') }}" class="text-blue-600 hover:text-blue-800 font-medium transition">{{ __('messages.dashboard') }}</a>
                @endif

                <a href="{{ route('bookings.history') }}" class="text-blue-600 hover:text-blue-800 font-medium transition">{{ __('messages.booking') }}</a>
                <a href="{{ route('profile.edit') }}" class="text-blue-600 hover:text-blue-800 font-medium transition">{{ __('messages.profile') }}</a>
                <a href="{{ route('contact') }}" class="text-blue-600 hover:text-blue-800 font-medium transition">{{ __('messages.contact') }}</a>

                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="text-red-500 hover:text-red-700 font-medium transition">{{ __('messages.logout') }}</button>
                </form>
            </div>
            @endauth

            @guest
            <div class="flex items-center gap-4 text-sm">
                <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-800 font-medium transition">{{ __('messages.login') }}</a>
                <a href="{{ route('register') }}" class="text-blue-600 hover:text-blue-800 font-medium transition">{{ __('messages.register') }}</a>
            </div>
            @endguest

            {{-- Ngôn ngữ --}}
            <div class="flex items-center gap-2 border-l pl-4 ml-2">
                <a href="{{ route('lang.switch', 'vi') }}" class="text-xs uppercase {{ app()->getLocale() === 'vi' ? 'font-bold text-blue-600 underline' : 'text-gray-500 hover:text-blue-500' }}">Vi</a>
                <span class="text-gray-400">|</span>
                <a href="{{ route('lang.switch', 'en') }}" class="text-xs uppercase {{ app()->getLocale() === 'en' ? 'font-bold text-blue-600 underline' : 'text-gray-500 hover:text-blue-500' }}">En</a>
            </div>
        </div>
    </div>
</nav>
