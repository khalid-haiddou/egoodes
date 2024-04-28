<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
class OrderController extends Controller
{
    public function index()
    {
        // Get the currently logged-in user
        $user = Auth::user();
        $orders = Order::whereHas('product', function ($query) use ($user) {
            $query->where('seller_id', $user->id);
        })->get();

        // Pass the orders to the view
        return view('dashboard.orders', ['orders' => $orders]);
    }

    public function allOrders()
    {
        $Orders = Order::all(); 
        $users = User::where('role', '!=', 'admin')->get();
        $sellers = $users->where('role', 'seller')->take(4);
        $categories = Category::all();
        $Products = Product::all();
        return view('dashboard.all-orders', compact('Orders', 'sellers', 'categories', 'Products', 'users'));
    }
}
