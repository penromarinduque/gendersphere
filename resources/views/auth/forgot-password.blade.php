<x-guest-layout>
    <div class="relative">
        <!-- Form Container with solid background -->
        <div class="max-w-md w-full mx-auto bg-white p-6 rounded-lg shadow-md border border-gray-200">
            <!-- Gradient top accent line -->
            <div class="h-1 w-full bg-gradient-to-r from-purple-500 to-pink-500 rounded-t mb-6"></div>
            
            <div class="mb-4 text-sm bg-gradient-to-r from-purple-700 to-pink-600 bg-clip-text text-transparent font-medium">
                {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to create a new one.') }}
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Email')" class="font-medium text-purple-600" />
                    <x-text-input id="email" class="block mt-1 w-full border-purple-300 focus:border-pink-500 focus:ring focus:ring-pink-200 focus:ring-opacity-50" type="email" name="email" :value="old('email')" required autofocus />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end mt-6">
                    <x-primary-button class="bg-gradient-to-r from-purple-600 to-pink-500 hover:from-purple-700 hover:to-pink-600 focus:ring-pink-500">
                        {{ __('Email Password Reset Link') }}
                    </x-primary-button>
                </div>
            </form>
            
            <!-- Gradient bottom accent line -->
            <div class="h-1 w-full bg-gradient-to-r from-pink-500 to-purple-500 rounded-b mt-6"></div>
        </div>
    </div>
</x-guest-layout>