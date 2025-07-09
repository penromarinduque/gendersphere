
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GenderSphere</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
<body class="bg-gray-100 text-gray-900 overflow-x-hidden relative">
    
    <div id="backgroundContainer" class="fixed top-0 left-0 w-full h-full -z-10"></div>

    <header class="bg-white shadow-md fixed w-full z-50 transition-all py-5 px-8">
        <div class="container mx-auto flex justify-between items-center">
            <div class="flex items-center gap-6 logo-container">
                <img src="{{ asset('images/logo/denr-logo.svg') }}" alt="Logo 1" loading="lazy">
                <img src="{{ asset('images/logo/logo2.png') }}" alt="Logo 2" loading="lazy">
                <img src="{{ asset('images/logo/logo3.png') }}" alt="Logo 3" loading="lazy">
            </div>
            <a href="{{ route('login') }}" class="bg-purple-700 text-white py-3 px-8 rounded-full hover:bg-purple-800 transition font-semibold">
                Login
            </a>
            <button @click="toggleMobileMenu" class="lg:hidden text-2xl text-gray-700">
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </header>

    <!-- Modernized Hero Section -->
    <section class="hero-section">
        <div class="background"></div>
        <div class="absolute inset-0 bg-purple-700 opacity-30"></div>
        <div class="relative bg-white p-10 rounded-2xl shadow-2xl text-center max-w-3xl mx-auto mt-20 backdrop-blur-md bg-opacity-90 animate-fadeIn">
            <img src="{{ asset('images/logo/logo3.png') }}" alt="GenderSphere Logo" class="mx-auto w-40 md:w-48 mb-6 drop-shadow-lg" loading="lazy">
            <h1 class="text-4xl md:text-5xl font-extrabold text-purple-700 mb-4 tracking-tight">
                Welcome to <span class="text-pink-500">GenderSphere</span>
            </h1>
            <p class="mt-4 text-lg text-gray-700 leading-relaxed font-medium">
                <span class="text-purple-600 font-semibold">GenderSphere</span> is a web-based system designed to provide a 
                <span class="text-purple-700 font-bold">comprehensive</span> and 
                <span class="text-purple-700 font-bold">inclusive</span> view of gender-related data and insights. 
                It serves as a centralized database containing gender statistics and sex-disaggregated data that are 
                systematically gathered, regularly updated, and analyzed for gender-based planning, programming, and policy formulation.
            </p>
        </div>
    </section>

    <!-- Video Section -->
<div class="flex justify-center items-center min-h-screen p-6 bg-purple-300 text-gray-900"> 
    <div class="w-full max-w-5xl text-center">
        <h2 class="text-gray-800 text-4xl font-semibold mb-6">Watch Our Introduction</h2>
        <div class="relative w-full pb-[56.25%] bg-gray-200 rounded-lg shadow-lg"> 
            <iframe 
                class="absolute top-0 left-0 w-full h-full rounded-lg"
                src="https://www.youtube.com/embed/KpJ18JR0Vd8" 
                title="GenderSphere Introduction" 
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                allowfullscreen>
            </iframe>
        </div>
    </div>
</div>

<!-- Footer -->
<footer class="bg-white text-gray-900 py-10 mt-10 shadow-lg">
    <div class="container mx-auto grid md:grid-cols-4 gap-10 px-6">
        <div>
            <h3 class="text-xl font-bold mb-4">GenderSphere</h3>
            <p class="text-gray-600">A safe and inclusive space for all gender identities.</p>
            <div class="flex space-x-4 mt-4">
                <a href="#" class="text-gray-600 text-xl hover:text-purple-700"><i class="fab fa-facebook"></i></a>
                <a href="#" class="text-gray-600 text-xl hover:text-purple-700"><i class="fab fa-twitter"></i></a>
                <a href="#" class="text-gray-600 text-xl hover:text-purple-700"><i class="fab fa-instagram"></i></a>
                <a href="#" class="text-gray-600 text-xl hover:text-purple-700"><i class="fab fa-linkedin"></i></a>
            </div>
        </div>
    </div>
</footer>


    
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