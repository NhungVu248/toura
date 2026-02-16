<x-app-layout>
    <div class="max-w-md mx-auto mt-10 text-center">
        @if ($status === 'success')
            <h2 class="text-2xl font-bold mb-4 text-green-600">
                Kích hoạt thành công!
            </h2>

            <p>Bạn đã được đăng nhập và sẽ được chuyển đến dashboard.</p>

            <script>
                setTimeout(function(){
                    window.location = "{{ route('dashboard') }}";
                }, 1200);
            </script>

        @elseif ($status === 'expired')
            <h2 class="text-2xl font-bold mb-4 text-red-600">
                Link đã hết hạn
            </h2>

            <a href="{{ route('verification.notice') }}"
               class="mt-4 inline-block px-4 py-2 bg-blue-500 text-white rounded">
                Gửi lại email
            </a>

        @else
            <h2 class="text-2xl font-bold mb-4 text-red-600">
                Link không hợp lệ
            </h2>

            <a href="{{ route('verification.notice') }}"
               class="mt-4 inline-block px-4 py-2 bg-blue-500 text-white rounded">
                Gửi email kích hoạt
            </a>
        @endif
    </div>
</x-app-layout>
