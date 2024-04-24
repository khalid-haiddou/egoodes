<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function checkout(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'phone' => 'required|string',
            'country' => 'required|string',
            'zipCode' => 'required|string',
            'payment_method' => 'required|in:Paypal,Card',
        ]);

        // Get the authenticated user's ID
        $userId = $request->user()->id;

        // Retrieve the cart items for the user
        $cartItems = Cart::where('user_id', $userId)->get();

        // Calculate the total amount based on the cart items
        $totalAmount = $cartItems->sum('price');
       
        $order = new Order();
        $order->user_id = $userId;
        $order->phone = $validatedData['phone'];
        $order->country = $validatedData['country'];
        $order->zip_code = $validatedData['zipCode'];
        $order->cart_id = $cartItems->first()->id;
        $order->total_amount = $totalAmount;
        $order->payment_method = $validatedData['payment_method'];
        $order->status = 'pending'; 
        $order->save();

        // Optionally, you can clear the user's cart after placing the order
        Cart::where('user_id', $userId)->delete();

        return redirect()->route('checkout')->with('success', 'Order placed successfully.');
    }
}
