<x-app-layout>
    
    <div class="flex-grow">
        
        <section class="py-24 px-6 text-center bg-cover bg-center bg-no-repeat bg-black/50 bg-blend-overlay" 
                style="background-image: url('{{ asset('img/nen.png') }}');">
           <div class="max-w-4xl mx-auto">
        
            <h1 class="text-4xl md:text-5xl font-extrabold text-white mb-6">
                Khám Phá Thế Giới Cùng Toura
            </h1>
        
            <p class="text-lg text-gray-100 mb-8 leading-relaxed">
                Tìm kiếm và đặt tour du lịch yêu thích của bạn
            </p>
        
            <a href="{{ route('tours.index') }}" class="inline-block px-8 py-4 bg-pink-500 text-white rounded-full font-bold text-lg shadow-lg hover:bg-pink-600 transition duration-300">
                Khám phá tour
            </a>
            </div>
        </section>

        <section class="max-w-7xl mx-auto px-6 py-20 grid md:grid-cols-2 gap-12">
            <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
                <h2 class="text-3xl font-bold text-gray-800 mb-6">Về hệ thống của chúng tôi</h2>
                <p class="text-gray-600 mb-4 leading-relaxed">
                    Trang web được xây dựng nhằm hỗ trợ người dùng tìm kiếm và đặt tour du lịch trực tuyến một cách nhanh chóng và tiện lợi. Hệ thống cung cấp đầy đủ thông tin về các tour du lịch, bao gồm địa điểm, lịch trình, giá cả và các dịch vụ đi kèm.
                </p>
                <p class="text-gray-600 leading-relaxed mb-6">
                    Ngoài ra, hệ thống còn tích hợp chức năng gợi ý tour thông minh, giúp người dùng khám phá các chuyến đi phù hợp với sở thích và nhu cầu cá nhân.
                </p>
                
            </div>

            <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
                <h2 class="text-3xl font-bold text-gray-800 mb-6">Mục tiêu của hệ thống</h2>
                <p class="text-gray-600 mb-4 font-medium">Hệ thống được xây dựng nhằm:</p>
                <ul class="space-y-3 text-gray-600 mb-6">
                    <li class="flex items-start"><span class="text-pink-500 mr-2">📌</span> Giúp người dùng tìm kiếm và đặt tour trực tuyến dễ dàng</li>
                    <li class="flex items-start"><span class="text-pink-500 mr-2">📌</span> Cung cấp thông tin chi tiết về các tour du lịch</li>
                    <li class="flex items-start"><span class="text-pink-500 mr-2">📌</span> Tích hợp gợi ý tour dựa trên hành vi người dùng</li>
                    <li class="flex items-start"><span class="text-pink-500 mr-2">📌</span> Hỗ trợ quản lý tour và booking cho quản trị viên</li>
                    <li class="flex items-start"><span class="text-pink-500 mr-2">📌</span> Nâng cao trải nghiệm đặt tour thông qua giao diện thân thiện và tiện lợi</li>
                </ul>
                
            </div>
        </section>

        <section class="bg-gray-50 py-20">
            <div class="max-w-7xl mx-auto px-6">
                <h2 class="text-3xl font-bold text-center text-gray-800 mb-12">Các Chức Năng Chính</h2>
                <div class="grid md:grid-cols-2 gap-8">
                    <div class="bg-white p-8 rounded-2xl shadow-md border-t-4 border-pink-500">
                        <h3 class="text-xl font-bold text-pink-600 mb-6 flex items-center">
                            <span class="text-2xl mr-2">🧑‍💻</span> Đối với khách hàng
                        </h3>
                        <ul class="space-y-4 text-gray-600 font-medium">
                            <li class="flex items-center"><span class="mr-3 text-green-500 text-lg">✓</span> Đăng ký / đăng nhập tài khoản</li>
                            <li class="flex items-center"><span class="mr-3 text-green-500 text-lg">✓</span> Tìm kiếm tour theo địa điểm, giá, thời gian</li>
                            <li class="flex items-center"><span class="mr-3 text-green-500 text-lg">✓</span> Xem thông tin chi tiết tour</li>
                            <li class="flex items-center"><span class="mr-3 text-green-500 text-lg">✓</span> Đặt tour trực tuyến</li>
                            <li class="flex items-center"><span class="mr-3 text-green-500 text-lg">✓</span> Thanh toán và quản lý lịch sử đặt tour</li>
                            <li class="flex items-center"><span class="mr-3 text-green-500 text-lg">✓</span> Đánh giá và nhận xét tour</li>
                            <li class="flex items-center"><span class="mr-3 text-green-500 text-lg">✓</span> Nhận gợi ý tour phù hợp</li>
                        </ul>
                    </div>
                    <div class="bg-white p-8 rounded-2xl shadow-md border-t-4 border-blue-500">
                        <h3 class="text-xl font-bold text-blue-600 mb-6 flex items-center">
                            <span class="text-2xl mr-2">⚙️</span> Đối với quản trị viên
                        </h3>
                        <ul class="space-y-4 text-gray-600 font-medium">
                            <li class="flex items-center"><span class="mr-3 text-green-500 text-lg">✓</span> Quản lý tour du lịch</li>
                            <li class="flex items-center"><span class="mr-3 text-green-500 text-lg">✓</span> Quản lý người dùng</li>
                            <li class="flex items-center"><span class="mr-3 text-green-500 text-lg">✓</span> Quản lý booking</li>
                            <li class="flex items-center"><span class="mr-3 text-green-500 text-lg">✓</span> Thống kê và theo dõi dữ liệu hệ thống</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <section class="max-w-7xl mx-auto px-6 py-20 text-center">
            <h2 class="text-3xl font-bold text-gray-800 mb-10">Công Nghệ Sử Dụng</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-10">
                <div class="p-6 bg-white rounded-xl shadow border border-gray-100">
                    <h4 class="font-bold text-lg mb-3 text-blue-600">Frontend</h4>
                    <p class="text-gray-600 text-sm font-medium">HTML / CSS / Bootstrap</p>
                </div>
                <div class="p-6 bg-white rounded-xl shadow border border-gray-100">
                    <h4 class="font-bold text-lg mb-3 text-red-500">Backend</h4>
                    <p class="text-gray-600 text-sm font-medium">Laravel Framework</p>
                    <p class="text-gray-600 text-sm font-medium">RESTful API</p>
                </div>
                <div class="p-6 bg-white rounded-xl shadow border border-gray-100">
                    <h4 class="font-bold text-lg mb-3 text-indigo-500">Database</h4>
                    <p class="text-gray-600 text-sm font-medium">MySQL</p>
                </div>
                <div class="p-6 bg-white rounded-xl shadow border border-gray-100">
                    <h4 class="font-bold text-lg mb-3 text-emerald-500">Hạ tầng</h4>
                    <p class="text-gray-600 text-sm font-medium">Cloud Hosting</p>
                    <p class="text-gray-600 text-sm font-medium">Client – Server</p>
                </div>
            </div>
            <div class="bg-indigo-50 p-6 rounded-xl inline-block text-left">
                <p class="text-gray-700 font-medium">
                    Hệ thống được xây dựng theo mô hình Client – Server Architecture với frontend và backend tách biệt để dễ dàng mở rộng trong tương lai.
                </p>
            </div>
            
        </section>

        <section class="bg-gray-800 py-20 text-white">
            <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-2 gap-12">
                <div>
                    <h2 class="text-3xl font-bold mb-8 text-white">Lợi Ích Của Hệ Thống</h2>
                    <div class="mb-6">
                        <h3 class="text-xl font-bold mb-4 text-pink-400">Dành cho người dùng</h3>
                        <ul class="space-y-3 text-gray-300">
                            <li><span class="text-green-400 mr-2">✔</span> Tiết kiệm thời gian tìm kiếm tour</li>
                            <li><span class="text-green-400 mr-2">✔</span> Dễ dàng so sánh các chuyến đi</li>
                            <li><span class="text-green-400 mr-2">✔</span> Đặt tour nhanh chóng và thuận tiện</li>
                            <li><span class="text-green-400 mr-2">✔</span> Nhận gợi ý tour phù hợp với sở thích</li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold mb-4 text-yellow-400">Đối với doanh nghiệp</h3>
                        <ul class="space-y-3 text-gray-300">
                            <li><span class="text-green-400 mr-2">✔</span> Quản lý dữ liệu tour tập trung</li>
                            <li><span class="text-green-400 mr-2">✔</span> Theo dõi booking và khách hàng</li>
                            <li><span class="text-green-400 mr-2">✔</span> Phân tích hoạt động kinh doanh hiệu quả</li>
                        </ul>
                    </div>
                </div>

                <div class="bg-gray-700 p-8 rounded-2xl text-center">
                    <h2 class="text-3xl font-bold text-white mb-8">Nhóm Phát Triển</h2>
                    <div class="flex flex-col md:flex-row justify-center gap-10">
                        <div class="text-center">
                            <div class="w-20 h-20 mx-auto bg-pink-100 text-pink-500 rounded-full flex items-center justify-center text-2xl font-bold mb-3 shadow-md">N</div>
                            <h3 class="text-lg font-bold text-white">Vũ Hồng Nhung</h3>
                            <p class="text-pink-400 text-sm font-semibold">Founder</p>
                            <p class="text-xs text-gray-400 max-w-[150px] mx-auto">SV CNTT - ĐH Phenikaa</p>
                        </div>
                        <div class="text-center">
                            <div class="w-20 h-20 mx-auto bg-blue-100 text-blue-500 rounded-full flex items-center justify-center text-2xl font-bold mb-3 shadow-md">T</div>
                            <h3 class="text-lg font-bold text-white">Mai Huy Thành</h3>
                            <p class="text-blue-400 text-sm font-semibold mb-2">Developer</p>
                            <p class="text-xs text-gray-400 max-w-[150px] mx-auto">SV CNTT - ĐH Phenikaa</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="bg-gradient-to-r from-pink-500 via-pink-400 to-yellow-400 py-20 text-center text-white">
            <div class="max-w-3xl mx-auto px-6">
                <h2 class="text-3xl md:text-4xl font-bold mb-8 leading-tight">
                    Hãy khám phá các tour du lịch hấp dẫn <br class="hidden md:block"> và bắt đầu hành trình của bạn ngay hôm nay.
                </h2>
                <a href="{{ route('tours.index') }}" class="inline-block px-10 py-4 bg-white text-pink-600 rounded-full font-bold text-lg shadow-lg hover:bg-gray-100 hover:scale-105 transition transform duration-300">
                    Khám phá tour
                </a>
            </div>
        </section>

    </div>

</x-app-layout>