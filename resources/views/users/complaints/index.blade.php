<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Complaint History - KMC Waste Management</title>
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

        <header class="bg-cover bg-center" style="background-image: url('{{ asset('images/comp2.jpg') }}'); height: 500px;">
            <div class="flex flex-col items-center justify-center h-full bg-gray-500 bg-opacity-20 p-8">
                <h1 class="text-white text-5xl font-bold mb-8">Complaints and Feedback</h1>
            </div>
        </header>

        <!-- Complaint History -->
<div class="container mx-auto p-8">
    <h1 class="text-2xl font-bold mb-6">Your Complaints</h1>

    <!-- Create Complaint Button -->
    <a href="{{ route('users.complaints.create') }}" class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 mb-6 inline-block">
        <i class="fas fa-plus-circle mr-2"></i> File a Complaint
    </a>

    @foreach($complaints as $complaint)
        <div class="bg-white shadow-lg rounded-lg overflow-hidden mb-6 border-t-4" 
             style="border-color: 
                @if($complaint->status === 'Pending') 
                    #d97706; /* yellow-600 */
                @elseif($complaint->status === 'Resolved') 
                    #16a34a; /* green-600 */
                @else 
                    #dc2626; /* red-600 */
                @endif">
            <div class="p-6">
                <!-- Complaint Header -->
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-gray-800">Category: {{ $complaint->category }}</h2>
                    <span class="font-bold text-sm px-3 py-1 rounded-full text-white" 
                        style="background-color: 
                            @if($complaint->status === 'Pending') 
                                #d97706; /* yellow-600 */
                            @elseif($complaint->status === 'Resolved') 
                                #16a34a; /* green-600 */
                            @else 
                                #dc2626; /* red-600 */
                            @endif">
                        {{ ucfirst($complaint->status) }}
                    </span>
                </div>

                <!-- Complaint Details -->
                <div class="space-y-4">
                    <!-- Details Section with Icon -->
                    <div class="flex items-center">
                        <i class="fas fa-info-circle text-blue-600 mr-2"></i>
                        <span class="font-semibold text-gray-600">Details:</span>
                        <p class="ml-2 text-gray-800">{{ $complaint->details }}</p>
                    </div>

                    <!-- Date Section with Icon -->
                    <div class="flex items-center">
                        <i class="fas fa-calendar-alt text-green-600 mr-2"></i>
                        <span class="font-semibold text-gray-600">Date:</span>
                        <p class="ml-2 text-gray-800">{{ $complaint->date }}</p>
                    </div>

                    <!-- Address Section with Icon -->
                    <div class="flex items-center">
                        <i class="fas fa-map-marker-alt text-red-600 mr-2"></i>
                        <span class="font-semibold text-gray-600">Address:</span>
                        <p class="ml-2 text-gray-800">{{ $complaint->address }}</p>
                    </div>

                    <!-- File Attachment Section with Icon -->
                    @if($complaint->file_path)
                        <div class="flex items-center">
                            <i class="fas fa-paperclip text-gray-600 mr-2"></i>
                            <a href="{{ Storage::url($complaint->file_path) }}" class="text-yellow-300 underline mt-2 block">
                                View Attached File
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Complaint Footer -->
            <div class="bg-gray-100 p-4">
                <div class="flex items-center">
                    <i class="fas fa-calendar-check text-black-600 mr-2"></i>
                    <span class="font-semibold text-gray-600">Submitted on:</span>
                    <p class="text-lg font-semibold text-gray-800">{{ $complaint->created_at->format('d M Y, h:i A') }}</p>
                </div>

                @if($complaint->status === 'Pending')
                    <!-- Edit Button -->
                    <a href="{{ route('users.complaints.edit', $complaint->id) }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 mr-2 inline-block mt-6">
                        <i class="fas fa-edit mr-2"></i> Edit
                    </a>
                    <!-- Delete Button -->
                    <form action="{{ route('complaints.destroy', $complaint->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 inline-block mr-2 mt-6">
                            <i class="fas fa-trash-alt mr-2"></i> Delete
                        </button>
                    </form>
                @endif
            </div>
        </div>
    @endforeach
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

    </body>
</html>
