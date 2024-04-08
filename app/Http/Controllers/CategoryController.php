<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\User;
class CategoryController extends Controller
{
    public function index()
    {
    $categories = Category::all(); 
    $users = User::where('role', '!=', 'admin')->get();
    $sellers = $users->where('role', 'seller')->take(4);
    return view('dashboard.category', compact('categories', 'sellers'));
    }


    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Category deleted successfully');
    }

    public function update(Request $request, Category $category)
{
    // Validate form data
    $request->validate([
        'category_name' => 'required|string|max:255',
        'category_image' => 'image|mimes:jpeg,png,jpg,gif|max:2048' // Assuming image upload
    ]);

    // Update category
    $category->name = $request->input('category_name');
    
    // Check if new image uploaded
    if ($request->hasFile('category_image')) {
        $image = $request->file('category_image');
        $imageName = time().'.'.$image->extension();
        $image->move(public_path('images'), $imageName);
        $category->image = $imageName;
    }

    $category->save();

    return redirect()->route('categories.index')->with('success', 'Category updated successfully');
}

}