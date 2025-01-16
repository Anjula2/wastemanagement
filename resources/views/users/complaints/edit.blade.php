<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Edit Complaint - KMC Waste Management</title>
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    </head>
    <body class="bg-gray-100">
        <!-- Navbar -->
        <nav class="bg-white p-4">
            <div class="container mx-auto flex items-center justify-between">
                <!-- Logo -->
                <div class="flex items-center space-x-2">
                    <a href="/" class="bg-cover bg-center w-12 h-12" style="background-image: url('images/KMC_logo.png');" aria-label="Logo"></a>
                    <a href="/" class="text-green-600 text-lg font-bold">KMC Waste Management</a>
                </div>

                <!-- Navigation Links -->
                <ul class="flex space-x-4">
                    <li><a href="/complaints" class="text-green-600 font-bold hover:text-yellow-500">Complaint History</a></li>
                    <li><a href="/" class="text-green-600 font-bold hover:text-yellow-500">Home</a></li>
                    <li><a href="#" class="text-green-600 font-bold hover:text-yellow-500">Schedules</a></li>
                    <li><a href="/complaints/create" class="text-green-600 font-bold hover:text-yellow-500">Complaints</a></li>
                    <li><a href="/products" class="text-green-600 font-bold hover:text-yellow-500">Products</a></li>
                    <li><a href="/recycling-tips" class="text-green-600 font-bold hover:text-yellow-500">Recycling Tips</a></li>
                </ul>

                <div class="space-x-4">
                    @if (Auth::check())
                        <!-- Display user name and logout button -->
                        <div class="relative inline-block text-left">
                            <button class="inline-flex justify-center items-center text-green-600 font-bold hover:text-yellow-500"
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
        </nav>

        <!-- Edit Complaint Form -->
        <div class="container mx-auto p-8">
            <h1 class="text-2xl font-bold mb-6">Edit Complaint</h1>
            <form action="{{ route('complaints.update', $complaint->id) }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 shadow-md rounded-lg">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label for="category" class="block text-gray-700 font-medium mb-2">Category</label>
                    <select name="category" id="category" required class="w-full p-2 border rounded">
                        <option value="Garbage Collection Delay" {{ $complaint->category == 'Garbage Collection Delay' ? 'selected' : '' }}>Garbage Collection Delay</option>
                        <option value="Illegal Dumping" {{ $complaint->category == 'Illegal Dumping' ? 'selected' : '' }}>Illegal Dumping</option>
                        <option value="Recycling Query" {{ $complaint->category == 'Recycling Query' ? 'selected' : '' }}>Recycling Query</option>
                        <option value="Noise/Odor Issues" {{ $complaint->category == 'Noise/Odor Issues' ? 'selected' : '' }}>Noise/Odor Issues</option>
                        <option value="Other" {{ $complaint->category == 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="details" class="block text-gray-700 font-medium mb-2">Details</label>
                    <textarea name="details" id="details" rows="6" required class="w-full p-2 border rounded">{{ $complaint->details }}</textarea>
                </div>
                <div class="mb-4">
                    <label for="file" class="block text-gray-700 font-medium mb-2">Attach File (Optional)</label>
                    <input type="file" name="file" id="file" class="w-full p-2 border rounded">
                </div>
                <div class="mb-4">
                    <label for="date" class="block text-gray-700 font-medium mb-2">Date</label>
                    <input type="date" name="date" id="date" value="{{ $complaint->date }}" required class="w-full p-2 border rounded">
                </div>
                <div class="mb-4">
                    <label for="address" class="block text-gray-700 font-medium mb-2">Address</label>
                    <input type="text" name="address" id="address" value="{{ $complaint->address }}" required class="w-full p-2 border rounded">
                </div>
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">Update Complaint</button>
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
        </script>
    </body>
</html>
