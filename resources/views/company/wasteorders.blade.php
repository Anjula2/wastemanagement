<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buy Plastic Waste</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body class="bg-gray-100" style="background-image: url('/images/wasteorderBG.jpg'); 
             background-size: cover; 
             background-position: center; 
             background-repeat: no-repeat; 
             background-attachment: fixed;">
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
    <header class="bg-gradient-to-r from-green-700 to-blue-600 p-4 shadow-lg text-white py-4">
        <h1 class="text-center text-2xl font-bold">Buy Plastic & Polythene Waste</h1>
    </header>

    <div class="container mx-auto p-6 bg-white shadow-md mt-6 rounded-md mb-8">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Available Plastic Waste</h2>
        <table class="w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-blue-600 text-white">
                    <th class="border border-gray-300 px-4 py-2">ID</th>
                    <th class="border border-gray-300 px-4 py-2">Waste Type</th>
                    <th class="border border-gray-300 px-4 py-2">Quantity</th>
                    <th class="border border-gray-300 px-4 py-2">Price per ton</th>
                    <th class="border border-gray-300 px-4 py-2">Description</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $sellable_waste)
                    <tr class="text-center">
                        <td class="border border-gray-300 px-4 py-2">{{$sellable_waste->waste_type_id}}</td>
                        <td class="border border-gray-300 px-4 py-2">{{$sellable_waste->waste_type}}</td>
                        <td class="border border-gray-300 px-4 py-2">{{$sellable_waste->stock_level}} Tons</td>
                        <td class="border border-gray-300 px-4 py-2">Rs. {{number_format($sellable_waste->price, 2)}}</td>
                        <td class="border border-gray-300 px-4 py-2">
                            @if(!empty($sellable_waste->description))
                                {!! nl2br(e($sellable_waste->description)) !!}
                            @else
                                <span class="text-gray-500">No Description</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="form-container mt-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Place an Order</h2>
        @if (session('success'))
        <div id="successMessage" 
        class="flex items-center justify-between bg-gradient-to-r from-green-300 via-green-200 to-green-300 border border-green-400 text-green-800 px-4 py-3 rounded relative mb-4 shadow-md" role="alert"
>          <span class="flex items-center">
               <!-- Icon -->
               <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
               <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
               </svg>
                    {{ session('success') }}
              </span>
        <button 
            type="button" 
            class="text-green-500 hover:text-green-700 focus:outline-none ml-4"
            onclick="document.getElementById('successMessage').style.display='none';">

        <!-- Close Icon -->
          <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
          </svg>
        </button>
      </div>
       @endif
       @if (session('error'))
    <div id="error-message" class="bg-red-100 text-red-800 p-4 rounded mb-4 relative">
        <span>{{ session('error') }}</span>
        <button 
            class="absolute top-0 right-0 mt-2 mr-2 text-red-800 font-bold hover:text-red-600" 
            onclick="document.getElementById('error-message').style.display='none';">
            &times;
        </button>
    </div>
@endif
            <form action="{{ url('placeorder') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                   <label for="type" class="block text-sm font-medium text-gray-700">Plastic Type</label>
                   <select id="type" name="type" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                   <option value="">Select a Waste Type</option>
                    @foreach($data as $sellable_waste)
                        <option value="{{ $sellable_waste->waste_type_id }}" data-price="{{ $sellable_waste->price }}">
                            {{ $sellable_waste->waste_type }}
                        </option>
                    @endforeach
                   </select>
                </div>
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Company Name</label>
                    <input type="text" id="name" name="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>
                <div>
                    <label for="address" class="block text-sm font-medium text-gray-700">Company Address</label>
                    <input type="text" id="address" name="address" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>
                <div>
                    <label for="contact_number" class="block text-sm font-medium text-gray-700">Contact Number</label>
                    <input type="tel" id="contact_number" name="contact_number" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" placeholder="Enter your contact number" />
                </div>
                <div>
                    <label for="quantity" class="block text-sm font-medium text-gray-700">Quantity (ton)</label>
                    <input type="number" id="quantity" name="quantity" required min="1" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>
                <div>
                    <label for="total" class="block text-sm font-medium text-gray-700">Total Price (Rs.)</label>
                    <input type="text" id="total" name="total" readonly class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-100" value="Rs: 0.00">
                </div>

                <!-- Order Receipt Section -->
                <div id="order-receipt" class="mt-6 hidden">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4">Order Receipt</h2>
                    <div class="bg-white p-6 rounded-xl shadow-lg border-t-4 border-blue-500">
                        <div class="space-y-4">
                             <p class="text-lg">
                                <i class="fas fa-building text-blue-600"></i>
                                <strong class="ml-2">Company Name:</strong> 
                                <span id="receipt-company-name" class="font-semibold text-blue-600"></span>
                            </p>
                            <p class="text-lg">
                                <i class="fas fa-map-marker-alt text-blue-600"></i>
                                <strong class="ml-2">Company Address:</strong> 
                                <span id="receipt-company-address" class="font-semibold text-blue-600"></span>
                            </p>
                            <p class="text-lg">
                                <i class="fas fa-phone text-blue-600"></i>
                                <strong class="ml-2">Contact Number:</strong> 
                                <span id="receipt-contact-number" class="font-semibold text-blue-600"></span>
                            </p>
                            <p class="text-lg">
                                <i class="fas fa-recycle text-blue-600"></i>
                                <strong class="ml-2">Waste Type:</strong> 
                                <span id="receipt-type" class="font-semibold text-blue-600"></span>
                            </p>
                            <p class="text-lg">
                                <i class="fas fa-weight-hanging text-blue-600"></i>
                                <strong class="ml-2">Quantity:</strong> 
                                <span id="receipt-quantity" class="font-semibold text-blue-600"></span> Tons
                            </p>
                            <p class="text-lg">
                                <i class="fas fa-dollar-sign text-blue-600"></i>
                                <strong class="ml-2">Total Price:</strong> 
                                <span id="receipt-total" class="font-semibold text-yellow-700 bg-yellow-100 px-2 py-1 rounded-full"></span>
                            </p>
                        </div>
                    </div>
                </div>

                <div>
                    <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700">
                        Place Order
                    </button>
                </div>
            </form>
        </div>
    </div>

    <footer class="bg-green-600 py-4">
        <div class="container mx-auto text-center text-white">
            <p>&copy; 2024 KMC Waste Management. All rights reserved.</p>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const quantityInput = document.getElementById('quantity');
            const typeSelect = document.getElementById('type');
            const companyNameInput = document.getElementById('name');
            const companyAddressInput = document.getElementById('address');
            const contactNumberInput = document.getElementById('contact_number');
            const totalPriceInput = document.getElementById('total');
            const receiptSection = document.getElementById('order-receipt');
            const receiptType = document.getElementById('receipt-type');
            const receiptQuantity = document.getElementById('receipt-quantity');
            const receiptTotal = document.getElementById('receipt-total');
            const receiptCompanyName = document.getElementById('receipt-company-name');
            const receiptCompanyAddress = document.getElementById('receipt-company-address');
            const receiptContactNumber = document.getElementById('receipt-contact-number');

            typeSelect.addEventListener('change', updatePrice);
            quantityInput.addEventListener('input', updatePrice);

            function updatePrice() {
                const selectedWaste = typeSelect.selectedOptions[0];
                const pricePerTon = parseFloat(selectedWaste.getAttribute('data-price') || 0);
                const quantity = parseFloat(quantityInput.value || 0);
                const totalPrice = pricePerTon * quantity;

                totalPriceInput.value = `Rs: ${totalPrice.toFixed(2)}`;
                
                if (quantity > 0 && selectedWaste.value) {
                    receiptCompanyName.innerText = companyNameInput.value || 'Not Provided';
                    receiptCompanyAddress.innerText = companyAddressInput.value || 'Not Provided';
                    receiptContactNumber.innerText = contactNumberInput.value || 'Not Provided';
                    receiptType.innerText = selectedWaste.innerText;
                    receiptQuantity.innerText = quantity;
                    receiptTotal.innerText = `Rs: ${totalPrice.toFixed(2)}`;
                    receiptSection.classList.remove('hidden');
                } else {
                    receiptSection.classList.add('hidden');
                }
            }
        });
        document.addEventListener('DOMContentLoaded', function() {
           const placeOrderForm = document.querySelector('form');
        if (placeOrderForm) {
            placeOrderForm.addEventListener('submit', function() {
                setTimeout(function() {
                    location.reload();
                }, 1000);
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
