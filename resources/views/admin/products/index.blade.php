<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Products - KMC Waste Management</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">

<div class="container mx-auto py-8">
    <h1 class="text-2xl font-bold mb-4">Admin Product Management</h1>
    
    <a href="{{ route('admin.products.create') }}" class="bg-green-500 text-white px-4 py-2 rounded mb-4 inline-block">Add New Product</a>
    
    <table class="min-w-full bg-white">
        <thead>
            <tr>
                <th class="py-2 px-4 border-b">ID</th>
                <th class="py-2 px-4 border-b">Name</th>
                <th class="py-2 px-4 border-b">Category</th>
                <th class="py-2 px-4 border-b">Description</th>
                <th class="py-2 px-4 border-b">Price</th>
                <th class="py-2 px-4 border-b">Stock Level</th>
                <th class="py-2 px-4 border-b">Image</th>
                <th class="py-2 px-4 border-b">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
                <tr>
                    <td class="py-2 px-4 border-b">{{ $product->id }}</td>
                    <td class="py-2 px-4 border-b">{{ $product->name }}</td>
                    <td class="py-2 px-4 border-b">{{ $product->category }}</td>
                    <td class="py-2 px-4 border-b">{{ $product->description }}</td>
                    <td class="py-2 px-4 border-b">Rs {{ number_format($product->price, 2) }}</td>
                    <td class="py-2 px-4 border-b">{{ $product->stock_level }}</td>
                    <td class="py-2 px-4 border-b">
                        <img src="{{ Storage::url($product->image_path) }}" alt="{{ $product->name }}" class="w-full h-48 object-cover rounded-lg">

                    </td>
                    <td class="py-2 px-4 border-b">
                        <a href="{{ route('admin.products.edit', $product->id) }}" class="bg-blue-500 text-white px-2 py-1 rounded">Edit</a>
                        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white px-2 py-1 rounded" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

</body>
</html>
