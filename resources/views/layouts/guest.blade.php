<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            .hero-section {
                position: relative;
                min-height: 100vh;
                overflow: hidden;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            
            .background {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                display: grid;
                grid-template-columns: repeat(6, 1fr);
                grid-template-rows: repeat(6, 1fr);
                z-index: -1;
            }
            
            .background div {
                width: 100%;
                height: 100%;
                background-size: cover;
                background-position: center;
                transition: opacity 1s ease-in-out;
            }
            
            .logo-container img {
                max-height: 10vh;
                width: auto;
                object-fit: contain;
            }
            
            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(20px); }
                to { opacity: 1; transform: translateY(0); }
            }
            
            .animate-fadeIn {
                animation: fadeIn 1s ease-out;
            }
        </style>
    </head>
    <body class="font-sans text-gray-900 antialiased relative">

        <!-- Background Section (Image Transition Enabled) -->
        <div class="background"></div>
        <div class="absolute inset-0 bg-purple-700 opacity-30"></div>

        <!-- Header Section -->
        <header class="bg-white shadow-md fixed w-full z-50 transition-all py-5 px-10">
            <div class="container mx-auto flex justify-between items-center">
                <div class="flex items-center gap-4 logo-container">
                    <img src="{{ asset('images/logo/denr-logo.svg') }}" alt="Logo 1" class="h-16" loading="lazy">
                    <img src="{{ asset('images/logo/logo2.png') }}" alt="Logo 2" class="h-16" loading="lazy">
                    <img src="{{ asset('images/logo/logo3.png') }}" alt="Logo 3" class="h-16" loading="lazy">
                </div>
                <a href="{{ route('welcome') }}" class="bg-purple-700 text-white py-2 px-6 rounded-full hover:bg-purple-800 transition font-semibold text-sm">
                    Home

                </a>
                <button @click="toggleMobileMenu" class="lg:hidden text-2xl text-gray-700">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
        </header>

        <!-- Content Section -->
        <div class="hero-section">
            <div class="w-full sm:max-w-md px-6 py-4 bg-transparent shadow-md overflow-hidden sm:rounded-lg animate-fadeIn">
                {{ $slot }}
            </div>
        </div>

        <!-- Scripts for Image Transition -->
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                const totalImages = 45;
                const backgroundContainer = document.querySelector(".background");
                const numTiles = 36;
                
                for (let i = 0; i < numTiles; i++) {
                    let tile = document.createElement("div");
                    let imageIndex = (i % totalImages) + 1;
                    tile.style.backgroundImage = `url('/images/image/image${imageIndex}.jpg')`;
                    tile.style.backgroundSize = "cover";
                    tile.style.backgroundPosition = "center";
                    tile.style.opacity = "1";
                    backgroundContainer.appendChild(tile);
                }

                const tiles = document.querySelectorAll(".background div");

                function transitionImages() {
                    let randomTile = tiles[Math.floor(Math.random() * tiles.length)];
                    let newImageIndex = Math.floor(Math.random() * totalImages) + 1;
                    randomTile.style.opacity = "0";
                    setTimeout(() => {
                        randomTile.style.backgroundImage = `url('/images/image/image${newImageIndex}.jpg')`;
                        randomTile.style.opacity = "1";
                    }, 700);
                }

                setInterval(transitionImages, 2000);
            });
        </script>

    </body>
</html>