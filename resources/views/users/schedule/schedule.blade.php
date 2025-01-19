<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recycling Tips - KMC Waste Management</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>
<body class="bg-gradient-to-r from-green-200 via-white to-blue-200 min-h-screen flex flex-col">

    <div id="page-loader" class="fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center z-50">
        <div class="space-y-4 text-center">
            <div class="animate-spin rounded-full h-16 w-16 border-t-4 border-b-4 border-white"></div>
            <p class="text-white text-lg font-semibold">Loading...</p>
        </div>
    </div>

    <nav class="bg-green-600 p-4">
        <div class="container mx-auto flex items-center justify-between">
            <!-- Logo -->
            <div class="flex items-center space-x-2">
                <a href="/" class="bg-cover bg-center w-12 h-12" style="background-image: url('images/KMC_logo.png');" aria-label="Logo"></a>
                <a href="/" class="text-white text-lg font-bold">KMC Waste Management</a>
            </div>

            <!-- Navigation Links -->
            <ul class="flex space-x-4">
                <li><a href="/" class="text-white font-bold hover:text-yellow-500">Home</a></li>
                <li><a href="#" class="text-white font-bold hover:text-yellow-500">Schedules</a></li>
                <li><a href="/complaints/create" class="text-white font-bold hover:text-yellow-500">Complaints</a></li>
                <li><a href="/products" class="text-white font-bold hover:text-yellow-500">Products</a></li>
                <li><a href="/recycling-tips" class="text-white font-bold hover:text-yellow-500">Recycling Tips</a></li>
            </ul>
            <div class="space-x-4">
                @if (Auth::check())
                    <!-- Display user name and logout button -->
                    <div class="relative inline-block text-left">
                        <button class="inline-flex justify-center items-center text-white font-bold hover:text-yellow-500"
                            id="dropdownButton"
                            aria-haspopup="true"
                            aria-expanded="false">
                            {{ Auth::user()->name }}
                            <svg class="ml-1 h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M5.23 7.21a.75.75 0 011.06 0L10 10.92l3.71-3.71a.75.75 0 111.06 1.06l-4 4a.75.75 0 01-1.06 0l-4-4a.75.75 0 010-1.06z"/>
                            </svg>
                        </button>

                        <!-- Dropdown menu -->
                        <div id="dropdownMenu" class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 hidden z-50">
                            <a href="{{route('profile.show')}}" class="block w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100">
                                {{ __('Profile') }}
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100">
                                    {{ __('Log Out') }}
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <!-- Display login and register buttons for guests -->
                    <a href="{{ route('login') }}" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600 transition font-bold">
                        Login
                    </a>
                    <a href="{{ route('register') }}" class="bg-white text-green-600 px-4 py-2 rounded hover:bg-gray-200 transition font-bold">
                        Register
                    </a>
                @endif
            </div>
        </div>
    </nav>

    <div class="container mx-auto my-8 p-4 flex-grow">
        <h1 class="text-3xl font-bold text-center text-green-700 mb-8">Waste Collection Schedules</h1>

        <!-- Day of the Week Menu -->
        <div class="flex justify-center space-x-4 mb-8">
            @foreach(['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'] as $index => $day)
                <button 
                    class="px-6 py-3 text-white bg-gradient-to-r from-blue-500 to-blue-600 hover:bg-gradient-to-l hover:from-green-500 hover:to-green-400 rounded-full focus:outline-none shadow-lg transform hover:scale-105 transition duration-300 ease-in-out"
                    onclick="filterByDay('{{ $day }}')"
                    aria-label="{{ $day }}"
                >
                    <!-- Optional: Add icons for each day -->
                    <span class="text-lg font-semibold">{{ $day }}</span>
                </button>
            @endforeach
        </div>

        <!-- Schedules List -->
        <div id="schedule-cards" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($schedules as $date => $scheduleGroup)
                <div class="schedule-card" data-date="{{ \Carbon\Carbon::parse($date)->format('Y-m-d') }}">
                    <div class="bg-white rounded-lg shadow-lg p-6 border-t-4 border-green-500 transform hover:scale-105 transition duration-300 ease-in-out">
                        <h2 class="text-2xl font-bold text-green-700 mb-4 flex items-center">
                            <i class="fas fa-calendar-alt mr-2"></i> 
                            {{ $date }}
                        </h2>

                        @foreach($scheduleGroup as $schedule)
                            <div class="mb-3">
                                <div class="flex items-center">
                                    <i class="fas fa-map-marker-alt text-green-500 mr-2"></i>
                                    <p class="text-sm text-gray-600 font-semibold"><strong>Zone:</strong> {{ $schedule->wasteCollectionZone->zone_name ?? 'N/A' }}</p>
                                </div>

                                <div class="flex items-center mt-2">
                                    <i class="fas fa-recycle text-blue-500 mr-2"></i>
                                    <p class="text-sm text-gray-600"><strong>Type:</strong> {{ $schedule->waste_type }}</p>
                                </div>

                                <div class="flex items-center mt-2">
                                    <i class="fas fa-clock text-orange-500 mr-2"></i>
                                    <p class="text-sm text-gray-600"><strong>Time:</strong> {{ \Carbon\Carbon::parse($schedule->start_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($schedule->end_time)->format('h:i A') }}</p>
                                </div>
                            </div>

                            <!-- Attractive Divider -->
                            <div class="relative">
                                <hr class="my-4 border-t-2 border-gradient-to-r from-green-400 via-blue-500 to-orange-500">
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <footer class="bg-green-600 py-4 mt-auto">
        <div class="container mx-auto text-center text-white">
            <p>&copy; 2024 KMC Waste Management. All rights reserved.</p>
        </div>
    </footer>

    <script>
        function filterByDay(day) {
            let scheduleCards = document.querySelectorAll('.schedule-card');
            scheduleCards.forEach(card => {
                let cardDate = card.getAttribute('data-date');
                let cardDay = new Date(cardDate).toLocaleString('en-us', { weekday: 'long' });

                if (cardDay === day) {
                    card.style.display = 'block'; 
                } else {
                    card.style.display = 'none'; 
                }
            });
        }
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
