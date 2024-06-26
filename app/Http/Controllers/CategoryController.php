<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
class CategoryController extends Controller
{
    public function index()
    {
    $categories = Category::all(); 
    $users = User::where('role', '!=', 'admin')->get();
    $sellers = $users->where('role', 'seller')->take(4);
    $Orders = Order::all();
    $Products = Product::all();
    return view('dashboard.category', compact('categories', 'sellers', 'Orders', 'Products', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $path = explode('/', $request->file('image')->store('images', 'public'))[1];
        $category = new Category();
        $category->name = $request->name;
        $category->image = $path;
        $category->save();
        return back()->with('success', 'Category created successfully.');
    }
    public function destroy(Category $category)
    {
        $category->delete();
    
        return back()->with('success', 'Category deleted successfully.');
    }
    public function update(Request $request, $id)
{
    $category = Category::findOrFail($id);
    $category->name = $request->name;
    $category->save();

    return response()->json(['message' => 'Category updated successfully']);
}
public function home()
{
    // Fetch all categories from the database
    $categories = Category::all(); 

    // Pass the categories to the 'pages.home' view
    return view('pages.home', compact('categories'));
}
}