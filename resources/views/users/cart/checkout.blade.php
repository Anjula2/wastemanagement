<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Checkout - KMC Waste Management</title>
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        
    </head>
    <body class="bg-gray-100">
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
                <div class="flex items-center space-x-4">
                     <a href="{{url('/cart')}}" class="flex items-center text-white hover:text-yellow-500 transition duration-300 ease-in-out">
                         <i class="fas fa-shopping-cart"></i> <!-- Cart Icon -->
                            <span class="ml-2">Cart</span>
                            </a>

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
                                    <a href="{{ route('profile.show') }}" class="block w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100">
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
            </div>
        </nav>

        <!-- Back to Products Button -->
        <div class="mt-8 ">
            <a href="/cart" class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400 transition">Back to Cart</a>
        </div>

        <div class="container mx-auto p-8">
            <h1 class="text-2xl font-bold mb-4">Checkout</h1>

            <!-- Display Cart Summary -->
            <div class="bg-white shadow-md rounded-lg p-4 mb-4">
                <h2 class="text-lg font-semibold mb-2">Order Summary</h2>
                @foreach($cartItems as $item)
                    <div class="flex justify-between mb-2">
                        <p>{{ $item->product->name }} x {{ $item->quantity }}</p>
                        <p>Rs {{ number_format($item->product->price * $item->quantity, 2) }}</p>
                    </div>
                @endforeach

                <div class="flex justify-between mt-4">
                    <p class="font-bold">Total:</p>
                    <p>Rs {{ number_format($cartItems->sum(fn($item) => $item->product->price * $item->quantity), 2) }}</p>
                </div>
            </div>

            <!-- Checkout Form -->
            <form action="{{ route('users.cart.confirmOrder') }}" method="POST" class="bg-white shadow-md rounded-lg p-4">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2" for="name">Name</label>
                    <input type="text" id="name" name="name" class="w-full border rounded p-2" required>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Delivery Option</label>
                    <div>
                        <input type="radio" id="pickup" name="delivery_option" value="pickup" checked onclick="toggleAddress(false)">
                        <label for="pickup" class="mr-4">Pickup</label>
                        <input type="radio" id="delivery" name="delivery_option" value="delivery" onclick="toggleAddress(true)">
                        <label for="delivery">Delivery (Add Rs 300)</label>
                    </div>
                </div>

                <div id="addressField" class="mb-4 hidden">
                    <label class="block text-gray-700 font-bold mb-2" for="address">Address</label>
                    <input type="text" id="address" name="address" class="w-full border rounded p-2">
                    <small class="text-gray-500">City: Kandy</small>
                </div>

                <!-- Display Totals -->
                <div class="flex justify-between mt-4">
                    <p class="font-semibold">Total:</p>
                    <p>Rs {{ number_format($cartItems->sum(fn($item) => $item->product->price * $item->quantity), 2) }}</p>
                </div>

                <div id="deliveryCostContainer" class="flex justify-between mt-2">
                    <p class="font-semibold">Delivery Cost:</p>
                    <p id="deliveryCost">Rs 300.00</p>
                </div>

                <div class="flex justify-between mt-4">
                    <p class="font-bold text-xl">Grand Total:</p>
                    <p id="grandTotal" class="font-bold text-xl">
                        Rs {{ number_format($cartItems->sum(fn($item) => $item->product->price * $item->quantity), 2) }}
                    </p>
                </div>
            
                <button type="submit" class="w-full bg-green-600 text-white py-3 rounded-lg font-bold">Confirm Order</button>
            </form>
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

            function toggleAddress(show) {
                const addressField = document.getElementById('addressField');
                const deliveryCostContainer = document.getElementById('deliveryCostContainer');
                const grandTotalElement = document.getElementById('grandTotal');
                let total = parseFloat('{{ $cartItems->sum(fn($item) => $item->product->price * $item->quantity) }}');
            
                if (show) {
                    addressField.classList.remove('hidden');
                    deliveryCostContainer.classList.remove('hidden');
                    grandTotalElement.textContent = 'Rs ' + (total + 300).toFixed(2);
                } else {
                    addressField.classList.add('hidden');
                    deliveryCostContainer.classList.add('hidden');
                    grandTotalElement.textContent = 'Rs ' + total.toFixed(2);
                }
            }
        </script>
    </body>
</html>
