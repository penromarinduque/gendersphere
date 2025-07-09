<x-guest-layout>
    <!-- Spacer to push content down below header -->
    <div class="h-24 md:h-32"></div>
    
    <div class="w-full max-w-md mx-auto bg-white rounded-lg shadow-xl overflow-hidden border border-gray-100 relative">
        <!-- Gradient top accent bar -->
        <div class="h-2 bg-gradient-to-r from-purple-600 to-pink-500"></div>
        
        <div class="px-6 py-8">
            <h2 class="text-2xl font-bold text-center mb-8 bg-gradient-to-r from-purple-600 to-pink-500 bg-clip-text text-transparent">Reset Password</h2>
            
            <form method="POST" action="{{ route('password.store') }}" class="space-y-6">
                @csrf

                <!-- Password Reset Token -->
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <!-- Email Address -->
                <div class="space-y-2">
                    <x-input-label for="email" :value="__('Email')" class="text-sm font-medium text-gray-700" />
                    <x-text-input 
                        id="email" 
                        class="w-full px-4 py-3 rounded-md border border-gray-300 focus:border-purple-500 focus:ring focus:ring-pink-200 focus:ring-opacity-50 transition duration-150 ease-in-out" 
                        type="email" 
                        name="email" 
                        :value="old('email', $request->email)" 
                        required 
                        autofocus 
                        autocomplete="username" 
                    />
                    <x-input-error :messages="$errors->get('email')" class="text-sm text-red-600" />
                </div>

                <!-- Password -->
                <div class="space-y-2">
                    <x-input-label for="password" :value="__('Password')" class="text-sm font-medium text-gray-700" />
                    <x-text-input 
                        id="password" 
                        class="w-full px-4 py-3 rounded-md border border-gray-300 focus:border-purple-500 focus:ring focus:ring-pink-200 focus:ring-opacity-50 transition duration-150 ease-in-out" 
                        type="password" 
                        name="password" 
                        required 
                        autocomplete="new-password" 
                    />
                    <x-input-error :messages="$errors->get('password')" class="text-sm text-red-600" />
                </div>

                <!-- Confirm Password -->
                <div class="space-y-2">
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-sm font-medium text-gray-700" />
                    <x-text-input 
                        id="password_confirmation" 
                        class="w-full px-4 py-3 rounded-md border border-gray-300 focus:border-purple-500 focus:ring focus:ring-pink-200 focus:ring-opacity-50 transition duration-150 ease-in-out"
                        type="password"
                        name="password_confirmation" 
                        required 
                        autocomplete="new-password" 
                    />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="text-sm text-red-600" />
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full font-medium py-3 px-4 rounded-md transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 text-white bg-gradient-to-r from-purple-600 to-pink-500 hover:from-purple-700 hover:to-pink-600 shadow-md">
                        {{ __('Reset Password') }}
                    </button>
                </div>
            </form>
        </div>
        
        <!-- Decorative gradient elements -->
        <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-purple-600 to-pink-500 opacity-10 rounded-full transform translate-x-10 -translate-y-10"></div>
        <div class="absolute bottom-0 left-0 w-16 h-16 bg-gradient-to-tr from-pink-500 to-purple-600 opacity-10 rounded-full transform -translate-x-8 translate-y-8"></div>
    </div>
    
    <!-- Additional spacing at bottom -->
    <div class="h-12"></div>
</x-guest-layout>