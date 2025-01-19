<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Waste Collection Schedules - KMC Waste Management</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>
<body class="bg-gradient-to-r from-green-200 via-white to-blue-200 min-h-screen flex flex-col font-sans" style="background-image: url('{{ asset('images/main-image2.jpg') }}'); background-size: cover; background-position: center; background-repeat: no-repeat;">
<div id="page-loader" class="fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center z-50">
        <div class="space-y-4 text-center">
            <div class="animate-spin rounded-full h-16 w-16 border-t-4 border-b-4 border-white"></div>
            <p class="text-white text-lg font-semibold">Loading...</p>
    </div>
    </div>
  <div class="fixed inset-0 bg-black bg-opacity-50 min-h-screen z-0"></div>
    <nav class="bg-green-600 p-4 z-10 relative">
        <div class="container mx-auto flex items-center justify-between">
            <div class="flex items-center space-x-2">
                <a href="/" class="bg-cover bg-center w-12 h-12" style="background-image: url('images/KMC_logo.png');" aria-label="Logo"></a>
                <a href="/" class="text-white text-lg font-bold">KMC Waste Management</a>
            </div>
            <ul class="space-x-4 text-white font-bold hidden md:flex">
                <li><a href="/" class="hover:text-yellow-500">Home</a></li>
                <li><a href="#" class="hover:text-yellow-500">Schedules</a></li>
                <li><a href="/complaints/create" class="hover:text-yellow-500">Complaints</a></li>
                <li><a href="/products" class="hover:text-yellow-500">Products</a></li>
                <li><a href="/recycling-tips" class="hover:text-yellow-500">Recycling Tips</a></li>
            </ul>
            <div class="space-x-4">
                @if (Auth::check())
                    <div class="relative inline-block text-left">
                        <button class="inline-flex justify-center items-center text-white font-bold hover:text-yellow-500" id="dropdownButton" aria-haspopup="true" aria-expanded="false">
                            {{ Auth::user()->name }}
                            <svg class="ml-1 h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M5.23 7.21a.75.75 0 011.06 0L10 10.92l3.71-3.71a.75.75 0 111.06 1.06l-4 4a.75.75 0 01-1.06 0l-4-4a.75.75 0 010-1.06z"/>
                            </svg>
                        </button>
                        <div id="dropdownMenu" class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 hidden z-50">
                            <a href="{{route('profile.show')}}" class="block w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100">{{ __('Profile') }}</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100">{{ __('Log Out') }}</button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600 transition font-bold">Login</a>
                    <a href="{{ route('register') }}" class="bg-white text-green-600 px-4 py-2 rounded hover:bg-gray-200 transition font-bold">Register</a>
                @endif
            </div>
        </div>
    </nav>

    <div class="mt-8 ml-4 z-10 relative">
        <a href="/schedule" class="bg-yellow-300 text-gray-700 px-4 py-2 rounded hover:bg-yellow-400 transition">Back to Schedules</a>
    </div>

    <div class="container mx-auto mt-8 z-10 relative">
    <h2 class="text-3xl font-bold text-center text-yellow-500 mb-6">Waste Collection Zones</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-8 mt-8">
        @foreach($zones as $zone)
            <div class="bg-white shadow-lg rounded-lg p-6 hover:scale-105 transition-all duration-300 transform">
                <div class="flex items-center mb-4">
                    <div class="bg-gray-300 p-3 rounded-full shadow-md mr-4">
                        <i class="fas fa-map-marker-alt text-red-600 text-2xl"></i> <!-- Icon for location -->
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800">{{ $zone->zone_name }}</h3>
                </div>
                <div class="border-t border-gray-300 my-4"></div>
                <div class="text-gray-800">
                    <p class="mb-4 text-sm">Areas:</p>
                    <ul class="list-disc pl-5 space-y-2">
                        @foreach(is_array($zone->areas) ? $zone->areas : json_decode($zone->areas) as $area)
                            @if (is_array($area))
                                <li class="text-gray-800 flex items-center"><i class="fas fa-check-circle text-blue-500 mr-2"></i>{{ implode(', ', $area) }}</li> <!-- Check icon for multiple areas -->
                            @else
                                <li class="text-gray-800 flex items-center"><i class="fas fa-check-circle text-blue-500 mr-2"></i>{{ htmlspecialchars($area) }}</li> <!-- Check icon for individual areas -->
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>
        @endforeach
    </div>
</div>




    <footer class="bg-green-600 py-4 mt-auto z-10 relative">
        <div class="container mx-auto text-center text-white">
            <p>&copy; 2024 KMC Waste Management. All rights reserved.</p>
        </div>
    </footer>

    <!--Profile-->
<script>
        document.addEventListener("DOMContentLoaded", function () {
            const dropdownButton = document.getElementById("dropdownButton");
            const dropdownMenu = document.getElementById("dropdownMenu");

            dropdownButton.addEventListener("click", (event) => {
                event.stopPropagation();
                dropdownMenu.classList.toggle("hidden");
            });

            document.addEventListener("click", () => {
                dropdownMenu.classList.add("hidden");
            });
        });
    </script>

    <!-- Loading Screen Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const loader = document.getElementById('page-loader');
            if (loader) {
                const minimumTime = 2000;
                const startTime = Date.now();

                window.addEventListener('load', () => {
                    const elapsedTime = Date.now() - startTime;
                    const delay = Math.max(0, minimumTime - elapsedTime);

                    setTimeout(() => {
                        loader.style.display = 'none';
                    }, delay);
                });
            }
        });
    </script>
</body>
</html>
