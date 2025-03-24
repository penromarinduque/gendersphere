<x-guest-layout>
    <!-- Main container with light gray background, ensure full transparency -->
    <div class="min-h-screen bg-transparent flex flex-col justify-center items-center p-4 pt-20">
        
        <!-- Form card with white background -->
        <div class="relative w-full sm:max-w-md rounded-lg mx-auto overflow-hidden">
            
            <!-- White background -->
            <div class="absolute inset-0 bg-white rounded-lg shadow-lg"></div>
            
            <!-- Decorative lines on sides -->
            <div class="absolute left-0 top-0 bottom-0 w-2 bg-gradient-to-b from-purple-700 to-pink-500"></div>
            <div class="absolute right-0 top-0 bottom-0 w-2 bg-gradient-to-b from-pink-500 to-purple-700"></div>
            
            <!-- Text content inside the card -->
            <div class="mb-6 text-center relative z-10 pt-6">
                <div class="w-16 h-16 mx-auto mb-4 flex items-center justify-center rounded-full bg-gradient-to-br from-purple-600 to-pink-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <!-- Title with gradient text -->
                <h2 class="text-2xl font-bold bg-gradient-to-r from-purple-700 via-fuchsia-600 to-pink-500 text-transparent bg-clip-text">GenderSphere</h2>
                <p class="text-sm text-gray-500 mt-2">Sign in to your account</p>
            </div>
            
            <!-- Session Status -->
            <x-auth-session-status class="mb-4 text-purple-600" :status="session('status')" />
            
            <!-- Form -->
            <form method="POST" action="{{ route('login') }}" class="relative z-10 px-6 pb-6 rounded-lg shadow-lg">
                @csrf

                <!-- Email Address -->
                <div class="relative">
                    <x-input-label for="email" :value="__('Email')" class="text-sm font-medium text-purple-600" />
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-pink-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                            </svg>
                        </div>
                        <x-text-input id="email" class="block mt-1 w-full pl-10 px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:border-fuchsia-400 focus:ring focus:ring-pink-200 focus:ring-opacity-50" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                    </div>
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <div class="flex items-center justify-between">
                        <x-input-label for="password" :value="__('Password')" class="text-sm font-medium text-purple-600" />
                        @if (Route::has('password.request'))
                            <a class="text-xs text-pink-500 hover:text-purple-700" href="{{ route('password.request') }}">
                                {{ __('Forgot your password?') }}
                            </a>
                        @endif
                    </div>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-pink-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <x-text-input id="password" class="block mt-1 w-full pl-10 px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:border-fuchsia-400 focus:ring focus:ring-pink-200 focus:ring-opacity-50"
                                        type="password"
                                        name="password"
                                        required autocomplete="current-password" />
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Submit Button - Gender and Development theme colors -->
                <div class="mt-6">
                    <x-primary-button class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gradient-to-r from-purple-600 to-pink-500 hover:from-purple-700 hover:to-pink-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-fuchsia-500 transition-all duration-150">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                        </svg>
                        {{ __('Log in') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>