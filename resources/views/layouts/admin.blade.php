<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Dashboard</title>
    <script>
        (function() {
            const savedTheme = localStorage.getItem('theme');
            const root = document.documentElement;
            if (savedTheme === 'dark') {
                root.classList.add('dark');
            } else {
                root.classList.remove('dark');
                localStorage.setItem('theme', 'light');
            }
        })();
    </script>
    <!-- Load CDN trước -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Sau đó mới gán cấu hình -->
    <script>
        tailwind.config = {
            darkMode: 'class',
            safelist: [
                'dark:bg-gray-900',
                'dark:bg-gray-800',
                'dark:text-gray-100',
                'dark:text-gray-200',
                'dark:hover:bg-gray-700',
                'dark:border-gray-700',
            ]
        }
    </script>

    @stack('styles')
</head>

<body class="bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-100 font-sans">
    <div class="hidden">
        dark:bg-gray-900 dark:bg-gray-800 dark:text-gray-100 dark:text-gray-200 dark:hover:bg-gray-700
    </div>
    <div class="flex h-screen">

        <!-- Sidebar -->
        <aside class="w-64 bg-white dark:bg-gray-800 shadow-lg p-4 space-y-4 border-r border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-center mb-6">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="rounded-full w-20 h-20 shadow-md" />
            </div>
            <nav class="space-y-2 text-sm font-medium">
                <a href="{{ route('home') }}" class="block px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-blue-100 dark:hover:bg-gray-700 rounded flex items-center space-x-2 transition duration-150">
                    <span>🏠</span>
                    <span>Trang chủ</span>
                </a>
                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-blue-100 dark:hover:bg-gray-700 rounded flex items-center space-x-2 transition duration-150">
                    <span>📊</span>
                    <span>Bảng điều khiển</span>
                </a>
                <a href="{{ route('admin.villas.index') }}" class="block px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-blue-100 dark:hover:bg-gray-700 rounded flex items-center space-x-2 transition duration-150">
                    <span>🏡</span>
                    <span>Quản lý Villa</span>
                </a>
                <a href="{{ route('admin.resorts.index') }}" class="block px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-blue-100 dark:hover:bg-gray-700 rounded flex items-center space-x-2 transition duration-150">
                    <span>🏠</span>
                    <span>Quản lý Resort</span>
                </a>
                <a href="{{ route('homestays.index') }}" class="block px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-blue-100 dark:hover:bg-gray-700 rounded flex items-center space-x-2 transition duration-150">
                    <span>🏨️</span>
                    <span>Quản lý Homestay</span>
                </a>
                <a href="{{ route('flights.index') }}" class="block px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-blue-100 dark:hover:bg-gray-700 rounded flex items-center space-x-2 transition duration-150">
                    <span>✈︎</span>
                    <span>Quản lý Vé máy bay</span>
                </a>
                <a href="{{ route('admin.bookings.index') }}" class="block px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-blue-100 dark:hover:bg-gray-700 rounded flex items-center space-x-2 transition duration-150">
                    <span>📅</span>
                    <span>Quản lý Đặt lịch</span>
                </a>
                <a href="{{ route('admin.users.index') }}" class="block px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-blue-100 dark:hover:bg-gray-700 rounded flex items-center space-x-2 transition duration-150">
                    <span>👥</span>
                    <span>Quản lý người dùng</span>
                </a>
                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-blue-100 dark:hover:bg-gray-700 rounded flex items-center space-x-2 transition duration-150">
                    <span>👤</span>
                    <span>Hồ sơ</span>
                </a>
                <div class="block px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-blue-100 dark:hover:bg-gray-700 rounded flex items-center space-x-2 transition duration-150">
                    <button id="theme-toggle" class="w-full text-left">
                        🌗 Đổi giao diện
                    </button>
                </div>
            </nav>
        </aside>

        <!-- Main content -->
        <div class="flex-1 flex flex-col">
            <!-- Header -->
            <header class="bg-white dark:bg-gray-800 shadow-md flex justify-between items-center px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <div class="text-xl font-semibold text-gray-800 dark:text-gray-100">
                    @yield('title', 'Trang quản trị')
                </div>
                <div class="flex items-center space-x-6 text-sm">
                    <span class="text-gray-700 dark:text-gray-300">👋 Xin chào, <strong>{{ Auth::user()->name }}</strong></span>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-red-600 hover:text-red-800 hover:underline transition duration-150">
                            Đăng xuất
                        </button>
                    </form>
                </div>
            </header>

            <!-- Content -->
            <main class="p-6 overflow-y-auto">
                @yield('content')
            </main>
        </div>

    </div>
    @stack('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleBtn = document.getElementById('theme-toggle');
            const root = document.documentElement;

            if (!toggleBtn) return;

            toggleBtn.addEventListener('click', function() {
                const isDark = root.classList.contains('dark');
                root.classList.toggle('dark', !isDark);
                localStorage.setItem('theme', isDark ? 'light' : 'dark');
            });
        });
    </script>
</body>

</html>