<x-guest-layout>
    <style>
        :root {
            --primary-purple: #8A2BE2;
            --secondary-pink: #FF69B4;
            --gradient-bg: linear-gradient(135deg, var(--primary-purple) 0%, var(--secondary-pink) 100%);
            --light-purple: #F5F0FF;
        }
        
        .gendersphere-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .gendersphere-title {
            font-size: 1.875rem;
            font-weight: 700;
            background: var(--gradient-bg);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        
        .gendersphere-subtitle {
            color: #666;
            margin-top: 0.5rem;
        }
        
        .form-container {
    position: relative;
    border-radius: 0.75rem;
    overflow: hidden;
    box-shadow: 0 4px 12px rgba(138, 43, 226, 0.15);
    background-color: white;
    padding: 2rem;
    border: 1px solid rgba(138, 43, 226, 0.1);
    /* Add gradient line to the left side */
    border-left: 6px solid transparent;
    background-image: linear-gradient(white, white), var(--gradient-bg);
    background-origin: border-box;
    background-clip: padding-box, border-box;
}
        
        .header-decoration {
            height: 4px;
            background: var(--gradient-bg);
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
        }
        
        .background-pattern {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: 
                radial-gradient(circle at 25% 25%, rgba(138, 43, 226, 0.05) 0%, transparent 50%),
                radial-gradient(circle at 75% 75%, rgba(255, 105, 180, 0.05) 0%, transparent 50%);
            z-index: -1;
        }
        
        .input-label {
            color: #555;
            font-weight: 600;
        }
        
        .text-input {
            border-color: #E6D5F5 !important;
            border-radius: 0.5rem !important;
            transition: all 0.3s ease;
            background-color: var(--light-purple);
        }
        
        .text-input:focus {
            border-color: var(--primary-purple) !important;
            box-shadow: 0 0 0 3px rgba(138, 43, 226, 0.2) !important;
            background-color: white;
        }
        
        .primary-btn {
            background: var(--gradient-bg) !important;
            border: none !important;
            transition: all 0.3s ease;
        }
        
        .primary-btn:hover {
            box-shadow: 0 4px 10px rgba(138, 43, 226, 0.3);
            transform: translateY(-1px);
        }
        
        .login-link {
            color: var(--primary-purple) !important;
            transition: color 0.2s ease;
        }
        
        .login-link:hover {
            color: var(--secondary-pink) !important;
        }
        
        /* Form background with subtle pattern and positioning */
        .page-wrapper {
            background-color: transparent;
            background-position: 0 0, 0 10px, 10px -10px, -10px 0px;
            min-height: 100vh;
            display: flex;
            align-items: flex-start;
            justify-content: center;
            padding-top: 8rem; /* Extra space at the top to account for header */
            padding-bottom: 2rem;
            padding-left: 2rem;
            padding-right: 2rem;
        }
    </style>

    <div class="page-wrapper">
        <div class="form-container">
            <div class="header-decoration"></div>
            <div class="background-pattern"></div>
            
            <div class="gendersphere-header">
                <h1 class="gendersphere-title">GenderSphere</h1>
                <p class="gendersphere-subtitle">Create your account</p>
            </div>
            
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name -->
                <div>
                    <x-input-label for="name" :value="__('Name')" class="input-label" />
                    <x-text-input id="name" class="block mt-1 w-full text-input" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Enter your name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Email Address -->
                <div class="mt-4">
                    <x-input-label for="email" :value="__('Email')" class="input-label" />
                    <x-text-input id="email" class="block mt-1 w-full text-input" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="Enter your Email Address" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Password')" class="input-label" />

                    <x-text-input id="password" class="block mt-1 w-full text-input"
                                    type="password"
                                    name="password"
                                    required autocomplete="new-password" 
                                    placeholder="••••••••" />

                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div class="mt-4">
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="input-label" />

                    <x-text-input id="password_confirmation" class="block mt-1 w-full text-input"
                                    type="password"
                                    name="password_confirmation" required autocomplete="new-password" 
                                    placeholder="••••••••" />

                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end mt-6">
                    <a class="underline text-sm rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 login-link" href="{{ route('login') }}">
                        {{ __('Already registered?') }}
                    </a>

                    <x-primary-button class="ms-4 primary-btn">
                        {{ __('Register') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>