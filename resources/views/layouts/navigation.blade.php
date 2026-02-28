<nav x-data="{ open: false }"
     class="bg-gradient-to-r from-pink-500 via-pink-400 to-yellow-400 shadow-lg">

    <div class="max-w-7xl mx-auto px-6">
        <div class="flex justify-between h-16 items-center">

            <!-- Logo -->
            <div class="flex items-center space-x-2">
                <a href="{{ route('dashboard') }}"
                   class="text-2xl font-bold text-white">
                    🌍 Toura
                </a>
            </div>

            <!-- Desktop Menu -->
            <div class="hidden md:flex space-x-8 font-medium text-white">

                <a href="/"
                class="px-4 py-2 rounded-full font-semibold
                {{ request()->is('/') 
                        ? 'bg-white text-pink-600' 
                        : 'hover:text-black transition text-white' }}">
                    Trang Chủ
                </a>

                <a href="#" class="hover:text-black transition">Giới Thiệu</a>
                <a href="{{ route('tours.index') }}"
                    class="px-4 py-2 rounded-full font-semibold
                    {{ request()->routeIs('tours.*') 
                            ? 'bg-white text-pink-600' 
                            : 'hover:text-black transition text-white' }}">
                        Tours
                    </a>
                <a href="#" class="hover:text-black transition">Điểm Đến</a>
                <a href="#" class="hover:text-black transition">Liên Hệ</a>
            </div>

            <!-- Right Section -->
            <div class="hidden md:flex items-center space-x-6 text-white">

                @auth
                    <div class="relative" x-data="{ dropdown: false }">

                        <button @click="dropdown = !dropdown"
                                class="flex items-center space-x-2 font-semibold">
                            <span>{{ Auth::user()->name }}</span>
                            <svg class="w-4 h-4"
                                 fill="none"
                                 stroke="currentColor"
                                 viewBox="0 0 24 24">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-width="2"
                                      d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <!-- Dropdown -->
                        <div x-show="dropdown"
                             @click.away="dropdown = false"
                             x-transition
                             class="absolute right-0 mt-3 w-44 bg-white text-gray-800 rounded-xl shadow-xl z-50">

                            <a href="{{ route('profile.edit') }}"
                               class="block px-4 py-3 hover:bg-gray-100">
                                Profile
                            </a>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                        class="w-full text-left px-4 py-3 hover:bg-gray-100">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}"
                       class="hover:text-black font-semibold">
                        Đăng nhập
                    </a>

                    <a href="{{ route('register') }}"
                       class="bg-white text-pink-600 px-4 py-2 rounded-full font-semibold hover:bg-gray-100">
                        Đăng ký
                    </a>
                @endauth
            </div>

            <!-- Mobile Hamburger -->
            <div class="md:hidden flex items-center">
                <button @click="open = !open"
                        class="text-white focus:outline-none">
                    ☰
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div x-show="open"
         class="md:hidden bg-pink-500 text-white px-6 py-4 space-y-3">

        <a href="/" class="block">Trang Chủ</a>
        <a href="#" class="block">Giới Thiệu</a>
        <a href="{{ route('tours.index') }}" class="block">Tours</a>
        <a href="#" class="block">Điểm Đến</a>
        <a href="#" class="block">Liên Hệ</a>

        @auth
            <div class="border-t border-pink-300 pt-3">
                <a href="{{ route('profile.edit') }}" class="block mb-2">
                    Profile
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="block text-left w-full">
                        Logout
                    </button>
                </form>
            </div>
        @endauth
    </div>

</nav>