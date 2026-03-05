<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased font-sans">

    <div class="relative min-h-screen bg-cover bg-center bg-no-repeat flex items-center justify-center p-6" 
         style="background-image: url('https://images.unsplash.com/photo-1499793983690-e29da59ef1c2?q=80&w=2070&auto=format&fit=crop');">
        
        <div class="absolute inset-0 bg-black/30"></div>

        <div class="relative z-10 w-full max-w-6xl grid grid-cols-1 md:grid-cols-2 gap-10 items-center">
            
            <div class="text-white hidden md:block">
                <div class="flex items-center space-x-2 text-3xl font-bold tracking-widest mb-6">
                    <span>TRAVEL</span>
                    <svg class="w-8 h-8 transform -rotate-45" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                    </svg>
                </div>
                
                <h1 class="text-6xl lg:text-7xl font-bold uppercase leading-tight">
                    TOURA
                </h1>
                
                <p class="text-xl mt-6 font-medium">
                    Where Your Dream Destinations<br>Become Reality.
                </p>
                
                <p class="mt-4 text-sm text-gray-200">
                    Embark on a journey where every corner<br>of the world is within your reach.
                </p>
            </div>

            <div class="w-full max-w-md mx-auto">
                <div class="bg-white/20 backdrop-blur-md border border-white/30 rounded-2xl p-8 shadow-2xl text-white">
                    
                    <x-auth-session-status class="mb-4 text-green-300" :status="session('status')" />

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div>
                            <label for="email" class="block text-sm font-medium mb-1">Email</label>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                                class="w-full px-4 py-3 rounded-md bg-white text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-400 border-none"
                                placeholder="Enter your email">
                            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-300" />
                        </div>

                        <div class="mt-5">
                            <label for="password" class="block text-sm font-medium mb-1">Password</label>
                            <input id="password" type="password" name="password" required
                                class="w-full px-4 py-3 rounded-md bg-white text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-400 border-none"
                                placeholder="**********">
                            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-300" />
                        </div>

                        <div class="flex items-center justify-between mt-4">
                            <label for="remember_me" class="flex items-center cursor-pointer">
                                <input id="remember_me" type="checkbox" name="remember" 
                                    class="rounded border-none text-blue-500 shadow-sm focus:ring-blue-400 focus:ring-opacity-50 bg-white cursor-pointer w-4 h-4">
                                <span class="ml-2 text-sm text-gray-200 select-none">Remember me</span>
                            </label>

                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-sm text-gray-200 hover:text-white underline transition">
                                    Forgot password?
                                </a>
                            @endif
                        </div>

                        <div class="mt-6">
                            <button type="submit" class="w-full py-3 bg-blue-500 hover:bg-blue-600 text-white font-semibold rounded-md transition duration-200">
                                SIGN IN
                            </button>
                        </div>
                    </form>

                    <div class="my-6 flex items-center">
                        <div class="flex-grow border-t border-white/40"></div>
                        <span class="mx-4 text-white/80 text-sm">or</span>
                        <div class="flex-grow border-t border-white/40"></div>
                    </div>

                    <div class="mb-4">
                        <a href="{{ route('google.redirect') ?? '#' }}" 
                           class="w-full flex justify-center items-center py-2.5 bg-transparent hover:bg-white/10 border border-transparent font-medium rounded-md transition duration-200 text-white">
                            <svg class="w-5 h-5 mr-3" viewBox="0 0 48 48">
                                <path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"></path>
                                <path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z"></path>
                                <path fill="#FBBC05" d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z"></path>
                                <path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"></path>
                            </svg>
                            Sign in with Google
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</body>
</html>