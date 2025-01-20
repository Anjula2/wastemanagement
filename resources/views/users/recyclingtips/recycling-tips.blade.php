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
<body class="bg-gradient-to-r from-green-200 via-white to-blue-200">

<div id="page-loader" class="fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center z-50">
        <div class="space-y-4 text-center">
            <div class="animate-spin rounded-full h-16 w-16 border-t-4 border-b-4 border-white"></div>
            <p class="text-white text-lg font-semibold">Loading...</p>
        </div>
    </div>

    <nav class="bg-green-600 p-4 z-10 relative">
    <div class="container mx-auto flex items-center justify-between">
        <!-- Logo -->
        <div class="flex items-center space-x-2">
            <a href="/" class="bg-cover bg-center w-12 h-12" style="background-image: url('/images/KMC_logo.png');" aria-label="Logo"></a>
            <a href="/" class="text-white text-lg font-bold">KMC Waste Management</a>
        </div>

        <!-- Hamburger Icon -->
        <div class="md:hidden">
            <button id="hamburgerButton" class="text-white focus:outline-none focus:ring-2 focus:ring-white">
                <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                </svg>
            </button>
        </div>

        <!-- Desktop Menu -->
        <ul id="desktopMenu" class="hidden md:flex space-x-4 text-white font-bold">
            <li><a href="/complaints" class="hover:text-yellow-500">Complaint History</a></li>
            <li><a href="/" class="hover:text-yellow-500">Home</a></li>
            <li><a href="/schedule" class="hover:text-yellow-500">Schedules</a></li>
            <li><a href="/complaints/create" class="hover:text-yellow-500">Complaints</a></li>
            <li><a href="/products" class="hover:text-yellow-500">Products</a></li>
            <li><a href="/recycling-tips" class="hover:text-yellow-500">Recycling Tips</a></li>
        </ul>

        <!-- User Actions -->
        <div id="userActions" class="hidden md:flex space-x-4">
            @if (Auth::check())
            <div class="relative inline-block text-left">
                <button class="inline-flex justify-center items-center text-white font-bold hover:text-yellow-500" id="dropdownButton" aria-haspopup="true" aria-expanded="false">
                    {{ Auth::user()->name }}
                    <svg class="ml-1 h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M5.23 7.21a.75.75 0 011.06 0L10 10.92l3.71-3.71a.75.75 0 111.06 1.06l-4 4a.75.75 0 01-1.06 0l-4-4a.75.75 0 010-1.06z" />
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

    <!-- Mobile Menu -->
    <div id="mobileMenu" class="hidden bg-green-700 text-white md:hidden">
        <ul class="space-y-2 p-4">
            <li><a href="/complaints" class="block hover:text-yellow-500">Complaint History</a></li>
            <li><a href="/" class="block hover:text-yellow-500">Home</a></li>
            <li><a href="/schedule" class="block hover:text-yellow-500">Schedules</a></li>
            <li><a href="/complaints/create" class="block hover:text-yellow-500">Complaints</a></li>
            <li><a href="/products" class="block hover:text-yellow-500">Products</a></li>
            <li><a href="/recycling-tips" class="block hover:text-yellow-500">Recycling Tips</a></li>
        </ul>
        <div class="p-4">
             @if (Auth::check())
               <form method="POST" action="{{ route('logout') }}" class="inline">
             @csrf
               <button type="submit" class="block w-full bg-yellow-500 text-white px-4 py-2 rounded font-bold text-center">Log Out</button>
               </form>
             @else
               <a href="{{ route('login') }}" class="block bg-yellow-500 text-white px-4 py-2 rounded mb-2">Login</a>
               <a href="{{ route('register') }}" class="block bg-white text-green-600 px-4 py-2 rounded">Register</a>
             @endif
        </div>
    </div>
</nav>

    <!-- Recycling Tips Section -->
    <div class="container mx-auto mt-12 px-4 mb-8">
        <h1 class="text-4xl font-extrabold text-center mb-12 text-green-700">Recycling Tips</h1>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Tip 1 -->
            <div class="bg-gradient-to-br from-green-400 via-green-500 to-green-600 text-white p-6 rounded-lg shadow-xl transform hover:scale-105 transition-all duration-300">
                <div class="flex items-center mb-6">
                    <i class="fas fa-trash-alt text-4xl mr-4"></i>
                    <h2 class="text-2xl font-bold">Separate Your Waste</h2>
                </div>
                <ul class="list-disc pl-6 space-y-2 text-lg">
                    <li>Use separate bins for organic waste, recyclables (paper, plastic, glass, metal), and non-recyclables.</li>
                    <li>Label each bin clearly to avoid mixing materials.</li>
                </ul>
            </div>

            <!-- Tip 2 -->
            <div class="bg-gradient-to-br from-blue-400 via-blue-500 to-blue-600 text-white p-6 rounded-lg shadow-xl transform hover:scale-105 transition-all duration-300">
                <div class="flex items-center mb-6">
                    <i class="fas fa-sync-alt text-4xl mr-4"></i>
                    <h2 class="text-2xl font-bold">Clean Before You Recycle</h2>
                </div>
                <ul class="list-disc pl-6 space-y-2 text-lg">
                    <li>Rinse out food and beverage containers before placing them in the recycling bin.</li>
                    <li>Remove labels or stickers when possible to improve processing.</li>
                </ul>
            </div>

            <!-- Tip 3 (Updated Colors) -->
            <div class="bg-gradient-to-br from-pink-600 via-pink-700 to-pink-800 text-white p-6 rounded-lg shadow-xl transform hover:scale-105 transition-all duration-300">
                <div class="flex items-center mb-6">
                    <i class="fas fa-ban text-4xl mr-4"></i>
                    <h2 class="text-2xl font-bold">Avoid Plastic Bags</h2>
                </div>
                <ul class="list-disc pl-6 space-y-2 text-lg">
                    <li>Do not place recyclables in plastic bags; they are often not processed by recycling facilities.</li>
                    <li>Use reusable bags to collect recyclables.</li>
                </ul>
            </div>

            <!-- Tip 4 -->
            <div class="bg-gradient-to-br from-yellow-400 via-yellow-500 to-yellow-600 text-white p-6 rounded-lg shadow-xl transform hover:scale-105 transition-all duration-300">
                <div class="flex items-center mb-6">
                    <i class="fas fa-recycle text-4xl mr-4"></i>
                    <h2 class="text-2xl font-bold">Know What Can Be Recycled</h2>
                </div>
                <ul class="list-disc pl-6 space-y-2 text-lg">
                    <li>Paper: Newspapers, magazines, cardboard, office paper.</li>
                    <li>Plastics: Bottles, containers, and packaging with recycling symbols.</li>
                    <li>Glass: Bottles and jars (clean and unbroken).</li>
                    <li>Metal: Aluminum cans, tin cans, and foil.</li>
                </ul>
            </div>

            <!-- Tip 5 -->
            <div class="bg-gradient-to-br from-red-400 via-red-500 to-red-600 text-white p-6 rounded-lg shadow-xl transform hover:scale-105 transition-all duration-300">
                <div class="flex items-center mb-6">
                    <i class="fas fa-exclamation-triangle text-4xl mr-4"></i>
                    <h2 class="text-2xl font-bold">Reduce Contamination</h2>
                </div>
                <ul class="list-disc pl-6 space-y-2 text-lg">
                    <li>Do not include hazardous materials like batteries, e-waste, or medical waste in regular recycling.</li>
                    <li>Check for special drop-off points for these items.</li>
                </ul>
            </div>

            <!-- Tip 6 (Updated Colors) -->
            <div class="bg-gradient-to-br from-purple-600 via-purple-700 to-purple-800 text-white p-6 rounded-lg shadow-xl transform hover:scale-105 transition-all duration-300">
                <div class="flex items-center mb-6">
                    <i class="fas fa-leaf text-4xl mr-4"></i>
                    <h2 class="text-2xl font-bold">Compost Organic Waste</h2>
                </div>
                <ul class="list-disc pl-6 space-y-2 text-lg">
                    <li>Turn food scraps and garden waste into compost for your garden.</li>
                    <li>Composting helps reduce organic waste sent to landfills.</li>
                </ul>
            </div>

            <!-- Tip 7 -->
            <div class="bg-gradient-to-br from-purple-400 via-purple-500 to-purple-600 text-white p-6 rounded-lg shadow-xl transform hover:scale-105 transition-all duration-300">
                <div class="flex items-center mb-6">
                    <i class="fas fa-recycle text-4xl mr-4"></i>
                    <h2 class="text-2xl font-bold">Reuse When Possible</h2>
                </div>
                <ul class="list-disc pl-6 space-y-2 text-lg">
                    <li>Repurpose glass jars, cans, and old clothes.</li>
                    <li>Donate usable items such as clothing, furniture, or electronics instead of throwing them away.</li>
                </ul>
            </div>

            <!-- Tip 8 -->
            <div class="bg-gradient-to-br from-indigo-400 via-indigo-500 to-indigo-600 text-white p-6 rounded-lg shadow-xl transform hover:scale-105 transition-all duration-300">
                <div class="flex items-center mb-6">
                    <i class="fas fa-info-circle text-4xl mr-4"></i>
                    <h2 class="text-2xl font-bold">Stay Informed</h2>
                </div>
                <ul class="list-disc pl-6 space-y-2 text-lg">
                    <li>Follow KMC's waste management updates and recycling guidelines.</li>
                    <li>Attend workshops or community events to learn more about recycling practices.</li>
                </ul>
            </div>

            <!-- Tip 9 (Updated Colors) -->
            <div class="bg-gradient-to-br from-pink-500 via-pink-600 to-pink-700 text-white p-6 rounded-lg shadow-xl transform hover:scale-105 transition-all duration-300">
                <div class="flex items-center mb-6">
                    <i class="fas fa-water text-4xl mr-4"></i>
                    <h2 class="text-2xl font-bold">Reduce Single-Use Plastics</h2>
                </div>
                <ul class="list-disc pl-6 space-y-2 text-lg">
                    <li>Use reusable shopping bags, water bottles, and utensils to minimize single-use plastic waste.</li>
                </ul>
            </div>
        </div>
    </div>

    <footer class="bg-green-600 py-4">
            <div class="container mx-auto text-center text-white">
                <p>&copy; 2024 KMC Waste Management. All rights reserved.</p>
            </div>
    </footer>

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

    <!--Hamburger Menu-->
    <script>
            document.addEventListener("DOMContentLoaded", function () {
            const hamburgerButton = document.getElementById("hamburgerButton");
            const mobileMenu = document.getElementById("mobileMenu");

        hamburgerButton.addEventListener("click", () => {
            mobileMenu.classList.toggle("hidden");
        });
    });
    document.addEventListener("DOMContentLoaded", function () {
    const logoutLink = document.querySelector('#mobileMenu a[href="{{ route('logout') }}"]');

    if (logoutLink) {
        logoutLink.addEventListener("click", function (event) {
            event.preventDefault(); // Prevent the default link behavior

            // Create a form and submit it programmatically
            const form = document.createElement("form");
            form.method = "POST";
            form.action = "{{ route('logout') }}";

            // Add CSRF token input
            const csrfToken = document.createElement("input");
            csrfToken.type = "hidden";
            csrfToken.name = "_token";
            csrfToken.value = "{{ csrf_token() }}";

            form.appendChild(csrfToken);
            document.body.appendChild(form);
            form.submit();
        });
    }
});
</script>
    
</body>
</html>
