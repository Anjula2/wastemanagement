<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\CartItem;
use App\Models\Review;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();

        $orderCount = Order::where('user_id', Auth::id())->count(); 
        return view('users.products.index', compact('products','orderCount'));
    }

    public function adminIndex()
    {
        $products = Product::all();
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        return view('admin.products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'category' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'stock_level' => 'required|integer',
            'image' => 'required|image'
        ]);
        $path = $request->file('image')->store('images', 'public');


        Product::create([
            'name' => $request->name,
            'category' => $request->category,
            'description' => $request->description,
            'price' => $request->price,
            'stock_level' => $request->stock_level,
            'image_path' => $path
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Product added successfully!');
    }

    /**
    * Show the form for editing the specified product.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */

    public function edit($id)
    {
        // Find the product by ID
        $product = Product::findOrFail($id);
 
        // Pass the product to the edit view
        return view('admin.products.edit', compact('product'));
    }
 
    /**
    * Update the specified product in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function update(Request $request, $id)
    {
        // Validate incoming request data
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'stock_level' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
 
        // Find the product
        $product = Product::findOrFail($id);
 
        // Update product fields
        $product->name = $request->input('name');
        $product->category = $request->input('category');
        $product->description = $request->input('description');
        $product->price = $request->input('price');
        $product->stock_level = $request->input('stock_level');
 
        // Handle image upload if a new image is provided
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('public/images');
            $product->image_path = $imagePath;
        }
 
        // Save the updated product
        $product->save();
 
        // Redirect back to the products index with a success message
        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy($id)
    {
        // Find the product by ID
        $product = Product::findOrFail($id);

        // Delete the product
        $product->delete();

        // Redirect to the products index with a success message
        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully.');
    }


    public function show($id)
    {
        $product = Product::findOrFail($id);

        // Get product reviews and calculate average rating
        $reviews = $product->reviews()->with('user')->latest()->get();
        $averageRating = $product->reviews()->avg('stars') ?? 0;

        return view('users.products.show', compact('product', 'reviews', 'averageRating'));
    }

}

