<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">

    <!-- Navbar -->
<nav class="bg-gradient-to-r from-pink-500 via-pink-400 to-yellow-400 text-white">
    <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">

        <!-- Logo -->
        <div class="flex items-center space-x-2">
            <span class="text-2xl font-bold">🌍 Toura</span>
        </div>

        <!-- Menu -->
        <div class="hidden md:flex space-x-6 font-medium">
            <a href="/" class="px-4 py-2 bg-white text-pink-600 rounded-full font-semibold">
                Trang Chủ
            </a>
            <a href="#" class="hover:text-black transition">Giới Thiệu</a>
            <a href="#" class="hover:text-black transition">Tours</a>
            <a href="#" class="hover:text-black transition">Điểm Đến</a>
            <a href="#" class="hover:text-black transition">Liên Hệ</a>
        </div>

        <!-- Right Section -->
        <div class="flex items-center space-x-4 relative">

            <!-- Search -->
            <div class="hidden md:flex items-center bg-white rounded-full overflow-hidden">
                <input type="text"
                       placeholder="Search..."
                       class="px-4 py-1 text-black focus:outline-none">
                <button class="px-3 text-black">
                    🔍
                </button>
            </div>

            <!-- Auth -->
            @auth
                <div x-data="{ open: false }" class="relative">

                    <!-- Username button -->
                    <button @click="open = !open"
                            class="flex items-center space-x-2 font-semibold focus:outline-none">
                        <span>{{ auth()->user()->name }}</span>
                        <span>⌄</span>
                    </button>

                    <!-- Dropdown -->
                    <div x-show="open"
                         @click.away="open = false"
                         x-transition
                         class="absolute right-0 mt-2 w-40 bg-white text-black rounded-lg shadow-lg py-2 z-50">

                        <a href="{{ route('profile.edit') }}"
                           class="block px-4 py-2 hover:bg-gray-100">
                            Profile
                        </a>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                    class="w-full text-left px-4 py-2 hover:bg-gray-100">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}"
                   class="font-semibold hover:text-black">
                    Đăng nhập
                </a>

                <a href="{{ route('register') }}"
                   class="bg-white text-pink-600 px-4 py-2 rounded-full font-semibold hover:bg-gray-100">
                    Đăng ký
                </a>
            @endauth

        </div>

    </div>
</nav>
    <!-- Main content -->
    <div class="py-16 text-center">
        <h2 class="text-3xl font-bold text-gray-800 mb-4">
            Hệ thống Booking Du Lịch
        </h2>

        <p class="text-gray-600 mb-6">
            Khám phá tour phù hợp với bạn.
        </p>

        @auth
            <a href="#"
               class="px-6 py-3 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition">
                Đặt tour ngay
            </a>
        @else
            <a href="{{ route('register') }}"
               class="px-6 py-3 bg-green-600 text-white rounded-lg shadow hover:bg-green-700 transition">
                Bắt đầu ngay
            </a>
        @endauth
    </div>

</body>
</html>