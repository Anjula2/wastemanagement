<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WasteOrder;
use App\Models\SellableWaste; 
use Illuminate\Support\Facades\Auth;

class WasteOrderController extends Controller
{
    public function placeOrder(Request $request)
{
    $validated = $request->validate([
        'type' => 'required|exists:sellable_wastes,waste_type_id', 
        'name' => 'required|string|max:255',
        'address' => 'required|string|max:255',
        'contact_number' => 'required|digits:10',
        'quantity' => 'required|numeric|min:1',
    ]);

    $sellableWaste = SellableWaste::where('waste_type_id', $validated['type'])->firstOrFail();

    if ($sellableWaste->stock_level < $validated['quantity']) {
        return redirect()->back()->with('error', 'Insufficient stock available.');
    }

    $totalPrice = $sellableWaste->price * $validated['quantity'];

    $order = new WasteOrder([
        'user_id' => auth()->id(),
        'waste_type_id' => $validated['type'],
        'waste_type' => $sellableWaste->waste_type, 
        'company_name' => $validated['name'],
        'address' => $validated['address'],
        'contact_number' => $validated['contact_number'],
        'quantity' => $validated['quantity'],
        'price_per_ton' => $sellableWaste->price,
        'total_price' => $totalPrice,
        'status' => 'pending',
        'is_completed' => false,
    ]);

    $order->save();

    $sellableWaste->stock_level -= $validated['quantity'];
    $sellableWaste->save();

    return redirect()->back()->with('success', 'Order placed successfully');
}

public function cancel(WasteOrder $order)
{
    if ($order->user_id !== Auth::id()) {
        return redirect()->route('company.wasteorders')->with('error', 'Unauthorized access');
    }

    if ($order->status === 'pending') {
        $sellableWaste = SellableWaste::find($order->waste_type_id);
        
        if ($sellableWaste) {
            $sellableWaste->stock_level += $order->quantity;
            $sellableWaste->save();
        }

        $order->delete(); 

        return redirect()->route('company.companycart')->with('success', 'Order canceled successfully');
    }

    return redirect()->route('company.companycart')->with('error', 'Order cannot be canceled as it is already completed');
}



}

