<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email"
                          class="block mt-1 w-full"
                          type="email"
                          name="email"
                          :value="old('email')"
                          required
                          autofocus
                          autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password"
                          class="block mt-1 w-full"
                          type="password"
                          name="password"
                          required
                          autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me"
                       type="checkbox"
                       class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                       name="remember">
                <span class="ms-2 text-sm text-gray-600">
                    {{ __('Remember me') }}
                </span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                   href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>

    <!-- Divider -->
    <div class="my-6 flex items-center">
        <div class="flex-grow border-t border-gray-300"></div>
        <span class="mx-4 text-gray-500 text-sm">Hoặc</span>
        <div class="flex-grow border-t border-gray-300"></div>
    </div>

    <!-- Google Login Button -->
    <div>
        <a href="{{ route('google.redirect') }}"
           class="w-full inline-flex justify-center items-center px-4 py-2 bg-red-500 hover:bg-red-600 text-white font-semibold rounded-md shadow-sm transition duration-150 ease-in-out">

            <!-- Google Icon -->
            <svg class="w-5 h-5 mr-2" viewBox="0 0 48 48">
                <path fill="#ffffff"
                    d="M24 9.5c3.5 0 6.1 1.5 7.5 2.8l5.6-5.6C33.6 3.4 29.3 1.5 24 1.5 14.6 1.5 6.5 7.7 3.2 16.1l6.8 5.3C12 14.5 17.5 9.5 24 9.5z"/>
                <path fill="#ffffff"
                    d="M46.5 24c0-1.7-.2-3.3-.5-4.9H24v9.3h12.6c-.5 2.9-2.1 5.4-4.4 7.1l6.9 5.4C43.9 36.6 46.5 30.9 46.5 24z"/>
                <path fill="#ffffff"
                    d="M10 28.7c-1-2.9-1-6.1 0-9l-6.8-5.3C.8 18.2 0 21 0 24s.8 5.8 3.2 9.6l6.8-5.3z"/>
                <path fill="#ffffff"
                    d="M24 46.5c6.3 0 11.6-2.1 15.4-5.7l-6.9-5.4c-2 1.4-4.6 2.3-8.5 2.3-6.5 0-12-5-13.9-11.9l-6.8 5.3C6.5 40.3 14.6 46.5 24 46.5z"/>
            </svg>

            Đăng nhập bằng Google
        </a>
    </div>
</x-guest-layout>
