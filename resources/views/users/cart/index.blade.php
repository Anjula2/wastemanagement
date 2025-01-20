<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Cart - KMC Waste Management</title>
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
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
                    <span class="ml-2">Cart</span>
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
                <span class="ml-2">Cart</span>
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

        <!-- Back to Products Button -->
        <div class="mt-8 ml-4">
            <a href="/products" class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400 transition">Back to Products</a>
        </div>

        <div class="container mx-auto p-8">
            <h1 class="text-2xl font-bold mb-4">Your Cart</h1>

            @if(session('success'))
                <div class="bg-green-500 text-white p-4 rounded mb-4">
                    {{ session('success') }}
                </div>
            @elseif(session('error'))
                <div class="bg-red-500 text-white p-4 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white shadow-md rounded-lg p-4 mb-6">
            <!-- "View My Orders" button -->
            @if(auth()->check())
                <div class="mb-4 flex justify-between items-center bg-yellow-100 p-4 rounded-lg">
                   <h2 class="text-lg font-semibold text-gray-700">Hello, {{ Auth::user()->name }}!</h2>
                   <a href="{{ url('showorders') }}" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600 transition font-bold">View My Orders [{{ $orderCount }}]</a>
                </div>
            @endif
            </div>

            <div class="bg-white shadow-md rounded-lg p-4">
                <div id="cart-items">
                    @foreach($cartItems as $cartItem)
                        <div class="flex items-center justify-between border-b pb-4 mb-4" data-id="{{ $cartItem->id }}">
                            <img src="{{ Storage::url($cartItem->product->image_path) }}" alt="{{ $cartItem->product->name }}" class="h-24 w-24 object-cover rounded">
                            <div class="flex-1 ml-4">
                                <h2 class="text-lg font-semibold">{{ $cartItem->product->name }}</h2>
                                <p class="text-green-600 font-bold">
                                    Rs {{ number_format($cartItem->product->price, 2) }} x 
                                    <span id="quantity-{{ $cartItem->id }}">{{ $cartItem->quantity }}</span>
                                </p>
                            </div>
                            <div class="flex items-center space-x-2">
                                <button type="button" class="bg-gray-200 px-3 py-1 rounded" onclick="updateQuantity({{ $cartItem->id }}, 'decrease', {{ $cartItem->product->price }})">-</button>
                                <span id="quantity-display-{{ $cartItem->id }}" class="text-lg font-semibold">{{ $cartItem->quantity }}</span>
                                <button type="button" class="bg-gray-200 px-3 py-1 rounded" onclick="updateQuantity({{ $cartItem->id }}, 'increase', {{ $cartItem->product->price }})">+</button>
                            </div>
                            <p class="text-gray-800 font-bold">
                                Rs <span id="total-{{ $cartItem->id }}">{{ number_format($cartItem->product->price * $cartItem->quantity, 2) }}</span>
                            </p>

                            <!-- Container for the price and delete button -->
                            <div class="flex justify-between items-center mt-2">

                            <!-- Delete button -->
                                <button type="button" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500" onclick="deleteCartItem({{ $cartItem->id }})">
                                    Delete
                                </button>
                            </div>

                        </div>
                    @endforeach
                </div>

                <!-- Grand Total -->
                <div class="flex justify-between mt-4">
                    <h2 class="text-xl font-semibold">Total:</h2>
                    <p id="grand-total" class="text-xl font-bold text-green-600">
                        Rs {{ number_format($cartItems->sum(fn($item) => $item->product->price * $item->quantity), 2) }}
                    </p>
                </div>

                <!-- Clear Cart Button -->
                <button type="button" class="mt-6 w-full bg-red-600 text-white py-3 rounded-lg font-bold" onclick="clearCart()">Clear Cart</button>

                <!-- Order Form -->
                <form action="{{ route('users.cart.checkout') }}" method="POST" class="mt-6">
                    @csrf
                    <button type="submit" class="w-full bg-green-600 text-white py-3 rounded-lg font-bold">Go to checkout</button>
                </form>
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

            function updateQuantity(cartItemId, action, price) {
                let quantityElement = document.getElementById(`quantity-display-${cartItemId}`);
                let quantityLabel = document.getElementById(`quantity-${cartItemId}`);
                let totalElement = document.getElementById(`total-${cartItemId}`);
                let currentQuantity = parseInt(quantityElement.textContent);

                if (action === 'decrease' && currentQuantity > 1) {
                    currentQuantity--;
                } else if (action === 'increase') {
                    currentQuantity++;
                }
                
                axios.patch(`/cart-items/${cartItemId}`, {quantity: currentQuantity})
                .then(response => {
                    quantityElement.textContent = currentQuantity;
                    quantityLabel.textContent = currentQuantity;
                    totalElement.textContent = 'Rs. ' + (currentQuantity * price).toFixed(2);
                    updateGrandTotal();
                }).catch(error => {
                    console.error('Error updating cart item:', error);
                    alert('Faild to update quantity. Please try again');
                });
            }

            function updateGrandTotal() {
                let total = 0;
                const cartItems = document.querySelectorAll('#cart-items > div');

                cartItems.forEach(item => {
                    const itemId = item.getAttribute('data-id');
                    const itemTotal = parseFloat(document.getElementById(`total-${itemId}`).textContent.replace('Rs ', '').replace(',', ''));
                    total += itemTotal;
                });

             document.getElementById('grand-total').textContent = 'Rs ' + total.toFixed(2);
            }

            // Function to delete an item from the cart
            function clearCart() {
              if (confirm('Are you sure you want to clear the entire cart?')) {
                  axios.delete('/cart-items')
            .then(response => {
                // Remove all items from the UI
                document.getElementById('cart-items').innerHTML = '';
                updateGrandTotal(); // Update the grand total

                window.location.reload();
            })
            .catch(error => {
                console.error('Error clearing cart:', error);
            });
    }
}


            // Function to clear all items from the cart
            function deleteCartItem(cartItemId) {
               if (confirm('Are you sure you want to delete this item?')) {
                  axios.delete(`/cart-items/${cartItemId}`)
                     .then(response => {
                document.querySelector(`div[data-id='${cartItemId}']`).remove();
                updateGrandTotal();  // Update the grand total
            })
            .catch(error => {
                console.error('Error deleting cart item:', error);
            });
    }
}

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
