<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
class ProductController extends Controller
{
    public function store(Request $request)
    {   
        
    // Validate the incoming request data
    $validatedData = $request->validate([
        'title' => 'required|string',
        'description' => 'required|string',
        'category' => 'required|exists:categories,id',
        'price' => 'required|numeric',
        'quantity' => 'required|integer',
        'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'short_description' => 'required|string',
        'status' => 'required|in:available,out_of_stock',
    ]);
    // dd($validatedData);
    // Get the authenticated seller's ID
    $sellerId = auth()->id();

    // Store the product
    $product = new Product();
    $product->title = $validatedData['title'];
    $product->description = $validatedData['description'];
    $product->category = $validatedData['category'];
    $product->price = $validatedData['price'];
    $product->quantity = $validatedData['quantity'];
    $product->short_description = $validatedData['short_description'];
    $product->status = $validatedData['status'];
    $product->seller_id = $sellerId;
    $product->image = $request->file('image')->store('images', 'public');
    $product->save();
    return redirect()->back()->with('success', 'Product created successfully.');
}
        
public function index()
{
    $sellerId = auth()->id();
    $categories = Category::all();
    // Retrieve products belonging to the authenticated seller
    $products = Product::where('seller_id', $sellerId)->get();

    return view('dashboard.seller', compact('products', 'categories'));
}
    
public function destroy(Product $product)
{
    $product->delete();
    return redirect()->back()->with('success', 'Product deleted successfully.');
}
public function home()
{
    $categories = Category::all();
    $products = Product::all();

    return view('pages.home', compact('products', 'categories'));
}
public function detail($id)
{
    $categories = Category::all();
    $product = Product::findOrFail($id);
    return view('pages.detail', compact('product', 'categories'));
}


}