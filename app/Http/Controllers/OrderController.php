<?php

namespace App\Http\Controllers;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

class OrderController extends Controller
{
    public function showOrders()
    {
        // Fetch orders associated with the currently authenticated user
        $user = Auth::user();
        $orders = $user->orders()->orderBy('created_at', 'desc')->get();

        // Pass the orders data to the view
        return view('dashboard.orders', compact('orders'));
    }
}
