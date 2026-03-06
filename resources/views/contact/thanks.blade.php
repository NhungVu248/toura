<x-app-layout>

<meta http-equiv="refresh" content="5;url={{ url('/') }}">

<div class="container mx-auto px-4 py-20">

    <div class="max-w-3xl mx-auto text-center">

        {{-- LOTTIE ANIMATION --}}
        <div class="flex justify-center mb-6">

            <lottie-player
                src="https://assets2.lottiefiles.com/packages/lf20_jbrw3hcz.json"
                background="transparent"
                speed="1"
                style="width:180px;height:180px"
                autoplay>
            </lottie-player>

        </div>

        <h1 class="text-4xl font-bold mb-4">
            Gửi liên hệ thành công!
        </h1>

        <p class="text-gray-600 mb-6">
            Cảm ơn bạn đã liên hệ với chúng tôi.  
            Đội ngũ hỗ trợ sẽ phản hồi sớm nhất.
        </p>

        <p class="text-sm text-gray-400 mb-10">
            Bạn sẽ được chuyển về trang chủ sau 5 giây...
        </p>

        <div class="flex justify-center gap-4 mb-16">

            <a href="{{ url('/') }}"
               class="bg-blue-600 text-white px-6 py-3 rounded hover:bg-blue-700">
               Trang chủ
            </a>

            <a href="{{ route('tours.index') }}"
               class="border border-blue-600 text-blue-600 px-6 py-3 rounded hover:bg-blue-50">
               Xem Tours
            </a>

        </div>

    </div>


    {{-- TOUR SUGGESTIONS --}}
    <div>

        <h2 class="text-2xl font-bold text-center mb-8">
            Tour nổi bật dành cho bạn
        </h2>

        <div class="grid md:grid-cols-3 gap-6">

            @foreach($tours as $tour)

            <div class="border rounded-lg overflow-hidden shadow hover:shadow-lg transition">

                <img
                    src="{{ asset('storage/'.$tour->thumbnail) }}"
                    class="w-full h-44 object-cover"
                >

                <div class="p-4">

                    <h3 class="font-semibold mb-2">
                        {{ $tour->title }}
                    </h3>

                    <p class="text-gray-500 text-sm mb-3">
                        {{ $tour->destination }}
                    </p>

                    <p class="text-blue-600 font-bold mb-3">
                        {{ number_format($tour->price_adult) }} VND
                    </p>

                    <a
                        href="{{ route('tours.show',$tour->slug) }}"
                        class="text-sm text-blue-600 font-medium"
                    >
                        Xem chi tiết →
                    </a>

                </div>

            </div>

            @endforeach

        </div>

    </div>

</div>


{{-- LOTTIE SCRIPT --}}
<script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>

</x-app-layout>