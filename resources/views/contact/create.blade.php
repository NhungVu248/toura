<x-app-layout>
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

<div class="container mx-auto px-4 py-12">

    <h1 class="text-4xl font-bold text-center mb-10">
        Liên hệ với chúng tôi
    </h1>

    <div class="grid md:grid-cols-2 gap-10">

        {{-- CONTACT INFORMATION --}}
        <div class="space-y-6">

            <h2 class="text-2xl font-semibold">
                Thông tin hỗ trợ
            </h2>

            <p class="text-gray-600">
                Nếu bạn cần hỗ trợ đặt tour hoặc có câu hỏi,
                hãy liên hệ với chúng tôi qua các thông tin bên dưới.
            </p>

            {{-- HOTLINE --}}
            <div class="flex items-center gap-3">
                <span class="text-xl">☎</span>
                <div>
                    <p class="font-semibold">Hotline</p>
                    <p class="text-gray-600">0784369189</p>
                </div>
            </div>

            {{-- EMAIL --}}
            <div class="flex items-center gap-3">
                <span class="text-xl">📧</span>
                <div>
                    <p class="font-semibold">Email hỗ trợ</p>
                    <p class="text-gray-600">23010221@st.phenikaa-uni.edu.vn</p>
                    <p class="text-gray-600">23010182@st.phenikaa-uni.edu.vn</p>
                </div>
            </div>

            {{-- SOCIAL --}}
            <div>
                <p class="font-semibold mb-2">Theo dõi chúng tôi</p>

                <div class="flex gap-4 text-blue-600">

                    <a href="#" class="hover:underline">
                        Facebook
                    </a>

                    <a href="#" class="hover:underline">
                        Instagram
                    </a>

                    <a href="#" class="hover:underline">
                        Zalo
                    </a>

                </div>
            </div>

            {{-- GOOGLE MAP --}}
            <div class="mt-6">

                <iframe
                    src="https://www.google.com/maps?q=Hanoi&output=embed"
                    width="100%"
                    height="250"
                    style="border:0;"
                    allowfullscreen=""
                    loading="lazy">
                </iframe>

            </div>

        </div>


        {{-- CONTACT FORM --}}
        <div class="bg-white shadow rounded-lg p-6">

            <h2 class="text-2xl font-semibold mb-6">
                Gửi tin nhắn cho chúng tôi
            </h2>

            @if(session('success'))
                <div class="bg-green-100 text-green-700 p-4 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('contact.store') }}" method="POST" class="space-y-4">
                @csrf

                {{-- NAME --}}
                <div>
                    <input
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        placeholder="Họ và tên"
                        class="w-full border rounded p-3"
                        required
                    >
                </div>

                {{-- PHONE --}}
                <div>
                    <input
                        type="text"
                        name="phone_number"
                        value="{{ old('phone_number') }}"
                        placeholder="Số điện thoại"
                        class="w-full border rounded p-3"
                    >
                </div>

                {{-- EMAIL --}}
                <div>
                    <input
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="Email"
                        class="w-full border rounded p-3"
                    >
                </div>

                {{-- MESSAGE --}}
                <div>
                    <textarea
                        name="message"
                        rows="5"
                        placeholder="Nội dung cần hỗ trợ..."
                        class="w-full border rounded p-3"
                        required
                    >{{ old('message') }}</textarea>
                </div>

                {{-- BUTTON --}}
                <button
                    type="submit"
                    class="w-full bg-blue-600 text-white py-3 rounded hover:bg-blue-700 transition"
                >
                    Gửi liên hệ
                </button>

            </form>

        </div>

    </div>

</div>

</x-app-layout>