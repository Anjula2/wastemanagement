<?php

namespace App\Http\Controllers;

use App\Models\WasteOrder;
use App\Models\SellableWaste;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function recyclingtips()
    {
        return view('users.recyclingtips.recycling-tips');
    }

    public function companycart()
    {
        $wasteOrders = WasteOrder::where('user_id', Auth::id())->get();

        $orderCount = WasteOrder::where('user_id', Auth::id())->count(); 

        return view('company.companycart', compact('wasteOrders', 'orderCount'));
    }

    public function wasteorders()
    {
        $data = SellableWaste::all();

        $orderCount = WasteOrder::where('user_id', Auth::id())->count();
        return view('company.wasteorders', compact('data', 'orderCount'));
    }
}
