<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Create Product - KMC Waste Management</title>
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    </head>
    <body class="bg-gray-100">
        <div class="container mx-auto py-8">
            <h1 class="text-2xl font-bold text-center mb-8">Add New Product</h1>
            <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="max-w-md mx-auto bg-white p-6 rounded shadow-md">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Product Name</label>
                    <input type="text" name="name" class="w-full border border-gray-300 p-2 rounded" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Category</label>
                    <select name="category" class="w-full border border-gray-300 p-2 rounded" required>
                        option value="">Select Category</option>
                        <option value="Bins">Bins</option>
                        <option value="Compost Bins">Compost Bins</option>
                        <option value="Compost & Fertilizer">Compost & Fertilizer</option>
                        <option value="Other Products">Other Products</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Description</label>
                    <textarea name="description" class="w-full border border-gray-300 p-2 rounded" required></textarea>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Price</label>
                    <input type="number" step="0.01" name="price" class="w-full border border-gray-300 p-2 rounded" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Stock Level</label>
                    <input type="number" name="stock_level" class="w-full border border-gray-300 p-2 rounded" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Product Image</label>
                    <input type="file" name="image" class="w-full border border-gray-300 p-2 rounded" required>
                </div>
                <button type="submit" class="w-full bg-green-600 text-white p-2 rounded font-semibold">Add Product</button>
            </form>
        </div>

        <footer class="bg-green-600 py-4">
            <div class="container mx-auto text-center text-white">
                <p>&copy; 2024 KMC Waste Management. All rights reserved.</p>
            </div>
        </footer>
    </body>

</html>
