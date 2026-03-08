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

        <!-- Logo -->
        <div class="flex items-center space-x-2">
            <span class="text-2xl font-bold">🌍 Toura</span>
        </div>

        <!-- Menu -->
        <div class="hidden md:flex space-x-6 font-medium">
            <a href="/" class="px-4 py-2 bg-white text-pink-600 rounded-full font-semibold">
                Trang Chủ
            </a>
            <a href="{{ route('about') }}" class="hover:text-black transition">Giới Thiệu</a>
            <a href="{{ route('tours.index') }}" class="hover:text-black transition">Tours</a>
            <a href="{{ route('destination.index') }}" class="hover:text-black transition">Điểm Đến</a>
            <a href="{{ route('contact.create') }}" class="hover:text-black transition">Liên Hệ</a>
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
    
    <div class="relative py-32 text-center flex-grow bg-cover bg-center" 
     style="background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('{{ asset('img/nen.png') }}');">
    
    <div class="relative z-10">
        <h2 class="text-4xl font-bold text-white mb-4 drop-shadow-lg">
            Hệ thống Booking Du Lịch
        </h2>

        <p class="text-gray-100 mb-8 text-lg drop-shadow-md">
            Khám phá tour phù hợp với bạn.
        </p>

        @auth
            <a href="#"
               class="px-8 py-4 bg-pink-500 text-white font-bold rounded-lg shadow-lg hover:bg-pink-600 transition">
                 Đặt tour ngay
            </a>
        @else
            <a href="{{ route('register') }}"
               class="px-8 py-4 bg-green-500 text-white font-bold rounded-lg shadow-lg hover:bg-green-600 transition">
                 Bắt đầu ngay
            </a>
        @endauth
    </div>
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