<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Waste Orders</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<body class="bg-gray-100" style="background-image: url('/images/main-image.jpg'); 
             background-size: cover; 
             background-position: center; 
             background-repeat: no-repeat; 
             background-attachment: fixed;">
    <nav class="bg-gradient-to-r from-green-700 to-blue-600 p-4 shadow-lg fixed top-0 left-0 w-full z-50">
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
                <a href="{{url('/companycart')}}" class="flex items-center text-white hover:text-yellow-500 transition duration-300 ease-in-out">
                    <i class="fas fa-shopping-cart"></i>
                    <span class="ml-2">My Orders <span style="color: red; font-weight: bold;">[{{ $orderCount }}]</span></span>
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
            <li><a href="{{url('/companycart')}}" class="flex items-center text-white hover:text-yellow-500 transition duration-300 ease-in-out">
                    <i class="fas fa-shopping-cart"></i>
                    <span class="ml-2">My Orders <span style="color: red; font-weight: bold;">[{{ $orderCount }}]</span></span>
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

    <div class="mt-8 ml-4 mb-2">
        <a href="/wasteorders" class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400 transition">Back to Cart</a>
    </div>

    <div class="container mx-auto p-8">
        <div class="bg-gray-100 shadow-lg rounded-lg overflow-hidden transition hover:shadow-xl mb-6 border-t-4" 
             style="border-color: #d97706;">
            <div class="p-6">
                <!-- Waste Orders Title -->
                <h1 class="text-2xl font-bold mb-6 text-gray-800 text-center">
                    Your Waste Orders
                </h1>
                
                <!-- No Orders Message -->
                @if($wasteOrders->isEmpty())
                    <p class="text-center text-gray-600">No waste orders found.</p>
                @else
                    @foreach ($wasteOrders as $wasteOrder)
                        <!-- Small Card for Each Waste Order -->
                        <div class="bg-white shadow-md rounded-lg overflow-hidden mb-6 transition hover:shadow-lg border-t-4" 
                             style="border-color: 
                                @if($wasteOrder->status === 'pending') 
                                    #d97706;
                                @elseif($wasteOrder->status === 'completed') 
                                    #16a34a;
                                @else 
                                    #dc2626;
                                @endif">
                            
                            <div class="p-4">
                                <!-- Waste Order Header -->
                                <div class="flex items-center justify-between mb-4">
                                    <h2 class="text-lg font-semibold text-gray-800">{{ $wasteOrder->company_name }}</h2>
                                    <span class="font-bold text-sm px-3 py-1 rounded-full text-white" 
                                        style="background-color: 
                                            @if($wasteOrder->status === 'pending') 
                                                #d97706;
                                            @elseif($wasteOrder->status === 'completed') 
                                                #16a34a;
                                            @else 
                                                #dc2626;
                                            @endif">
                                        {{ ucfirst($wasteOrder->status) }}
                                    </span>
                                </div>

                                <!-- Waste Order Details -->
                                <div class="space-y-4">
                                    <div class="flex items-center">
                                        <i class="fas fa-map-marker-alt text-red-500 mr-2"></i>
                                        <span class="font-semibold text-gray-600">Address:</span>
                                        <p class="ml-2 text-gray-800">{{ $wasteOrder->address }}</p>
                                    </div>

                                    <div class="flex items-center">
                                        <i class="fas fa-phone text-blue-500 mr-2"></i>
                                        <span class="font-semibold text-gray-600">Contact:</span>
                                        <p class="ml-2 text-gray-800">{{ $wasteOrder->contact_number }}</p>
                                    </div>

                                    <div class="flex items-center">
                                        <i class="fas fa-recycle text-green-500 mr-2"></i>
                                        <span class="font-semibold text-gray-600">Waste Type:</span>
                                        <p class="ml-2 text-gray-800">{{ $wasteOrder->waste_type }}</p>
                                    </div>

                                    <div class="flex items-center">
                                        <i class="fas fa-balance-scale text-yellow-500 mr-2"></i>
                                        <span class="font-semibold text-gray-600">Quantity:</span>
                                        <p class="ml-2 text-gray-800">{{ $wasteOrder->quantity }} tons</p>
                                    </div>

                                    <div class="flex items-center">
                                        <i class="fas fa-dollar-sign text-yellow-500 mr-2"></i>
                                        <span class="font-semibold text-gray-600">Price Per Ton:</span>
                                        <p class="ml-2 text-gray-800">Rs.{{ $wasteOrder->price_per_ton }}</p>
                                    </div>

                                    <div class="flex items-center">
                                        <i class="fas fa-wallet text-green-500 mr-2"></i>
                                        <span class="font-semibold text-gray-600">Total Price:</span>
                                        <p class="ml-2 text-xl font-bold text-green-600">Rs.{{ $wasteOrder->total_price }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Waste Order Footer -->
                            <div class="bg-gray-100 p-4 flex justify-between items-center">
                                <span class="font-semibold text-gray-600">Completed:</span>
                                <p class="text-lg font-semibold text-gray-800">{{ $wasteOrder->is_completed ? 'Yes' : 'No' }}</p>
                                
                                <!-- Display Cancel Button if Order is Pending -->
                                @if($wasteOrder->status === 'pending')
                                <form action="{{ route('wasteorders.cancel', $wasteOrder->id) }}" method="POST">
                                  @csrf
                                  @method('DELETE') <!-- This tells Laravel to treat the request as a DELETE -->
                                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                                    Cancel Order
                                </button>
                                </form>
                                @endif
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

            <!-- Order More Button -->
            <div class="text-center mb-8">
                <a href="/wasteorders" 
                   class="bg-yellow-600 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded transition">
                    Order More
                </a>
            </div>
        </div>
    </div>

    <footer class="bg-green-600 py-4">
        <div class="container mx-auto text-center text-white">
            <p>&copy; 2024 KMC Waste Management. All rights reserved.</p>
        </div>
    </footer>

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

</body>
</html>