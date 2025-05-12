<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.4.1/dist/tailwind.min.css" rel="stylesheet">
    @stack('styles')
</head>
<body class="bg-gray-100 text-gray-800">

    <div class="flex h-screen">

        <!-- Sidebar -->
        <aside class="w-64 bg-white shadow-md p-4 space-y-4">
            <div class="flex items-center justify-center mb-6">
                <img src="https://via.placeholder.com/100" alt="Logo" class="rounded-full w-16 h-16">
            </div>
            <nav class="space-y-2">
                <a href="{{ route('home') }}" class="block px-4 py-2 text-gray-700 hover:bg-blue-100 rounded flex items-center space-x-2">
                    <span>🏠</span>
                    <span>Trang chủ</span>
                </a>
                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-gray-700 hover:bg-blue-100 rounded flex items-center space-x-2">
                    <span>📊</span>
                    <span>Bảng điều khiển</span>
                </a>
                <a href="{{ route('admin.villas.index') }}" class="block px-4 py-2 text-gray-700 hover:bg-blue-100 rounded flex items-center space-x-2">
                    <span>🏡</span>
                    <span>Quản lý Villa</span>
                </a>
                <a href="{{ route('admin.users.index') }}" class="block px-4 py-2 text-gray-700 hover:bg-blue-100 rounded flex items-center space-x-2">
                    <span>👥</span>
                    <span>Quản lý người dùng</span>
                </a>
                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-gray-700 hover:bg-blue-100 rounded flex items-center space-x-2">
                    <span>👤</span>
                    <span>Hồ sơ</span>
                </a>
            </nav>
        </aside>

        <!-- Main content -->
        <div class="flex-1 flex flex-col">
            <!-- Header -->
            <header class="bg-white shadow-md flex justify-between items-center px-6 py-4">
                <div class="text-lg font-semibold text-gray-800">
                    @yield('title', 'Trang quản trị')
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-gray-700">👋 Xin chào, {{ Auth::user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-red-600 hover:underline">Đăng xuất</button>
                    </form>
                </div>
            </header>

            <!-- Content -->
            <main class="p-6 overflow-y-auto">
                @yield('content')
            </main>
        </div>

    </div>

</body>
</html>
