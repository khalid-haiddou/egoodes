<?php

namespace App\Http\Controllers;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        // Get the currently logged-in user
        $user = Auth::user();

        // Fetch only the orders related to the seller's products
        $orders = Order::whereHas('product', function ($query) use ($user) {
            $query->where('seller_id', $user->id);
        })->get();

        // Pass the orders to the view
        return view('dashboard.orders', ['orders' => $orders]);
    }
}
