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
<body class="bg-gradient-to-r from-green-200 via-white to-blue-200 min-h-screen flex flex-col font-sans" style="background-image: url('{{ asset('images/schedule-bg.jpg') }}');
background-size: cover; 
             background-position: center; 
             background-repeat: no-repeat;">
    <div id="page-loader" class="fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center z-50">
        <div class="space-y-4 text-center">
            <div class="animate-spin rounded-full h-16 w-16 border-t-4 border-b-4 border-white"></div>
            <p class="text-white text-lg font-semibold">Loading...</p>
    </div>
    </div>
  <div class="fixed inset-0 bg-black bg-opacity-50 min-h-screen z-0"></div>
  <nav class="bg-green-600 p-4 z-20 relative">
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

    <div class="container mx-auto my-8 p-4 flex-grow relative">
        <h1 class="text-3xl font-bold text-center text-white mb-8 font-serif">Waste Collection Schedules</h1>

        <!-- Zone Filter Dropdown -->
        <div class="flex justify-center mb-8">
    <div class="relative">
        <select id="zone-filter" 
                class="appearance-none px-6 py-3 text-white bg-gradient-to-r from-yellow-600 to-yellow-800 
                       hover:bg-gradient-to-l hover:from-green-600 hover:to-green-400 
                       rounded-xl focus:outline-none shadow-xl transform hover:scale-105 transition-all duration-300 ease-in-out 
                       w-64"
                onchange="filterByZone(this)">
            <option value="" class="text-gray-600">Select Zone</option>
            @foreach($zones as $zone)
                <option value="{{ $zone->zone_name }}" class="text-gray-800">{{ $zone->zone_name }}</option>
            @endforeach
        </select>
        <!-- Custom Arrow Icon -->
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" 
             class="absolute top-0 right-0 h-6 w-6 text-white mt-4 mr-4">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                  d="M19 9l-7 7-7-7"/>
        </svg>
      </div>
    </div>

        <!-- Day of the Week Buttons -->
        <div class="flex justify-center space-x-4 mb-8 flex-wrap">
            @foreach(['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'] as $day)
                <button class="px-6 py-3 text-white bg-gradient-to-r from-blue-500 to-blue-600 hover:bg-gradient-to-l hover:from-green-500 hover:to-green-400 rounded-full focus:outline-none shadow-lg transform hover:scale-105 transition duration-300 ease-in-out mb-4 md:mb-0" onclick="filterByDay('{{ $day }}')" aria-label="{{ $day }}">
                    <span class="text-lg font-semibold">{{ $day }}</span>
                </button>
            @endforeach
        </div>

        <!-- Schedule Cards -->
        <div id="schedule-cards" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($schedules as $day => $scheduleGroup)
                @foreach($scheduleGroup as $schedule)
                    <div class="schedule-card" data-day="{{ $day }}" data-zone="{{ $schedule->wasteCollectionZone->zone_name ?? 'N/A' }}">
                        <div class="bg-white rounded-lg shadow-lg p-6 border-t-4 border-green-500 transform hover:scale-105 transition duration-300 ease-in-out">
                            <h2 class="text-2xl font-bold text-green-700 mb-4 flex items-center">
                                <i class="fas fa-calendar-alt mr-2"></i>
                               {{ \Carbon\Carbon::parse($schedule->date)->format('l') }}
                            </h2>
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
                        </div>
                    </div>
                @endforeach
            @endforeach
        </div>
    </div>

    <div class="absolute top-24 right-8 sm:top-28 sm:right-6 z-10">
    <a href="/zonelist" class="bg-gradient-to-r from-yellow-400 to-yellow-600 hover:bg-gradient-to-l hover:from-green-600 hover:to-green-400 text-white px-4 py-2 rounded-full shadow-xl transform hover:scale-105 transition-all duration-300 ease-in-out text-md font-bold">
        Go to Zone List
    </a>
</div>

    <footer class="bg-green-600 py-4 mt-auto z-10 relative">
        <div class="container mx-auto text-center text-white">
            <p>&copy; 2024 KMC Waste Management. All rights reserved.</p>
        </div>
    </footer>

    <script>
    function getCurrentDay() {
        const daysOfWeek = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        const today = new Date();
        return daysOfWeek[today.getDay()];
    }

    function filterByDay(day) {
        const selectedZone = document.getElementById('zone-filter').value;
        const scheduleCards = document.querySelectorAll('.schedule-card');
        
        scheduleCards.forEach(card => {
            const cardDay = card.getAttribute('data-day');
            const cardZone = card.getAttribute('data-zone');
            
            // Show card if both day and zone match
            if ((cardDay === day || !day) && (cardZone === selectedZone || !selectedZone)) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    }

    function filterByZone(select) {
        const selectedZone = select.value;
        const selectedDay = document.querySelector('.day-button.selected')?.getAttribute('data-day') || getCurrentDay();
        const scheduleCards = document.querySelectorAll('.schedule-card');
        
        scheduleCards.forEach(card => {
            const cardDay = card.getAttribute('data-day');
            const cardZone = card.getAttribute('data-zone');
            
            // Show card if both day and zone match
            if ((cardDay === selectedDay || !selectedDay) && (cardZone === selectedZone || !selectedZone)) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        const today = getCurrentDay();
        filterByDay(today);
    });
</script>

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
