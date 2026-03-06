<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 flex flex-col">
            
            @include('layouts.navigation')

           <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <main class="flex-grow">
                {{ $slot }}
            </main>

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
            </div>
    </body>
</html>
