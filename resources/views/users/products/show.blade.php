<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>{{ $product->name }} - KMC Waste Management</title>
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    </head>
    <body class="bg-gray-100">
        <!-- Navbar -->
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
            <a href="/products" class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400 transition">Back to Products</a>
        </div>

        <!-- Product Detail Section -->
        <div class="container mx-auto py-8">
            <div class="bg-white shadow-md rounded-lg p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Product Image -->
                    <div>
                        <img src="{{ Storage::url($product->image_path) }}" alt="{{ $product->name }}" class="rounded-lg w-full h-auto">
                    </div>

                    <!-- Product Information -->
                    <div>
                        <h1 class="text-3xl font-bold text-green-600">{{ $product->name }}</h1>
                        <p class="text-gray-700 mt-4">{{ $product->description }}</p>
                        <p class="text-2xl text-green-600 font-bold mt-4">Rs {{ number_format($product->price, 2) }}</p>

                        <!-- Add to Cart Button -->
                        <form action="{{ route('users.cart.add', $product->id) }}" method="POST" class="mt-6">
                            @csrf
                            <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700 transition">
                                Add to Cart
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Reviews Section -->
            <div class="bg-white shadow-md rounded-lg p-6 mt-8">
                <h2 class="text-2xl font-bold text-green-600">Customer Reviews</h2>

                <!-- Average Star Rating -->
                <div class="flex items-center mt-4">
                    <div class="flex text-yellow-500">
                        @for ($i = 1; $i <= 5; $i++)
                            <svg xmlns="http://www.w3.org/2000/svg" fill="{{ $i <= $averageRating ? 'currentColor' : 'none' }}" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                            </svg>
                        @endfor
                    </div>
                    <span class="ml-2 text-gray-600">{{ $averageRating }}/5</span>
                </div>

                <!-- Review List -->
                <div class="mt-4 space-y-4">
                    @foreach ($reviews as $review)
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <div class="flex items-center justify-between">
                                <span class="text-green-600 font-bold">{{ $review->user->name }} 
                                    @if ($review->updated_at > $review->created_at)
                                        <span class="text-sm text-gray-500">(edited)</span>
                                    @endif
                                </span>
                                <div class="flex text-yellow-500">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="{{ $i <= $review->stars ? 'currentColor' : 'none' }}" stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                                        </svg>
                                    @endfor
                                </div>
                            </div>
                            <p class="text-gray-600 mt-2">{{ $review->review }}</p>

                            <!-- Edit/Delete Buttons for Own Review -->
                            @if (auth()->check() && $review->user_id === auth()->id())
                                <div class="flex space-x-2 mt-2">
                                    <a href="{{ route('users.reviews.edit', $review->id) }}" class="text-blue-600 hover:underline">Edit</a>
                                    <form action="{{ route('reviews.destroy', $review->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 font-bold">Delete</button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>

                <!-- Add Review Form -->
                @auth
                    <form action="{{ route('reviews.store', $product->id) }}" method="POST" class="mt-6">
                        @csrf
                        <div class="flex items-center space-x-2">
                            <label class="text-gray-700">Rate:</label>
                            <!-- Star Rating -->
                            <div class="flex space-x-1" id="star-rating">
                                @for ($i = 1; $i <= 5; $i++)
                                    <svg 
                                        class="w-8 h-8 text-gray-400 hover:text-yellow-500 cursor-pointer"
                                        data-value="{{ $i }}"
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none" 
                                        viewBox="0 0 24 24" 
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                            d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                                    </svg>
                                @endfor
                            </div>
                            <input type="hidden" name="stars" id="rating-value">
                        </div>
                        <textarea name="review" class="mt-4 border border-gray-300 rounded w-full p-2" rows="3" placeholder="Leave a review (optional)...">{{ old('comment') }}</textarea>
                        <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded mt-4">Submit Review</button>
                    </form>
                @else
                    <p class="mt-4 text-gray-600">Please <a href="{{ route('login') }}" class="text-green-600 font-bold">log in</a> to leave a review.</p>
                @endauth
            </div>
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
            
            document.addEventListener('DOMContentLoaded', () => {
                const stars = document.querySelectorAll('#star-rating svg');
                const ratingValue = document.getElementById('rating-value');

                stars.forEach((star, index) => {
                    star.addEventListener('click', () => {
                        // Set the selected rating value
                        ratingValue.value = star.getAttribute('data-value');

                        // Highlight the selected stars
                        stars.forEach((s, i) => {
                            if (i <= index) {
                                s.classList.add('text-yellow-500');
                                s.classList.remove('text-gray-400');
                            } else {
                                s.classList.add('text-gray-400');
                                s.classList.remove('text-yellow-500');
                            }
                        });
                    });
                });
            });
        </script>
    </body>
</html>
