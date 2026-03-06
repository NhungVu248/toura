<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 flex flex-col min-h-screen">

    <nav class="bg-gradient-to-r from-pink-500 via-pink-400 to-yellow-400 text-white">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">

            <div class="flex items-center space-x-2">
                <span class="text-2xl font-bold">🌍 Toura</span>
            </div>

            <div class="hidden md:flex space-x-6 font-medium">
                <a href="/" class="px-4 py-2 bg-white text-pink-600 rounded-full font-semibold">
                    Trang Chủ
                </a>
                <a href="#" class="hover:text-black transition">Giới Thiệu</a>
                <a href="{{ route('tours.index') }}" class="hover:text-black transition">Tours</a>
                <a href="#" class="hover:text-black transition">Blog</a>
                <a href="#" class="hover:text-black transition">Liên Hệ</a>
            </div>

            <div class="flex items-center space-x-4 relative">

                <div class="hidden md:flex items-center bg-white rounded-full overflow-hidden">
                    <input type="text"
                           placeholder="Search..."
                           class="px-4 py-1 text-black focus:outline-none">
                    <button class="px-3 text-black">
                        🔍
                    </button>
                </div>

                @auth
                    <div x-data="{ open: false }" class="relative">

                        <button @click="open = !open"
                                class="flex items-center space-x-2 font-semibold focus:outline-none">
                            <span>{{ auth()->user()->name }}</span>
                            <span>⌄</span>
                        </button>

                        <div x-show="open"
                            @click.away="open = false"
                            x-transition
                            class="absolute right-0 mt-2 w-44 bg-white text-black rounded-lg shadow-lg py-2 z-50">

                            <a href="{{ route('profile.edit') }}"
                            class="block px-4 py-2 hover:bg-gray-100">
                                👤 Profile
                            </a>

                            <a href="{{ route('booking.my') }}"
                            class="block px-4 py-2 hover:bg-gray-100">
                                📑 My Bookings
                            </a>

                            <div class="border-t my-1"></div>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                        class="w-full text-left px-4 py-2 hover:bg-gray-100">
                                    🚪 Logout
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
    
    <div class="py-16 text-center flex-grow">
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

    <footer class="bg-[#0f172a] text-gray-300 py-10 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                
                <div>
                    <h3 class="text-[#f43f5e] text-2xl font-bold mb-4">Toura</h3>
                    <p class="text-sm text-gray-400 leading-relaxed">
                        Khám phá thế giới cùng Toura - Đối tác du lịch tin cậy của bạn
                    </p>
                </div>

                <div>
                    <h4 class="text-white font-semibold mb-4">Về chúng tôi</h4>
                    <ul class="space-y-3 text-sm text-gray-400">
                        <li><a href="#" class="hover:text-white transition">Giới thiệu</a></li>
                        <li><a href="#" class="hover:text-white transition">Liên hệ</a></li>
                        <li><a href="#" class="hover:text-white transition">Tuyển dụng</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-white font-semibold mb-4">Hỗ trợ</h4>
                    <ul class="space-y-3 text-sm text-gray-400">
                        <li><a href="#" class="hover:text-white transition">Câu hỏi thường gặp</a></li>
                        <li><a href="#" class="hover:text-white transition">Chính sách</a></li>
                        <li><a href="#" class="hover:text-white transition">Điều khoản</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-white font-semibold mb-4">Liên hệ</h4>
                    <ul class="space-y-3 text-sm text-gray-400">
                        <li>Email: info@toura.vn</li>
                        <li>Hotline: 1900 xxxx</li>
                        <li>Địa chỉ: Hà Nội, Việt Nam</li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-700 mt-10 pt-6 text-center text-sm text-gray-400">
                © 2026 Toura. All rights reserved.
            </div>
        </div>
    </footer>
    </body>
</html>