<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

class RolesController extends Controller
{
    public function index()
    {
    $users = User::where('role', '!=', 'admin')->get();
    $sellers = $users->where('role', 'seller')->take(4);
    return view('dashboard.roles', compact('sellers' , 'users'));
    }

    public function destroy(user $user)
    {
        $user->delete();
        return back()->with('success', 'user deleted successfully.');
    }
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'role' => 'required|in:user,seller,admin',
        ]);
        $user = User::findOrFail($validatedData['user_id']);

        $user->name = $validatedData['name'];
        $user->role = $validatedData['role'];
        $user->save();

        return redirect()->back()->with('success', 'User role and name updated successfully!');
    }
    
}

