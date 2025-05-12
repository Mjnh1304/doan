<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Villa, Resort Sóc Sơn' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 text-gray-800">
    {{-- Header --}}
    @include('layouts.partials.navbar')

    {{-- Nội dung chính --}}
    <main class="container mx-auto px-4 py-6">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="bg-white border-t mt-10">
        <div class="container mx-auto px-4 py-6 text-center text-sm text-gray-500">
            © {{ date('Y') }} Villa, Resort Sóc Sơn. All rights reserved.
        </div>
    </footer>
</body>
</html>