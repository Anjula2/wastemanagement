<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        @vite('resources/css/app.css')
        <title>Checkout - KMC Waste Management</title>
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        
    </head>
    <body class="bg-gray-100">
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
            <li><a href="/" class="hover:text-yellow-500">Home</a></li>
            <li><a href="/schedule" class="hover:text-yellow-500">Schedules</a></li>
            <li><a href="/complaints/create" class="hover:text-yellow-500">Complaints</a></li>
            <li><a href="/products" class="hover:text-yellow-500">Products</a></li>
            <li><a href="/recycling-tips" class="hover:text-yellow-500">Recycling Tips</a></li>
        </ul>

        <!-- User Actions -->
        <div id="userActions" class="hidden md:flex space-x-4">
                <a href="{{url('/cart')}}" class="flex items-center text-white hover:text-yellow-500 transition duration-300 ease-in-out">
                    <i class="fas fa-shopping-cart"></i> <!-- Cart Icon -->
                    <span class="ml-2">Cart [{{$cartCount}}]</span>
                </a>
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
            <li><a href="/" class="block hover:text-yellow-500">Home</a></li>
            <li><a href="/schedule" class="block hover:text-yellow-500">Schedules</a></li>
            <li><a href="/complaints/create" class="block hover:text-yellow-500">Complaints</a></li>
            <li><a href="/products" class="block hover:text-yellow-500">Products</a></li>
            <li><a href="/recycling-tips" class="block hover:text-yellow-500">Recycling Tips</a></li>
            <li><a href="{{url('/cart')}}" class="flex items-center text-white hover:text-yellow-500 transition duration-300 ease-in-out">
                <i class="fas fa-shopping-cart"></i> <!-- Cart Icon -->
                <span class="ml-2">Cart[{{$cartCount}}]</span>
                </a></li>
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

      <!-- Back to Cart Button -->
      <div class="mt-8 ml-4 mb-2">
            <a href="/cart" class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400 transition">Back to Cart</a>
        </div>

        <!-- Orders Page Content -->
        <div class="container mx-auto p-8">
            <h1 class="text-2xl font-bold mb-6 text-gray-800 text-center">Your Orders</h1>

            @if($orders->isEmpty())
                <p class="text-center text-gray-600">You have no orders yet.</p>
            @else
                @foreach ($orders as $order)
                    <div class="bg-white shadow-lg rounded-lg overflow-hidden mb-6 transition hover:shadow-xl border-t-4" 
                         style="border-color: 
                            @if($order->status === 'pending') 
                                #d97706; /* yellow-600 */
                            @elseif($order->status === 'completed') 
                                #16a34a; /* green-600 */
                            @else 
                                #dc2626; /* red-600 */
                            @endif">
                        <div class="p-6">
                            <!-- Order Header -->
                            <div class="flex items-center justify-between mb-4">
                                <h2 class="text-lg font-semibold text-gray-800">Order No: {{ $order->id }}</h2>
                                <span class="font-bold text-sm px-3 py-1 rounded-full text-white" 
                                    style="background-color: 
                                        @if($order->status === 'pending') 
                                            #d97706; /* yellow-600 */
                                        @elseif($order->status === 'completed') 
                                            #16a34a; /* green-600 */
                                        @else 
                                            #dc2626; /* red-600 */
                                        @endif">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </div>

                            <!-- Order Details -->
                            <div class="space-y-4">
                                <div class="flex items-center">
                                    <i class="fas fa-user text-green-500 mr-2"></i>
                                    <span class="font-semibold text-gray-600">Customer Name:</span>
                                    <p class="ml-2 text-gray-800">{{ $order->name }}</p>
                                </div>

                                <div class="flex items-center">
                                    <i class="fas fa-shipping-fast text-blue-500 mr-2"></i>
                                    <span class="font-semibold text-gray-600">Delivery Option:</span>
                                    <p class="ml-2 text-gray-800">{{ $order->delivery_option }}</p>
                                </div>

                                @if($order->delivery_option === 'delivery')
                                    <div class="flex items-center">
                                        <i class="fas fa-map-marker-alt text-red-500 mr-2"></i>
                                        <span class="font-semibold text-gray-600">Delivery Address:</span>
                                        <p class="ml-2 text-gray-800">{{ $order->address }}</p>
                                    </div>
                                @endif

                                <div class="flex items-center">
                                    <i class="fas fa-wallet text-yellow-500 mr-2"></i>
                                    <span class="font-semibold text-gray-600">Total Amount:</span>
                                    <p class="ml-2 text-xl font-bold text-green-600">Rs {{ number_format($order->total, 2) }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Order Footer -->
                        <div class="bg-gray-100 p-4">
                            <span class="font-semibold text-gray-600">Order Status:</span>
                            <p class="text-lg font-semibold" 
                               style="color: 
                                   @if($order->status === 'pending') 
                                       #d97706; /* yellow-600 */
                                   @elseif($order->status === 'completed') 
                                       #16a34a; /* green-600 */
                                   @else 
                                       #dc2626; /* red-600 */
                                   @endif">
                                {{ ucfirst($order->status) }}
                            </p>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

        <!-- Footer -->
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
            event.preventDefault(); 

            const form = document.createElement("form");
            form.method = "POST";
            form.action = "{{ route('logout') }}";

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