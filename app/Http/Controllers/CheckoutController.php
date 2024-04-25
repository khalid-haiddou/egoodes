<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Cart;
use App\Models\Product;
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

    
    $userId = $request->user()->id;

    $cartItems = Cart::where('user_id', $userId)->get();
    $totalAmount = $cartItems->sum('price');
    $orderIds = [];

    foreach ($cartItems as $cartItem) {
        $order = new Order();
        $order->user_id = $userId;
        $order->phone = $validatedData['phone'];
        $order->country = $validatedData['country'];
        $order->zip_code = $validatedData['zipCode'];
        $order->cart_id = $cartItem->id; 
        $order->total_amount = $cartItem->price;
        $order->payment_method = $validatedData['payment_method'];
        $order->status = 'pending'; 
        $order->save();

        // Add the ID of the saved order to the array
        $orderIds[] = $order->id;
    }

    
    //Cart::where('user_id', $userId)->delete();

    return redirect()->route('checkout')->with('success', 'Order placed successfully.');
}


}
