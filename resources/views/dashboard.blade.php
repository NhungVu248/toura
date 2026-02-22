<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">

    <!-- Navbar -->
    <nav class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <h1 class="text-xl font-bold text-gray-800">
                Travel Booking System
            </h1>

            <div>
                @auth
                    <span class="mr-4 text-gray-700">
                        Xin chào, {{ auth()->user()->name }}
                    </span>
                    <a href="{{ route('profile.edit') }}"
                       class="text-blue-600 hover:underline mr-4">
                        Profile
                    </a>

                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button class="text-red-600 hover:underline">
                            Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}"
                       class="text-blue-600 hover:underline mr-4">
                        Đăng nhập
                    </a>

                    <a href="{{ route('register') }}"
                       class="text-green-600 hover:underline">
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