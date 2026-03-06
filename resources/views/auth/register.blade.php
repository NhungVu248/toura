<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased font-sans">

    <div class="relative min-h-screen bg-cover bg-center bg-no-repeat flex items-center justify-center p-6" 
        style="background-image: url({{ asset('img/nen.png') }});">
        
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
                    
                    <h2 class="text-2xl font-semibold mb-6 text-center">Create an Account</h2>

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div>
                            <label for="name" class="block text-sm font-medium mb-1">Name</label>
                            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                                class="w-full px-4 py-3 rounded-md bg-white text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-400 border-none"
                                placeholder="Enter your full name">
                            <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-300" />
                        </div>

                        <div class="mt-4">
                            <label for="email" class="block text-sm font-medium mb-1">Email</label>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                                class="w-full px-4 py-3 rounded-md bg-white text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-400 border-none"
                                placeholder="Enter your email">
                            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-300" />
                        </div>

                        <div class="mt-4">
                            <label for="password" class="block text-sm font-medium mb-1">Password</label>
                            <input id="password" type="password" name="password" required autocomplete="new-password"
                                class="w-full px-4 py-3 rounded-md bg-white text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-400 border-none"
                                placeholder="**********">
                            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-300" />
                        </div>

                        <div class="mt-4">
                            <label for="password_confirmation" class="block text-sm font-medium mb-1">Confirm Password</label>
                            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                                class="w-full px-4 py-3 rounded-md bg-white text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-400 border-none"
                                placeholder="**********">
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-300" />
                        </div>

                        <div class="mt-6">
                            <button type="submit" class="w-full py-3 bg-blue-500 hover:bg-blue-600 text-white font-semibold rounded-md transition duration-200">
                                REGISTER
                            </button>
                        </div>
                    </form>

                    <div class="mt-6 text-center text-sm">
                        Already registered? 
                        <a href="{{ route('login') }}" class="underline font-medium hover:text-gray-200 transition">
                            Sign In
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</body>
</html>
