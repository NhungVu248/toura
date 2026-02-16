<x-app-layout>
    <div class="max-w-md mx-auto mt-10">
        <h2 class="text-xl font-bold mb-4">Xác thực Email</h2>

        <p>Chúng tôi đã gửi email kích hoạt. Vui lòng kiểm tra hộp thư.</p>

        @if (session('status') == 'verification-link-sent')
            <p class="text-green-600 mt-2">
                Đã gửi lại email kích hoạt.
            </p>
        @endif

        <form method="POST" action="{{ route('auth.activate.resend') }}" class="mt-4">
            @csrf
            <input type="email" name="email"
                   placeholder="Nhập email để gửi lại"
                   required
                   class="border p-2 w-full" />

            <button type="submit"
                    class="mt-2 px-4 py-2 bg-blue-500 text-white rounded">
                Gửi lại email kích hoạt
            </button>
        </form>
    </div>
</x-app-layout>
