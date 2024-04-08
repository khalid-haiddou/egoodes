<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (auth()->attempt($request->only('email', 'password'))) {
        $user = auth()->user();
        
        if ($user->role === 'admin') {
    return redirect()->route('dashboard.admin');
} elseif ($user->role === 'seller') {
            return redirect()->route('dashboard.seller');
        } else {
            return redirect('/home');
        }
    }

    return back()->withErrors(['email' => 'Invalid credentials.']);
}


    public function showSignupForm()
    {
        return view('auth.login'); 
    }

    public function signup(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8',
        'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048', 
        'role' => 'required',
    ]);

    // Handle file upload
    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('images'), $imageName);
    }

    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => bcrypt($request->password),
        'image' => $imageName ?? null,
        'role' => $request->role, 
    ]);

    return redirect()->route('login')->with('success', 'Signup successful. Please login.');
}

    public function logout()
    {
        Auth::logout(); 
        return redirect()->route('login'); 
    }
    public function showPasswordResetForm()
{
    return view('auth.password_reset');
}

public function index()
{
    $users = User::where('role', '!=', 'admin')->get();
    $sellers = $users->where('role', 'seller')->take(4);
    $buyers = User::where('role', '=', 'user')->get();
    return view('dashboard.admin', compact('users', 'sellers', 'buyers'));
}

   
}