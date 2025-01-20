<?php 

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = CartItem::where('user_id', Auth::id())->get();

        $orderCount = Order::where('user_id', Auth::id())->count(); 

        return view('users.cart.index', compact('cartItems','orderCount'));
    }

    public function add(Product $product)
    {

        if ($product->stock_level <= 0) {
            return redirect()->route('users.cart.index')->with('error', 'Product is out of stock.');
        }

        $cartItem = CartItem::where('user_id', Auth::id())->where('product_id', $product->id)->first();

        if ($cartItem) {
           
            $cartItem->quantity += 1;

            if ($cartItem->quantity > $product->stock_level) {
                return redirect()->route('users.cart.index')->with('error', 'Insufficient stock for ' . $product->name);
            }
        } else {

            $cartItem = new CartItem();
            $cartItem->user_id = Auth::id();
            $cartItem->product_id = $product->id;
            $cartItem->quantity = 1;
        }

        $cartItem->total_price = $product->price * $cartItem->quantity;
        $cartItem->save();

        return redirect()->route('users.cart.index')->with('success', 'Product added to cart successfully!');
    }


    public function update(Request $request, CartItem $cartItem)
    {
        $product = $cartItem->product;

        if ($request->quantity > $product->stock_level) {
            return response()->json(['error' => 'Insufficient stock for ' . $product->name], 400);
        }

        $cartItem->quantity = $request->quantity;
        $cartItem->save();

        return response()->json(['success' => 'Cart item updated successfully', 'quantity' => $cartItem->quantity]);
    }


    public function placeOrder()
    {
        $cartItems = CartItem::with('product')->where('user_id', Auth::id())->get();
        $outOfStock = [];

        foreach ($cartItems as $item) {
            $product = $item->product;

            if ($item->quantity > $product->stock_level) {
                $outOfStock[] = $product->name;
            }
        }

        if (!empty($outOfStock)) {
            return redirect()->route('users.cart.index')->with('error', 'Some items are out of stock: ' . implode(', ', $outOfStock));
        }

        foreach ($cartItems as $item) {
            $product = $item->product;
            $product->stock_level -= $item->quantity;

            $product->save();
        }

        CartItem::where('user_id', Auth::id())->delete();

        return redirect()->route('users.cart.index')->with('success', 'Order placed successfully!');
    }

    public function checkout()
    {
        $cartItems = CartItem::where('user_id', Auth::id())->get();
        return view('users.cart.checkout', compact('cartItems'));
    }

    public function confirmOrder(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'delivery_option' => 'required|in:pickup,delivery',
            'address' => 'required_if:delivery_option,delivery'
        ]);

        $cartItems = CartItem::with('product')->where('user_id', Auth::id())->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('users.cart.index')->with('error', 'Cart is empty!');
        }

        $total = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);
        $deliveryCost = $request->delivery_option === 'delivery' ? 300 : 0;
        $grandTotal = $total + $deliveryCost;


        $order = Order::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'delivery_option' => $request->delivery_option,
            'address' => $request->address,
            'total' => $grandTotal,
        ]);

        foreach ($cartItems as $item) {
            $order->orderItems()->create([
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->product->price,
            ]);

            $item->product->stock_level -= $item->quantity;
            $item->product->save();
        }

        // Clear the cart
        CartItem::where('user_id', Auth::id())->delete();

        return redirect()->route('users.cart.index')->with('success', 'Order confirmed successfully!');
    }

    public function destroy($id)
    {
        $cartItem = CartItem::findOrFail($id);
        $cartItem->delete();
        return response()->json(['message' => 'Item removed successfully']);
    }

    public function clear()
    {
        CartItem::where('user_id', auth()->id())->delete();
        return response()->json(['message' => 'Cart cleared successfully']);
    }

    public function showorders()
    {
        $orders = Order::where('user_id', Auth::id())->get();

        $orderCount = Order::where('user_id', Auth::id())->count(); 
        
        return view('users.cart.showorders', compact('orders','orderCount'));
    }

}
