<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'JamTravel' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @stack('styles')
</head>

<body class="bg-gray-100 text-gray-800">
    {{-- Header --}}
    @include('layouts.partials.navbar')

    {{-- Nội dung chính --}}
    <main class="container mx-auto px-4 py-6">
        @yield('search')
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="bg-gray-100 border-t mt-10">
        <div class="max-w-7xl mx-auto px-4 py-10 grid grid-cols-1 md:grid-cols-3 gap-8 text-sm text-gray-600">
            {{-- Thông tin thương hiệu --}}
            <div>
                <a class="flex items-center space-x-2 text-blue-600 hover:underline">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="rounded-full w-10 h-10 shadow-md" />
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">JamTravel</h3>
                </a>
                <p>{{ __('messages.footer.description') }}</p>
                <p class="mt-2">Hotline: <a href="tel:0374765197" class="text-blue-500 hover:underline">0374765197</a></p>
            </div>

            {{-- Liên kết nhanh --}}
            <div>
                <h3 class="text-lg font-semibold text-gray-800 mb-2">{{ __('messages.footer.links') }}</h3>
                <ul class="space-y-1">
                    <li><a href="{{ route('home') }}" class="hover:underline">{{ __('messages.nav.home') }}</a></li>
                    <li><a href="{{ route('villas.index') }}" class="hover:underline">{{ __('messages.nav.villas') }}</a></li>
                    <li><a href="{{ route('resorts.index') }}" class="hover:underline">{{ __('messages.nav.resorts') }}</a></li>
                    <li><a href="{{ route('homestays.index') }}" class="hover:underline">{{ __('messages.nav.homestays') }}</a></li>
                    <li><a href="{{ route('flights.index') }}" class="hover:underline">{{ __('messages.nav.flights') }}</a></li>
                    <li><a href="{{ route('contact') }}" class="hover:underline">{{ __('messages.nav.contact') }}</a></li>
                </ul>
            </div>

            {{-- Mạng xã hội --}}
            <div>
                <h3 class="text-lg font-semibold text-gray-800 mb-2">{{ __('messages.footer.follow_us') }}</h3>
                {{-- Facebook --}}
                <a href="https://www.facebook.com/thuthuy197" class="flex items-center space-x-2 hover:text-blue-600">
                    <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24">
                        <path d="M22 12.07C22 6.48 17.52 2 12 2S2 6.48 2 12.07C2 17.1 5.66 21.13 10.44 22v-7.03H7.9v-2.9h2.54V9.8c0-2.5 1.49-3.89 3.77-3.89 1.09 0 2.24.2 2.24.2v2.46h-1.26c-1.24 0-1.63.77-1.63 1.56v1.87h2.77l-.44 2.9h-2.33V22C18.34 21.13 22 17.1 22 12.07z" />
                    </svg>
                    <span>Facebook</span>
                </a>

                {{-- Instagram --}}
                <a href="#" class="flex items-center space-x-2 hover:text-pink-500">
                    <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24">
                        <path d="M7.75 2h8.5A5.76 5.76 0 0 1 22 7.75v8.5A5.76 5.76 0 0 1 16.25 22h-8.5A5.76 5.76 0 0 1 2 16.25v-8.5A5.76 5.76 0 0 1 7.75 2zm0 1.5A4.26 4.26 0 0 0 3.5 7.75v8.5A4.26 4.26 0 0 0 7.75 20.5h8.5A4.26 4.26 0 0 0 20.5 16.25v-8.5A4.26 4.26 0 0 0 16.25 3.5h-8.5zM12 7a5 5 0 1 1 0 10a5 5 0 0 1 0-10zm0 1.5a3.5 3.5 0 1 0 0 7a3.5 3.5 0 0 0 0-7zm5.25-.88a1.13 1.13 0 1 1-2.26 0a1.13 1.13 0 0 1 2.26 0z" />
                    </svg>
                    <span>Instagram</span>
                </a>

                {{-- Twitter --}}
                <a href="#" class="flex items-center space-x-2 hover:text-blue-400">
                    <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24">
                        <path d="M23 3a10.9 10.9 0 0 1-3.14 1.53A4.48 4.48 0 0 0 22.4 1.64a9.32 9.32 0 0 1-2.88 1.1 4.52 4.52 0 0 0-7.86 4.12A12.84 12.84 0 0 1 3 2.18a4.48 4.48 0 0 0 1.4 6.03A4.41 4.41 0 0 1 2.8 7v.05a4.52 4.52 0 0 0 3.63 4.43 4.41 4.41 0 0 1-2 .08 4.52 4.52 0 0 0 4.2 3.13A9.06 9.06 0 0 1 2 18.58a12.77 12.77 0 0 0 6.95 2.04c8.34 0 12.9-6.92 12.9-12.93c0-.2 0-.39-.01-.58A9.18 9.18 0 0 0 23 3z" />
                    </svg>
                    <span>Twitter</span>
                </a>
            </div>
        </div>
        </div>

        <div class="border-t mt-6 pt-4 pb-6 text-center text-xs text-gray-400">
            © {{ date('Y') }} JamTravel. All rights reserved.
        </div>
    </footer>

    @stack('scripts')
</body>

</html>