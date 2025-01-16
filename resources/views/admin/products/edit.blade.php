<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-8">
        <h1 class="text-2xl font-bold mb-4">Edit Product</h1>

        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-4 mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded shadow-md">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-gray-700">Name</label>
                <input type="text" name="name" value="{{ $product->name }}" class="w-full p-2 border rounded">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Category</label>
                <select name="category" class="w-full p-2 border rounded">
                    <option value="Bins" {{ $product->category == 'Bins' ? 'selected' : '' }}>Bins</option>
                    <option value="Compost Bins" {{ $product->category == 'Compost Bins' ? 'selected' : '' }}>Compost Bins</option>
                    <option value="Compost & Fertilizer" {{ $product->category == 'Compost & Fertilizer' ? 'selected' : '' }}>Compost & Fertilizer</option>
                    <option value="Other Products" {{ $product->category == 'Other Products' ? 'selected' : '' }}>Other Products</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Description</label>
                <textarea name="description" class="w-full p-2 border rounded">{{ $product->description }}</textarea>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Price</label>
                <input type="text" name="price" value="{{ $product->price }}" class="w-full p-2 border rounded">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Stock Level</label>
                <input type="number" name="stock_level" value="{{ $product->stock_level }}" class="w-full p-2 border rounded">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Image</label>
                <input type="file" name="image" class="w-full p-2 border rounded">
                @if ($product->image_path)
                    <img src="{{ Storage::url($product->image_path) }}" alt="{{ $product->name }}" class="w-32 mt-2">
                @endif
            </div>

            <div>
                <button type="submit" class="bg-green-500 text-white p-2 rounded">Update Product</button>
            </div>
        </form>
    </div>
</body>
</html>
